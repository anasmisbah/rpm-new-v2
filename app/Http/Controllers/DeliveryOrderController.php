<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesOrder;
use App\Customer;
use App\DeliveryOrder;
use GuzzleHttp\Client;
use App\Company;
use Carbon\Carbon;
use App\Notifdo;
use DataTables;
use App\Product;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use File;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $agen = $sales_order->agen;
        return view('delivery_order.index',compact('sales_order','agen'));
    }

    public function deliveryorder_data($id)
    {
        $do = DeliveryOrder::select(['id','delivery_order_number','effective_date_start','effective_date_end','shipped_via','status'])->orderBy('id','desc')
                    ->where('sales_order_id',$id);

        $dataTable = DataTables::of($do)
        ->addIndexColumn()
        ->addColumn('effective_date', function ($data) {
            return   $data->effective_date_start->day." ".$data->effective_date_start->monthName." ".$data->effective_date_start->year.' - '.$data->effective_date_start->day." ".$data->effective_date_start->monthName." ".$data->effective_date_start->year;

        })
        ->removeColumn('effective_date_start')
        ->removeColumn('effective_date_end')
        ->addColumn('url_notif', function ($data) {
            return route('deliveryorder.agen.notif',$data->id);
        })
        ->addColumn('url_notif_driver', function ($data) {
            return route('deliveryorder.agen.driver.notif',$data->id);
        })
        ->addColumn('url_detail', function ($data) {
            return route('deliveryorder.agen.show',$data->id);
        })
        ->addColumn('url_edit', function ($data) {
            return route('deliveryorder.agen.edit',$data->id);
        })
        ->addColumn('url_delete', function ($data) {
            return route('deliveryorder.agen.destroy',$data->id);
        })
        ->addColumn('url_download', function ($data) {
            return route('deliveryorder.agen.download',$data->id);
        });

        return $dataTable->make(true);
    }


    public function show($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        $time = Carbon::createFromTimeString($delivery_order->estimate);
        $jam = '';
        if ($time->hour != 0) {
            $jam = "$time->hour jam";
        }
        $menit = '';
        if ($time->minute != 0) {
            $menit = "$time->minute menit";
        }
        $estimate = $jam.' '.$menit;

        $quantity_terbilang = $this->terbilang($delivery_order->quantity)." ".$delivery_order->piece;
        return view('delivery_order.detail',compact('sales_order','agen','delivery_order','estimate','quantity_terbilang'));
    }

    public function create($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $products = Product::all();
        $agen = $sales_order->agen;
        $drivers = $agen->drivers;
        $do_date = Carbon::now();
        return view('delivery_order.create',compact('sales_order','agen','drivers','do_date','products'));
    }

    public function store(Request $request,$id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $agen = $sales_order->agen;

        $request->validate([
            'delivery_order_number'=>'required|unique:delivery_orders',
            'effective_date_start'=>'required',
            'effective_date_end'=>'required',
            'quantity'=>'required',
            'shipped_with'=>'required',
            'no_vehicles'=>'required',
            'top_seal'=>'required',
            'bottom_seal'=>'required',
            'temperature'=>'required',
            'jam'=>'required',
            'menit'=>'required',
            'driver_id'=>'required',
            'product_id'=>'required',
            'depot'=>'required',
            'piece'=>'required',

        ]);

        $data = [
            'delivery_order_number'=>$request->delivery_order_number,
            'effective_date_start'=>$request->effective_date_start,
            'effective_date_end'=>$request->effective_date_end,
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity,
            'shipped_with'=>$request->shipped_with,
            'no_vehicles'=>$request->no_vehicles,
            'top_seal'=>$request->top_seal,
            'bottom_seal'=>$request->bottom_seal,
            'temperature'=>$request->temperature,
            'km_start'=>$request->km_start,
            'km_end'=>$request->km_end,
            'sg_meter'=>$request->sg_meter,
            'status'=>0,
            'estimate'=>$request->jam.':'.$request->menit,
            'driver_id'=>$request->driver_id,
            'distribution'=>$request->distribution,
            'admin_name'=>$request->admin_name,
            'knowing'=>$request->knowing,
            'depot'=>$request->depot,
            'piece'=>$request->piece,
            'detail_address'=>$request->detail_address,
            'address_transportir'=>$request->address_transportir,
            'quantity_text'=>$request->quantity_text,
            'transportir'=>$request->transportir,
        ];

        $path_qr_code = 'qrcodes/'.time().''.$request->delivery_order_number.'.svg';
        QrCode::format('svg')->size(300)->generate($request->delivery_order_number, public_path('/uploads/'.$path_qr_code));

        $data['qrcode']=$path_qr_code;



        $delivery_order = $sales_order->delivery_orders()->create($data);
        // if (count($request->shipped_via) == 2) {
        //     $data['shipped_via'] = 2;
        // }else{
        //     $data['shipped_via'] = $request->shipped_via[0];
        // }
        $delivery_order->update([
            'shipped_via'=>$delivery_order->driver->route,
        ]);

        $date = Carbon::now();
        $fcm_token = [];
        $title = 'Delivery Order';
        $message = "Dari Patra Niaga - Agent. DO No $delivery_order->delivery_order_number telah terbit. $delivery_order->shipped_with $delivery_order->no_vehicles sudah dapat melakukan Proses Pengisian BBM ";

        // SEND NOTIF TO AGEN TO GET ACCEPTED
        $fcm_token[] = $sales_order->agen->user->fcm_token;
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message,$title,$fcm_token,$data_notif);

        Notifdo::updateOrCreate([
            'description'=>$message,
        ],[
            'date'=>$date,
            'delivery_order_id'=>$delivery_order->id
        ]);

        // SEND NOTIF TO CUSTOMER
        $fcm_token_customer = [
            $sales_order->customer->user->fcm_token
        ];
        $title_customer = 'Sales Order';
        $message_customer = 'SO No '. $delivery_order->sales_order->sales_order_number .' telah terbit';

        Notifdo::updateOrCreate([
            'description'=>$message_customer,
        ],
        [
            'date'=>$delivery_order->sales_order->created_at,
            'delivery_order_id'=>$delivery_order->id,
        ]);

        return redirect()->back()->with('status','successfully created Delivery Order');
    }

    public function edit($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        $drivers = $agen->drivers;
        $estimate = Carbon::createFromTimeString($delivery_order->estimate);
        $quantity_terbilang = $this->terbilang($delivery_order->quantity)." ".$delivery_order->piece;
        $products = Product::all();
        return view('delivery_order.edit',compact('sales_order','agen','delivery_order','estimate','drivers','quantity_terbilang','products'));
    }

    public function update(Request $request,$id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $request->validate([
            'delivery_order_number'=>'required|unique:delivery_orders,delivery_order_number,'.$delivery_order->delivery_order_number,
            'effective_date_start'=>'required',
            'effective_date_end'=>'required',
            'product_id'=>'required',
            'quantity'=>'required',
            'shipped_with'=>'required',
            'no_vehicles'=>'required',
            'top_seal'=>'required',
            'bottom_seal'=>'required',
            'temperature'=>'required',
            'jam'=>'required',
            'menit'=>'required',
            'driver_id'=>'required',
            'depot'=>'required',
            'piece'=>'required',
        ]);

        $data = [
            'delivery_order_number'=>$request->delivery_order_number,
            'effective_date_start'=>$request->effective_date_start,
            'effective_date_end'=>$request->effective_date_end,
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity,
            'shipped_with'=>$request->shipped_with,
            'no_vehicles'=>$request->no_vehicles,
            'top_seal'=>$request->top_seal,
            'bottom_seal'=>$request->bottom_seal,
            'temperature'=>$request->temperature,
            'km_start'=>$request->km_start,
            'km_end'=>$request->km_end,
            'sg_meter'=>$request->sg_meter,
            'estimate'=>$request->jam.':'.$request->menit,
            'driver_id'=>$request->driver_id,
            'distribution'=>$request->distribution,
            'admin_name'=>$request->admin_name,
            'knowing'=>$request->knowing,
            'depot'=>$request->depot,
            'piece'=>$request->piece,
            'quantity_text'=>$request->quantity_text,
            'detail_address'=>$request->detail_address,
            'transportir'=>$request->transportir,
            'address_transportir'=>$request->address_transportir,
        ];

        File::delete('uploads/'.$delivery_order->qrcode);
        $path_qr_code = 'qrcodes/'.time().''.$request->delivery_order_number.'.svg';
        QrCode::format('svg')->size(300)->generate($request->delivery_order_number, public_path('/uploads/'.$path_qr_code));

        $data['qrcode']=$path_qr_code;


        $delivery_order->update($data);
        $delivery_order->update([
            'shipped_via'=>$delivery_order->driver->route,
        ]);
        return redirect()->route('deliveryorder.agen.show',$delivery_order->id)->with('status','successfully updated Delivery Order');;
    }

    public function destroy($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $delivery_order->delete();
        return redirect()->back()->with('status','successfully deleted Delivery Order');
    }

    private function sendNotif($message, $title, $fcm_token,$data_notif)
    {
        $client = new Client();

        // headers
        $headers  = [
            'Authorization'   =>  'key=AAAAI51BmkM:APA91bHi553h03fliFvw5fN-AWhW1evqqnFzhc3YmnrqI4FBcZh1DhJsMQHQc2hW8GcblxdYyvqR2GzJBEK1vW3V3brsGlriDryBc3A6HArZDbnk4C506AaqjrbTEr7NO72mKKZ-TPkU',
            'Content-Type'    =>  'application/json'
        ];

        // body
        $body = [
            'registration_ids'  =>  $fcm_token,
            'notification'      =>  [
            'body'  =>  $message,
            'title' =>  $title
            ],
            'data'=>$data_notif
      ];
      $response   = $client->post('https://fcm.googleapis.com/fcm/send', ['headers' => $headers, 'json' => $body]);

      return response()->json($response->getBody()->getContents());

    }

    public function print($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        $company = Company::first();
        $date = Carbon::now();
        $quantity_terbilang = ucfirst($this->terbilang($delivery_order->quantity)." ".$delivery_order->piece);

        return view('delivery_order.print4',compact('sales_order','agen','delivery_order','company','date','quantity_terbilang'));
    }

    public function push_notif($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $date = Carbon::now();
        $fcm_token = [];
        $title = 'Delivery Order';
        $message = "Dari Patra Niaga - Agent. DO No $delivery_order->delivery_order_number telah terbit. $delivery_order->shipped_with $delivery_order->no_vehicles sudah dapat melakukan Proses Pengisian BBM ";

        // SEND NOTIF TO AGEN TO GET ACCEPTED
        $fcm_token[] = $sales_order->agen->user->fcm_token;
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message,$title,$fcm_token,$data_notif);

        Notifdo::updateOrCreate([
            'description'=>$message,
        ],[
            'date'=>$date,
            'delivery_order_id'=>$delivery_order->id
        ]);

        // SEND NOTIF TO CUSTOMER
        $fcm_token_customer = [
            $sales_order->customer->user->fcm_token
        ];
        $title_customer = 'Sales Order';
        $message_customer = 'SO No '. $delivery_order->sales_order->sales_order_number .' telah terbit';

        Notifdo::updateOrCreate([
            'description'=>$message_customer,
        ],
        [
            'date'=>$delivery_order->sales_order->created_at,
            'delivery_order_id'=>$delivery_order->id,
        ]);

        return redirect()->back()->with('status','Successfully send notif delivery order '.$delivery_order->delivery_order_number);
    }
    public function notif_driver($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $fcm_token = [];
        $title = 'Delivery Order';
        $message = "Dari Agent - Driver. DO No $delivery_order->delivery_order_number telah terbit. $delivery_order->shipped_with $delivery_order->no_vehicles sudah dapat melakukan Proses Pengisian BBM ";
        $fcm_token[] = $delivery_order->driver->user->fcm_token;
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message,$title,$fcm_token,$data_notif);

        return redirect()->back()->with('status','Successfully send notif delivery order '.$delivery_order->delivery_order_number);
    }

    public function download_excel($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        $date = Carbon::now();
        $quantity_terbilang = ucwords($this->terbilang($delivery_order->quantity)." ".$delivery_order->piece);

        // return Excel::download(new DeliveryOrderExport($id), 'invoices.xlsx');
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load(public_path('uploads/excels/template.xlsx'));

        $spreadsheet->getActiveSheet()->setCellValue('I4', $delivery_order->delivery_order_number);
        $spreadsheet->getActiveSheet()->setCellValue('I6', $delivery_order->depot." ".$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year);
        $spreadsheet->getActiveSheet()->setCellValue('I7', $sales_order->sales_order_number);
        $spreadsheet->getActiveSheet()->setCellValue('D10', $sales_order->customer->name);
        $spreadsheet->getActiveSheet()->setCellValue('K10', $agen->name);
        $spreadsheet->getActiveSheet()->setCellValue('B19', $delivery_order->effective_date_start->day." - ".$delivery_order->effective_date_end->day." ".$delivery_order->effective_date_end->monthName." ".$delivery_order->effective_date_end->year);
        $spreadsheet->getActiveSheet()->setCellValue('G19', $delivery_order->product->name);
        $spreadsheet->getActiveSheet()->setCellValue('K19', number_format($delivery_order->quantity,0,'.','.')." ".$delivery_order->piece);
        $spreadsheet->getActiveSheet()->setCellValue('C21', $delivery_order->shipped_with);
        $spreadsheet->getActiveSheet()->setCellValue('H22', $delivery_order->top_seal);
        $spreadsheet->getActiveSheet()->setCellValue('C23', $delivery_order->no_vehicles);
        $spreadsheet->getActiveSheet()->setCellValue('H25', $delivery_order->bottom_seal);
        $spreadsheet->getActiveSheet()->setCellValue('C28', $delivery_order->sg_meter);
        $spreadsheet->getActiveSheet()->setCellValue('H28', $delivery_order->temperature." C");
        $spreadsheet->getActiveSheet()->setCellValue('C31', "# ".$quantity_terbilang." #");
        $spreadsheet->getActiveSheet()->setCellValue('L36', $delivery_order->driver->name);
        $spreadsheet->getActiveSheet()->setCellValue('B40', $delivery_order->admin_name);
        $spreadsheet->getActiveSheet()->setCellValue('F40', $delivery_order->knowing);

        $file_name = "SPP ".$delivery_order->delivery_order_number;
        if (file_exists('uploads/excels/'.$file_name)) {
            File::delete('uploads/excels/'.$file_name);
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save(public_path("uploads/excels/$file_name.xlsx"));
        return response()->download(public_path("uploads/excels/$file_name.xlsx"));
    }

    private function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }
        return $temp;
    }

    private function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }

}
