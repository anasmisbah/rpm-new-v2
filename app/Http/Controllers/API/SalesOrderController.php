<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SalesOrder;

class SalesOrderController extends Controller
{
    public function index()
    {
        $agen = Auth::user()->agen;
        $sales_orders = $agen->sales_orders;
        foreach ($sales_orders as $sales_order) {
            $sales_order->delivery_orders;
        }
        return response()->json($sales_orders, 200);
    }

    public function detail($id)
    {
        $agen = Auth::user()->agen;
        $sales_order = $agen->sales_orders()->where('id',$id)->first();
        $sales_order->delivery_orders;
        return response()->json($sales_order, 200);
    }
}
