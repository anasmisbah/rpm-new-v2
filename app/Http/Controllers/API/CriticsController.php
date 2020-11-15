<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\Critics;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class CriticsController extends Controller
{
    public function store(Request $request,$id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $customer = $delivery_order->sales_order->customer;
        $agen = $delivery_order->sales_order->agen;
        $delivery_order->critics()->create([
            'critics_suggestion'=>$request->critics_suggestion,
            'service'=>$request->service,
            'rating'=>$request->rating,
        ]);
        $data = [
            'status'=>'Berhasil'
        ];
        $fcm_token = [];
        $title = 'Delivery Order';
        $message = "Dari Customer - Agen. Customer $customer->name telah memberikan rating pada DO $delivery_order->delivery_order_number.";
        $fcm_token[] = $agen->user->fcm_token;
        $this->sendNotif($message,$title,$fcm_token);
        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);
        $critics = $delivery_order->critics;

        $data = [];
        if ($critics) {
            $data = [
                'id'=>$critics->id,
                'critics_suggestion'=>$critics->critics_suggestion,
                'service'=>$critics->service,
                'rating'=>$critics->rating,
            ];
        }
        return response()->json($data, 200);
    }

    public function critics_agen()
    {
        $agen = Auth::user()->agen;
        $sales_orders = $agen->sales_orders;
        $data = [];
        foreach ($sales_orders as $sales_order) {
            foreach ($sales_order->delivery_orders as $delivery_order) {
                $critics = $delivery_order->critics;
                if ($critics) {
                    $data[] =[
                        'id'=>$critics->id,
                        'critics_suggestion'=>$critics->critics_suggestion,
                        'service'=>$critics->service,
                        'rating'=>$critics->rating,
                        'delivery_order_number'=>$delivery_order->delivery_order_number,
                    ];
                }
            }
        }
        return response()->json($data, 200);
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
