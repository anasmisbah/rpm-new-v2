<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DeliveryOrder;

class DeliveryOrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $delivery_orders = $customer->delivery_order;
        foreach ($delivery_orders as $delivery_order) {
            $delivery_order->sales_order;
        }
        return response()->json($delivery_orders, 200);
    }

    public function detail($id)
    {
        $customer = Auth::user()->customer;
        $delivery_order = $customer->delivery_order()->where('id',$id)->first();
        $delivery_order->sales_order;
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
                    $delivery_orders[] = $delivery_order;
                }
            }
        }

        return response()->json($delivery_orders, 200);

    }
}
