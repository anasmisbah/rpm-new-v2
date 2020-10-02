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
            'driver_id'=>$user->driver->id,
            'departure_time'=>$date,
            'shipped_via'=>$user->driver->route,
        ]);

        // Send notification to customer
        $customer = $delivery_order->customer;
        $fcm_token[] = $customer->user->fcm_token;

        $title = 'Delivery Order';
        $message = "Proses Pengisian BBM telah selesai ($delivery_order->no_vehicles) sedang menuju lokasi anda (Estimasi Perjalanan $estimasi) tiba jam $waktuStr WITA";
        $this->sendNotif($message,$title,$fcm_token);

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

    private function sendNotif($message, $title, $fcm_token)
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
            ]
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
            'status'=>3
        ]);

        // UPDATE POINT REWARD CUSTOMER

        $point = round(($delivery_order->quantity)/1000);
        $customer = $delivery_order->customer;
        $customer->update([
            'reward'=>($customer->reward + $point)
        ]);

        // TODO notif to customer
        $customer = $delivery_order->customer;
        $fcm_token[] = $customer->user->fcm_token;

        $title = 'Delivery Order';
        $message = "Proses Pembongkaran $delivery_order->shipped_with $delivery_order->no_vehicles telah selesai (BAST, Terlampir)";
        $this->sendNotif($message,$title,$fcm_token);

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
        $delivery_orders = $user->driver->delivery_order()->where('status',2)->get();
        // foreach ($deliveries as $key => $del) {
        //     $deliveries[$key]->delivery_date = $del->delivery_at->format('l, d F Y H:i:s');
        //     $deliveries[$key]->distributor->logo= url('/uploads/' . $del->distributor->logo);;
        // }

        return response()->json($delivery_orders);
    }

    public function index()
    {
        $agen = Auth::user()->agen;
        $drivers = $agen->drivers;
        foreach ($drivers as  $driver) {
            $driver->avatar = url('/uploads/' . $driver->avatar);
        }
        return response()->json($drivers, 200);
    }

    public function detail($id)
    {
        $agen = Auth::user()->agen;
        $driver = $agen->drivers()->where('id',$id)->first();
        $driver->avatar = url('/uploads/' . $driver->avatar);
        return response()->json($driver, 200);
    }


}
