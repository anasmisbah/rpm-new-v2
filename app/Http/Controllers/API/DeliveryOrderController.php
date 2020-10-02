<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DeliveryOrder;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Resources\DeliveryOrder as DeliveryOrderResource;
use App\Notifdo;
class DeliveryOrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $delivery_orders = DeliveryOrderResource::collection($customer->delivery_order);
        return response()->json($delivery_orders, 200);
    }

    public function detail($id)
    {
        $customer = Auth::user()->customer;
        $result = $customer->delivery_order()->where('id',$id)->first();
        $delivery_order = new DeliveryOrderResource($result);
        return response()->json($delivery_order, 200);
    }

    public function deliveryfordriver()
    {
        $driver = Auth::user()->driver;
        $agen = $driver->agen;
        $route = $driver->route;
        $sales_orders = $agen->sales_orders;

        $delivery_orders = [];
        foreach ($sales_orders as $sales_order) {
            foreach ($sales_order->delivery_orders as $delivery_order) {
                if (($route == $delivery_order->shipped_via || $delivery_order->shipped_via == 2) && $delivery_order->status == 1) {
                    $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                }
            }
        }

        return response()->json($delivery_orders, 200);
    }

    public function historynotifdo($id)
    {
        $result = DeliveryOrder::where('id',$id)->first();
        $data = [];
        $time = Carbon::createFromTimeString($result->estimate);
        $estimate = ($time->hour*3600) + ($time->minute*60);
        foreach ($result->notifs->sortByDesc('id') as $notif) {
            $data[] = [
                'id'=>$notif->id,
                'time'=>$notif->date->format('H:i:s'),
                'date'=>$notif->date->dayName.", ".$notif->date->day." ".$notif->date->monthName." ".$notif->date->year,
                'description'=>$notif->description,
                'driver'=>$notif->driver,
                'estimate'=>$estimate
            ];
        }
        return response()->json($data, 200);
    }

    public function deliveryforagen()
    {
        $agen = Auth::user()->agen;
        $sales_orders = $agen->sales_orders;

        $delivery_orders = [];
        foreach ($sales_orders as $sales_order) {
            foreach ($sales_order->delivery_orders as $delivery_order) {
                if ( $delivery_order->status == 0) {
                    $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                }
            }
        }

        return response()->json($delivery_orders, 200);
    }

    public function agenApproveDO($id)
    {
        $agen = Auth::user()->agen;
        $delivery_order = DeliveryOrder::findOrFail($id);

        $delivery_order->update([
            'status'=>1,
        ]);

        $fcm_token = [];
        $title = 'Delivery Order';
        $message = "DO No $delivery_order->delivery_order_number telah disetujui oleh agen";
        if ($delivery_order->shipped_via == 0) {
            // SEND NOTIF TO JALUR DARAT
            $drivers = $agen->drivers()->where('route',0)->get();
            foreach ($drivers as $driver) {
                $fcm_token[] = $driver->user->fcm_token;
            }
            $this->sendNotif($message,$title,$fcm_token);
        }else if($delivery_order->shipped_via == 1){
            // SEND NOTIF TO JALUR LAUT
            $drivers = $agen->drivers()->where('route',1)->get();
            foreach ($drivers as $driver) {
                $fcm_token[] = $driver->user->fcm_token;
            }
            $this->sendNotif($message,$title,$fcm_token);
        }else{
            // SEND NOTIF TO BOTH ROUTE
            $drivers = $agen->drivers;
            foreach ($drivers as $driver) {
                $fcm_token[] = $driver->user->fcm_token;
            }
            $this->sendNotif($message,$title,$fcm_token);
        }
        // Get time server
        $date = Carbon::now();
        Notifdo::create([
            'date'=>$date,
            'description'=>$message,
            'delivery_order_id'=>$delivery_order->id
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'berhasil melakukan approve delivery order',
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
}
