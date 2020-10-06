<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Promo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Resources\PromoResource;
class PromoController extends Controller
{
    public function allpromos()
    {
        $promos = Promo::orderBy('created_at','desc')->get();
        $data = [];
        foreach ($promos as $key => $promo) {
            $data[]=new PromoResource($promo);
        }
        return response()->json($data,200);
    }

    public function promonormal()
    {
        $promo = Promo::where('status','normal')->orderBy('created_at','asc')->get();
        $data = [];
        foreach ($promo as $key => $promo) {
            $data[]=new PromoResource($promo);
        }
        return response()->json($data,200);
    }

    public function promohot()
    {
        $promo = Promo::where('status','hot')->orderBy('created_at','asc')->get();
        $data = [];
        foreach ($promo as $key => $promo) {
            $data[]=new PromoResource($promo);
        }
        return response()->json($data,200);
    }

    public function detail($id)
    {
        $promo = Promo::where('id',$id)->first();
        if (!$promo) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Promo not found'
                ],404);
        }
        $view = $promo->view;
        $promo->update([
            'view'=>$view+1
        ]);
        $data=new PromoResource($promo);
        return response()->json($data,200);
    }

    public function takepromo(Request $request)
    {
        $customer = Auth::user()->customer;
        $date = Carbon::now();

        $promo = Promo::where('id',$request->promo_id)->first();

        if (!$promo) {
            return response()->json([
                'status'=>false,
                'message'=>'promo not found'
            ], 404);
        }
        if ($promo->total == 0) {
            return response()->json([
                'status'=>false,
                'message'=>'promo already sold'
            ], 404);
        }
        if ($customer->reward < $promo->point) {
            return response()->json([
                'status'=>false,
                'message'=>'you dont have enough point to take this promo'
            ], 400);
        }

        $customer->vouchers()->create([
            'promo_id'=>$request->promo_id
        ]);

        $customer->update([
            'reward'=>($customer->reward) - ($promo->point)
        ]);
        $promo->update([
            'total'=>($promo->total - 1)
        ]);
         return response()->json([
            'status'=>true,
            'message'=>'Successfully take promo',
            'data'=>new PromoResource($promo)
        ], 200);
    }
}
