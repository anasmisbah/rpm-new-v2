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
        $user = Auth::user();
        if ($user->role_id == 3) {
            $delivery_orders = [];
            foreach ($user->agen->sales_orders->sortByDesc('id') as $key => $sales_order) {
                foreach ($sales_order->delivery_orders->sortByDesc('id') as $delivery_order) {
                    $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                }
            }
            return response()->json($delivery_orders, 200);
        } else if($user->role_id == 4) {
            $delivery_orders = [];
            foreach ($user->customer->sales_orders->sortByDesc('id') as $key => $sales_order) {
                foreach ($sales_order->delivery_orders->sortByDesc('id') as $delivery_order) {
                    $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                }
            }
            return response()->json($delivery_orders, 200);
        }


    }

    public function detail($id)
    {
        $result = DeliveryOrder::where('id',$id)->first();
        if (!$result) {
            return response()->json([
                'status'=>false,
                'message'=>'delivery order tidak ditemukan',
            ], 404);
        }
        $delivery_order = new DeliveryOrderResource($result);
        return response()->json($delivery_order, 200);
    }

    public function detailForAgen($id)
    {
        $result = DeliveryOrder::where('id',$id)->first();
        if (!$result) {
            return response()->json([
                'status'=>false,
                'message'=>'delivery order tidak ditemukan',
            ], 404);
        }
        $delivery_order = new DeliveryOrderResource($result);
        return response()->json($delivery_order, 200);
    }

    public function deliveryfordriver()
    {
        $driver = Auth::user()->driver;
        $agen = $driver->agen;
        $route = $driver->route;
        $sales_orders = $agen->sales_orders->sortByDesc('id');

        $dos = $driver->delivery_order()->orderBy('created_at', 'desc')->get();
        $delivery_orders = [];
        foreach ($dos as $key => $delivery_order) {
            if ($delivery_order->status == 1) {
                $delivery_orders[] = new DeliveryOrderResource($delivery_order);
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
        foreach ($result->notifs->sortByDesc('date') as $notif) {
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
        $sales_orders = $agen->sales_orders->sortByDesc('id');

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
        $message = "Dari Agent - Driver. DO No $delivery_order->delivery_order_number telah terbit. $delivery_order->shipped_with $delivery_order->no_vehicles sudah dapat melakukan Proses Pengisian BBM ";
        $fcm_token[] = $delivery_order->driver->user->fcm_token;
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message,$title,$fcm_token,$data_notif);
        // Get time server
        $date = Carbon::now();
        Notifdo::create([
            'date'=>$date,
            'description'=>$message,
            'delivery_order_id'=>$delivery_order->id
        ]);

        // SEND NOTIFICATION TO CUSTOMER
        $fcm_token_customer = [
            $delivery_order->sales_order->customer->user->fcm_token
        ];
        $title_customer = 'Delivery Order';
        $message_customer = "DO No $delivery_order->delivery_order_number telah terbit. $delivery_order->shipped_with $delivery_order->no_vehicles sedang melakukan Proses Pengisian BBM ";
        $data_notif=[
            'screen'=>'detaildo',
            'id'=>$delivery_order->id
        ];
        $this->sendNotif($message_customer,$title_customer,$fcm_token_customer,$data_notif);
        Notifdo::create([
            'date'=>$date,
            'description'=>$message_customer,
            'delivery_order_id'=>$delivery_order->id
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'berhasil melakukan approve delivery order',
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
}
