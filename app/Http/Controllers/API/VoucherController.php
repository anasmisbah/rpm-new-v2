<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $voucher = $customer->vouchers()->with('promo')->get();

        return response()->json($voucher, 200);
    }

    public function detail($id)
    {
        $customer = Auth::user()->customer;
        $voucher = $customer->vouchers()->with('promo')->where('id',$id)->first();

        return response()->json($voucher, 200);
    }
}
