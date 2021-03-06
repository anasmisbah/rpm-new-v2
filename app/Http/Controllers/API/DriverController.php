<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Driver;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\DeliveryOrder;
use App\Http\Resources\DeliveryOrder as DeliveryOrderResource;
use App\Http\Resources\DriverResource;
class DriverController extends Controller
{

    public function acceptedDelivery($id)
    {
        $user= Auth::user();
        $delivery_order = DeliveryOrder::findOrFail($id);



        // Get time server
        $date = Carbon::now();
        $estimasi_waktu = Carbon::now();
        $time = Carbon::createFromTimeString($delivery_order->estimate);


        $jam = '';
        if ($time->hour != 0) {
            $jam = "$time->hour jam";
        }
        $menit = '';
        if ($time->minute != 0) {
            $menit = "$time->minute menit";
        }
        $estimasi = $jam.' '.$menit;
        $estimasi_waktu->addHours($time->hour);
        $estimasi_waktu->addMinutes($time->minute);
        $waktuStr = $estimasi_waktu->format('H:i');

        // TODO driver start delivery
        $delivery_order->update([
            'status'=>2,
            'departure_time'=>$date,
        ]);

        // Send notification to customer
        $customer = $delivery_order->sales_order->customer;
        $fcm_token[] = $customer->user->fcm_token;

        $title = 'Delivery Order';
        $message = "Proses Pengisian BBM telah selesai ($delivery_order->no_vehicles) sedang menuju lokasi anda (Estimasi Perjalanan $estimasi) tiba jam $waktuStr WITA";
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message,$title,$fcm_token,$data_notif);

        $delivery_order->notifs()->create([
            'date'=>$date,
            'description'=>$message,
            'driver'=>$user->driver->name,
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'berhasil melakukan accept delivery order',
            'delivery_order'=>new DeliveryOrderResource($delivery_order)
        ], 200);

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

    public function finishDelivery(Request $request)
    {
        $user = Auth::user();
        $driver = $user->driver;
        $request->validate([
            'delivery_order_id'=>'required',
            'bast'=>'required|mimes:jpeg,bmp,png,jpg',
        ]);
        $delivery_order = $driver->delivery_order()->where('id',$request->delivery_order_id)->first();
        if (!$delivery_order) {
            return response()->json([
                'status'=>false,
                'message'=>'delivery order tidak ditemukan',
            ], 404);
        }

        // TODO upload
        if ($request->file('bast')) {
            $bast = 'bast/'.time().$request->file('bast')->getClientOriginalName();
            $request->file('bast')->move('uploads/bast', $bast);
        }
        $date = Carbon::now();

        $delivery_order->update([
            'bast'=>$bast,
            'arrival_time'=>$date,
            'unloading_end_time'=>$date,
            'status'=>3
        ]);

        // UPDATE POINT REWARD CUSTOMER

        $point = round(($delivery_order->quantity)/1000);
        $customer = $delivery_order->sales_order->customer;
        $customer->update([
            'reward'=>($customer->reward + $point),
            'transaction'=>($customer->transaction + $delivery_order->quantity )
        ]);

        $agen = $delivery_order->sales_order->agen;
        $agen->update([
            'transaction'=>($agen->transaction + $delivery_order->quantity )
        ]);

        // TODO notif to customer
        $fcm_token[] = $customer->user->fcm_token;
        $fcm_token[] = $agen->user->fcm_token;
        $title = 'Delivery Order';
        $message = "Proses Pembongkaran $delivery_order->shipped_with $delivery_order->no_vehicles telah selesai (BAST, Terlampir)";
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message,$title,$fcm_token,$data_notif);

        $delivery_order->notifs()->create([
            'date'=>$date,
            'description'=>$message,
            'driver'=>$user->driver->name,
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'berhasil melakukan finish delivery order',
            'delivery_order'=>new DeliveryOrderResource($delivery_order)
        ], 200);
    }

    public function history()
    {
        $user = Auth::user();
        $delivery_orders = $user->driver->delivery_order()->where('status',3)->orderBy('arrival_time','desc')->get();
        $data = [];
        foreach ($delivery_orders as $key => $delivery_order) {
            $data[] = new DeliveryOrderResource($delivery_order);
        }

        return response()->json($data);
    }

    public function index()
    {
        $agen = Auth::user()->agen;
        $drivers = $agen->drivers;
        $data = [];
        foreach ($drivers as  $driver) {
            $data[] = new DriverResource($driver);
        }

        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $agen = Auth::user()->agen;
        $driver = $agen->drivers()->where('id',$id)->first();
        $data = new DriverResource($driver);
        return response()->json($data, 200);
    }


}
