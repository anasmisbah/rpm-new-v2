<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Coupon;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $customer = Customer::findOrFail($id);

        return view('coupon.index',compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $customer = Customer::findOrFail($id);

        return view('coupon.create',compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);
        $last = $customer->coupons->last();
        $id = 0;

        if ($last != null) {
            $id = $last->id;
        }

        $request->validate([
            'coupon'=>'required'
        ]);

        $total = $request->coupon;

        for ($i=0; $i < $total; $i++) {
            $code_coupon = 'C0'.$customer->id.'00'.(++$id);
            $customer->coupons()->create([
                'code_coupon'=>$code_coupon
            ]);
        }

        return redirect()->route('customer.coupon.index',$customer->id)->with('status',"successfully added $total Coupon");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $customer = $coupon->customer;
        $coupon->delete();
        return redirect()->route('customer.coupon.index',$customer->id)->with('status',"successfully deleted Coupon");
    }

    public function deleteall($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->coupons()->delete();
        return redirect()->route('customer.coupon.index',$customer->id)->with('status',"successfully deleted All Coupon");
    }

    public function print($id)
    {
        $customer = Customer::findOrFail($id);

        return view('coupon.print',compact('customer'));
    }
}
