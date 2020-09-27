<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DeliveryOrder;

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
}
