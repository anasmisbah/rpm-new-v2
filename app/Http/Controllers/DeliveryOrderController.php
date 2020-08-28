<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesOrder;
use App\Customer;
use App\DeliveryOrder;
use GuzzleHttp\Client;
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
    public function show($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        return view('delivery_order.detail',compact('sales_order','agen','delivery_order'));
    }

    public function create($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $agen = $sales_order->agen;
        return view('delivery_order.create',compact('sales_order','agen'));
    }

    public function store(Request $request,$id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $agen = $sales_order->agen;
        $request->validate([
            'delivery_order_number'=>'required',
            'effective_date_start'=>'required',
            'effective_date_end'=>'required',
            'product'=>'required',
            'quantity'=>'required',
            'shipped_with'=>'required',
            'shipped_via'=>'required',
            'no_vehicles'=>'required',
            'top_seal'=>'required',
            'bottom_seal'=>'required',
            'temperature'=>'required',
            'customer_id'=>'required'
        ]);

        $data = [
            'delivery_order_number'=>$request->delivery_order_number,
            'effective_date_start'=>$request->effective_date_start,
            'effective_date_end'=>$request->effective_date_end,
            'product'=>$request->product,
            'quantity'=>$request->quantity,
            'shipped_with'=>$request->shipped_with,
            'no_vehicles'=>$request->no_vehicles,
            'top_seal'=>$request->top_seal,
            'bottom_seal'=>$request->bottom_seal,
            'temperature'=>$request->temperature,
            'customer_id'=>$request->customer_id,
            'km_start'=>$request->km_start,
            'km_end'=>$request->km_end,
            'sg_meter'=>$request->sg_meter,
            'status'=>0,
        ];

        if (count($request->shipped_via) == 2) {
            $data['shipped_via'] = 2;
        }else{
            $data['shipped_via'] = $request->shipped_via[0];
        }

        $sales_order->delivery_orders()->create($data);

        $fcm_token = [];
        if ($data['shipped_via'] == 0) {
            // SEND NOTIF TO JALUR DARAT
            $drivers = $agen->drivers()->where('route',0)->get();
            foreach ($drivers as $driver) {
                $fcm_token[] = $driver->user->fcm_token;
            }
            // $this->sendNotif($message,$title,$fcm_token);
        }else if($data['shipped_via'] == 1){
            // SEND NOTIF TO JALUR LAUT

            $drivers = $agen->drivers()->where('route',1)->get();
            foreach ($drivers as $driver) {
                $fcm_token[] = $driver->user->fcm_token;
            }
            // $this->sendNotif($message,$title,$fcm_token);
        }else{
            // SEND NOTIF TO BOTH ROUTE
            $drivers = $agen->drivers;
            foreach ($drivers as $driver) {
                $fcm_token[] = $driver->user->fcm_token;
            }
            // $this->sendNotif($message,$title,$fcm_token);
        }

        return redirect()->back()->with('status','successfully created Sales Order');
    }

    public function edit($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        return view('delivery_order.edit',compact('sales_order','agen','delivery_order'));
    }

    public function update(Request $request,$id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $request->validate([
            'delivery_order_number'=>'required',
            'effective_date_start'=>'required',
            'effective_date_end'=>'required',
            'product'=>'required',
            'quantity'=>'required',
            'shipped_with'=>'required',
            'shipped_via'=>'required',
            'no_vehicles'=>'required',
            'top_seal'=>'required',
            'bottom_seal'=>'required',
            'temperature'=>'required',
        ]);

        $data = [
            'delivery_order_number'=>$request->delivery_order_number,
            'effective_date_start'=>$request->effective_date_start,
            'effective_date_end'=>$request->effective_date_end,
            'product'=>$request->product,
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
        ];
        if (count($request->shipped_via) == 2) {
            $data['shipped_via'] = 2;
        }else{
            $data['shipped_via'] = $request->shipped_via[0];
        }

        $delivery_order->update($data);
        return redirect()->route('deliveryorder.agen.show',$delivery_order->id);
    }

    public function destroy($id)
    {

    }

    private function sendNotif($message, $title, $fcm_token)
    {
        $client = new Client();

        // headers
        $headers  = [
            'Authorization'   =>  'key=AIzaSyBeQAlvl7zDYR2JFrzPoeCmLq7YxOG-_jo',
            'Content-Type'    =>  'application/json'
        ];

        // body
        $body = [
            'registration_ids'  =>  $fcm_token,
            'notification'      =>  [
            'body'  =>  $message,
            'title' =>  $title
            ]
      ];
      $response   = $client->post('https://fcm.googleapis.com/fcm/send', ['headers' => $headers, 'json' => $body]);

      return response()->json($response->getBody()->getContents());

    }


}
