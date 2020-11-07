<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\Critics;
use Illuminate\Support\Facades\Auth;

class CriticsController extends Controller
{
    public function store(Request $request,$id)
    {
        $delivery_order = DeliveryOrder::findOrFail($id);

        $delivery_order->critics()->create([
            'critics_suggestion'=>$request->critics_suggestion,
            'service'=>$request->service,
            'rating'=>$request->rating,
        ]);
        $data = [
            'status'=>'Berhasil'
        ];
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
}
