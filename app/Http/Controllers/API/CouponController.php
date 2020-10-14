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
                    'created_at'=>$coupon->created_at->format('d F Y'),
                    "updated_at"=> $coupon->updated_at->format('d F Y'),
                ];
            }
            return response()->json($data, 200);
        }
}
