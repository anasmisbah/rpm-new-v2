<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CouponController extends Controller
{

        public function index()
        {
            $customer = Auth::user()->customer;
            $coupons = $customer->sales_orders()->orderBy('created_at','desc')->get();
            $data = [];
            foreach ($coupons as $key => $coupon) {
                $data[] = [
                    "id"=> $coupon->id,
                    "code_coupon"=> $coupon->sales_order_number,
                    'created_at'=>$coupon->created_at->dayName.", ".$coupon->created_at->day." ".$coupon->created_at->monthName." ".$coupon->created_at->year,
                    "updated_at"=> $coupon->updated_at->dayName.", ".$coupon->updated_at->day." ".$coupon->updated_at->monthName." ".$coupon->updated_at->year,
                ];
            }
            return response()->json($data, 200);
        }
}
