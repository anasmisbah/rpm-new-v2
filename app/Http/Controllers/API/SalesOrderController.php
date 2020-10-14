<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SalesOrder;
use App\Http\Resources\DeliveryOrder as DeliveryOrderResource;
class SalesOrderController extends Controller
{
    public function index()
    {
        $agen = Auth::user()->agen;
        $sales_orders = $agen->sales_orders->sortByDesc('id');
        $data = [];
        foreach ($sales_orders as $sales_order) {
            $data[] = [
                "id"=>$sales_order->id,
                "sales_order_number"=>$sales_order->sales_order_number,
                "customer_id"=>$sales_order->customer->name,
                "customer_id"=>$sales_order->customer_id,
                "agen_id"=>$sales_order->agen_id,
                "created_at"=>$sales_order->created_at->format('d F Y') ,
                "updated_at"=>$sales_order->updated_at->format('d F Y'),
            ];
        }
        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $agen = Auth::user()->agen;
        $sales_order = $agen->sales_orders()->where('id',$id)->first();
        $data= [
            "id"=>$sales_order->id,
            "sales_order_number"=>$sales_order->sales_order_number,
            "customer_id"=>$sales_order->customer_id,
            "agen_id"=>$sales_order->agen_id,
            "agen_id"=>$sales_order->agen_id,
            "created_at"=>$sales_order->created_at->format('d F Y') ,
            "updated_at"=>$sales_order->updated_at->format('d F Y'),
        ];
        foreach ($sales_order->delivery_orders as $delivery_order) {
                $data['delivery_orders'][] = new DeliveryOrderResource($delivery_order);
        }
        return response()->json($data, 200);
    }
}
