<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\DriverCode;
use Carbon\Carbon;
class DistributorController extends Controller
{
    public function approve(Request $request)
    {
        $user = Auth::user();
        $distributor = $user->employee->distributor;
        $codes = DriverCode::where('status','active')->get();
        $macthCode = null;
        foreach ($codes as  $code) {
            if (Hash::check($request->code, $code->code)) {
                $macthCode = $code;
                break;
            }
        }

        if (!$macthCode) {
            return response()->json([
                'message'=>'invalid code',
                'status'=>false
            ],400);
        }

        if ($macthCode->status != 'active') {
            return response()->json([
                'message'=>'code inactive',
                'status'=>false
            ],400);
        }

        $now = Carbon::now();
        $diff = $macthCode->created_at->diffInMinutes($now);
        // if ($diff >60) {
        //     return response()->json([
        //         'message'=>'code expired',
        //         'status'=>'false'
        //     ],400);
        // }

        $distributor->delivery()->create([
            'delivery_at'=>$code->created_at,
            'driver_id'=>$code->driver_id
        ]);

        $code->update([
            'status'=>'inactive'
        ]);

        return response()->json([
            'message'=>'Code Accepted',
            'status'=>true
        ]);
    }

    public function history()
    {
        $user = Auth::user();

        $distributor = $user->employee->distributor;

        $deliveries = $distributor->delivery;
        foreach ($deliveries as $key => $del) {
            $deliveries[$key]->delivery_date = $del->delivery_at->format('l, d F Y H:i:s');
            $deliveries[$key]->driver->avatar = url('/uploads/' . $del->driver->avatar);;
        }
        return response()->json($deliveries);
    }
}
