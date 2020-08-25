<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Promo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function allpromos()
    {
        $promos = Promo::all();
        $data = [];
        foreach ($promos as $key => $promo) {
            $data[]=[
                'id'=> $promo->id,
                'title'=> $promo->name,
                'image'=> url('/uploads/' . $promo->image),
                'description'=> $promo->description,
                'terms'=>$promo->terms,
                'point'=>$promo->point,
                'total'=>$promo->total,
                'view'=>$promo->view,
                'status'=>$promo->status,
                'created_at'=>$promo->created_at->format('d F Y'),
                'created_by'=>$promo->createdby->admin->name,
            ];
        }
        return response()->json($data,200);
    }

    public function promonormal()
    {
        $promo = Promo::where('status','normal')->get();
        $data = [];
        foreach ($promo as $key => $promo) {
            $data[]=[
                'id'=> $promo->id,
                'title'=> $promo->name,
                'image'=> url('/uploads/' . $promo->image),
                'description'=> $promo->description,
                'terms'=>$promo->terms,
                'point'=>$promo->point,
                'total'=>$promo->total,
                'view'=>$promo->view,
                'status'=>$promo->status,
                'created_at'=>$promo->created_at->format('d F Y'),
                'created_by'=>$promo->createdby->admin->name,
            ];
        }
        return response()->json($data,200);
    }

    public function promohot()
    {
        $promo = Promo::where('status','hot')->get();
        $data = [];
        foreach ($promo as $key => $promo) {
            $data[]=[
                'id'=> $promo->id,
                'title'=> $promo->name,
                'image'=> url('/uploads/' . $promo->image),
                'description'=> $promo->description,
                'terms'=>$promo->terms,
                'point'=>$promo->point,
                'total'=>$promo->total,
                'view'=>$promo->view,
                'status'=>$promo->status,
                'created_at'=>$promo->created_at->format('d F Y'),
                'created_by'=>$promo->createdby->admin->name,
            ];
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
        $data=[
            'id'=> $promo->id,
            'title'=> $promo->name,
            'image'=> url('/uploads/' . $promo->image),
            'description'=> $promo->description,
            'terms'=>$promo->terms,
            'point'=>$promo->point,
            'total'=>$promo->total,
            'view'=>$promo->view,
            'status'=>$promo->status,
            'created_at'=>$promo->created_at->format('d F Y'),
            'created_by'=>$promo->createdby->admin->name,
        ];
        return response()->json($data,200);
    }

    public function takepromo(Request $request)
    {
        $customer = Auth::user()->customer;
        $agen = $customer->agen;
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
            'reward'=>($agen->reward) - ($promo->point)
        ]);
        $promo->update([
            'total'=>($promo->total - 1)
        ]);
         return response()->json([
            'status'=>true,
            'message'=>'Successfully take promo',
            'data'=>[
                'title'=> $promo->name,
                'image'=> url('/uploads/' . $promo->image),
                'description'=> $promo->description,
                'terms'=>$promo->terms,
                'point'=>$promo->point,
                'total'=>$promo->total,
                'status'=>$promo->status,
                'date'=>$date->format('l, d F Y')
            ]
        ], 200);
    }
}
