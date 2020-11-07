<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Voucher;
use App\Http\Resources\PromoResource;
class VoucherController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $vouchers = Voucher::where('customer_id',$customer->id)->orderBy('created_at','desc')->get();

        $data = [];
        foreach ($vouchers as $key => $voucher) {
            $data[] = [
                'id'=>$voucher->id,
                'promo_id'=>$voucher->promo_id,
                'customer_id'=>$voucher->customer_id,
                'created_at'=>$voucher->created_at->dayName.", ".$voucher->created_at->day." ".$voucher->created_at->monthName." ".$voucher->created_at->year,
                'promo'=> new  PromoResource($voucher->promo)
            ];
        }

        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $customer = Auth::user()->customer;
        $voucher = Voucher::findOrFail($id);
        $data = [
            'id'=>$voucher->id,
            'promo_id'=>$voucher->promo_id,
            'customer_id'=>$voucher->customer_id,
            'created_at'=>$voucher->created_at->dayName.", ".$voucher->created_at->day." ".$voucher->created_at->monthName." ".$voucher->created_at->year,
            'promo'=> new  PromoResource($voucher->promo)
        ];
        return response()->json($data, 200);
    }
}
