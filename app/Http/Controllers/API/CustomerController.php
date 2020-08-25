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
        $customers = $agen->customers;
        return response()->json($customers, 200);
    }

    public function detail($id)
    {
        $agen = Auth::user()->agen;
        $customer = $agen->customers()->where('id',$id)->first();
        return response()->json($customer, 200);
    }
}
