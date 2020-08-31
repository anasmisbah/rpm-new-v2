<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DeliveryOrder as DeliveryOrderResource;
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
            $user->driver->agen->logo = url('/uploads/' . $user->driver->agen->logo);
            $user->role;
            $user->driver->delivery_order;
            foreach ($user->driver->delivery_order as $key => $delivery_order) {
                $user->driver->delivery_order[$key] = new DeliveryOrderResource($delivery_order);
            }
            $data['user']=$user;

            $agen = $user->driver->agen;
            $route = $user->driver->route;
            $sales_orders = $agen->sales_orders;

            $delivery_orders = [];
            foreach ($sales_orders as $sales_order) {
                foreach ($sales_order->delivery_orders as $delivery_order) {
                    if (($route == $delivery_order->shipped_via || $delivery_order->shipped_via == 2) && $delivery_order->status == 0) {
                        $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                    }
                }
            }
            $data['ready_delivery_order']=$delivery_orders;
            return response()->json($data, 200);
        }
    }
}
