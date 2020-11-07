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
        $user = Auth::user();
        if ($user->role_id == 3) {
            $agen = Auth::user()->agen;
            $sales_orders = $agen->sales_orders->sortByDesc('id');
            $data = [];
            foreach ($sales_orders as $sales_order) {
                $data[] = [
                    "id"=>$sales_order->id,
                    "sales_order_number"=>$sales_order->sales_order_number,
                    "customer"=>$sales_order->customer->name,
                    "customer_id"=>$sales_order->customer_id,
                    "agen_id"=>$sales_order->agen_id,
                    "agen"=>$sales_order->agen->name,
                    'created_at'=>$sales_order->created_at->dayName.", ".$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year,
                    "updated_at"=> $sales_order->updated_at->dayName.", ".$sales_order->updated_at->day." ".$sales_order->updated_at->monthName." ".$sales_order->updated_at->year,
                ];
            }
            return response()->json($data, 200);
        } else if($user->role_id == 4) {
            $customer = Auth::user()->customer;
            $sales_orders = $customer->sales_orders->sortByDesc('id');
            $data = [];
            foreach ($sales_orders as $sales_order) {
                $data[] = [
                    "id"=>$sales_order->id,
                    "sales_order_number"=>$sales_order->sales_order_number,
                    "customer"=>$sales_order->customer->name,
                    "customer_id"=>$sales_order->customer_id,
                    "agen_id"=>$sales_order->agen_id,
                    "agen"=>$sales_order->agen->name,
                    'created_at'=>$sales_order->created_at->dayName.", ".$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year,
                    "updated_at"=> $sales_order->updated_at->dayName.", ".$sales_order->updated_at->day." ".$sales_order->updated_at->monthName." ".$sales_order->updated_at->year,
                ];
            }
            return response()->json($data, 200);
        }
    }

    public function detail($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $data= [
            "id"=>$sales_order->id,
            "sales_order_number"=>$sales_order->sales_order_number,
            "customer"=>$sales_order->customer->name,
            "customer_id"=>$sales_order->customer_id,
            "agen_id"=>$sales_order->agen_id,
            "agen"=>$sales_order->agen->name,
            'created_at'=>$sales_order->created_at->dayName.", ".$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year,
            "updated_at"=> $sales_order->updated_at->dayName.", ".$sales_order->updated_at->day." ".$sales_order->updated_at->monthName." ".$sales_order->updated_at->year,
];
        foreach ($sales_order->delivery_orders as $delivery_order) {
                $data['delivery_orders'][] = new DeliveryOrderResource($delivery_order);
        }
        return response()->json($data, 200);
    }
}
