<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        $user = Auth::user();

        if ($user->role_id == 3) {
            $user->role;
            $user->agen->logo= url('/uploads/' . $user->agen->logo);

            return response()->json($user, 200);

        }elseif($user->role_id == 4){
            $user->customer->avatar = url('/uploads/' . $user->customer->avatar);
            $user->role;
            $user->customer->logo= url('/uploads/' . $user->customer->logo);
            $user->customer->agen->logo= url('/uploads/' . $user->customer->agen->logo);
            return response()->json($user, 200);
        }else {
            $user->driver->avatar = url('/uploads/' . $user->driver->avatar);
            $user->role;
            $user->driver->agen->logo= url('/uploads/' . $user->driver->agen->logo);

            // TODO HISTORY DELIVERY
            $user->delivery_orders = $user->driver->delivery_order()->where('status',2)->get();

            return response()->json($user, 200);
        }
    }
}
