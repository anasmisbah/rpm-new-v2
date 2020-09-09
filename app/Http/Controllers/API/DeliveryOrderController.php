<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DeliveryOrder;
use App\Http\Resources\DeliveryOrder as DeliveryOrderResource;
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
                if (($route == $delivery_order->shipped_via || $delivery_order->shipped_via == 2) && $delivery_order->status == 0) {
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
        foreach ($result->notifs->sortByDesc('id') as $notif) {
            $data[] = [
                'id'=>$notif->id,
                'time'=>$notif->date->format('H:i:s'),
                'date'=>$notif->date->dayName.", ".$notif->date->day." ".$notif->date->monthName." ".$notif->date->year,
                'description'=>$notif->description,
                'driver'=>$notif->driver
            ];
        }
        return response()->json($data, 200);
    }
}
