<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $agen = Auth::user()->agen;
        $customers = $agen->customers()->orderBy('created_at','desc')->get();
        $data = [];
        foreach ($customers as $key => $customer) {
            $data[] = [
                "id"=> $customer->id,
                "name"=> $customer->name ,
                "address"=> $customer->address,
                "npwp"=> $customer->npwp ,
                "phone"=> $customer->phone ,
                "website"=> $customer->website ,
                "reward"=> $customer->reward ,
                "member"=>$customer->card->name,
                "card_image"=>url('/uploads/' . $customer->card->image),
                "logo"=> url('/uploads/' . $customer->logo) ,
                "user_id"=> $customer->user_id ,
                'created_at'=>$customer->created_at->dayName.", ".$customer->created_at->day." ".$customer->created_at->monthName." ".$customer->created_at->year,
                "updated_at"=> $customer->updated_at->dayName.", ".$customer->updated_at->day." ".$customer->updated_at->monthName." ".$customer->updated_at->year,
            ];
        }
        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $agen = Auth::user()->agen;
        $customer = $agen->customers()->where('id',$id)->first();
        $data = [
            "id"=> $customer->id,
            "name"=> $customer->name ,
            "address"=> $customer->address,
            "npwp"=> $customer->npwp ,
            "phone"=> $customer->phone ,
            "website"=> $customer->website ,
            "reward"=> $customer->reward ,
            "member"=>$customer->card->name,
            "card_image"=>url('/uploads/' . $customer->card->image),
            "logo"=> url('/uploads/' . $customer->logo) ,
            "user_id"=> $customer->user_id ,
            'created_at'=>$customer->created_at->dayName.", ".$customer->created_at->day." ".$customer->created_at->monthName." ".$customer->created_at->year,
            "updated_at"=> $customer->updated_at->dayName.", ".$customer->updated_at->day." ".$customer->updated_at->monthName." ".$customer->updated_at->year,
        ];
        return response()->json($data, 200);
    }
}
