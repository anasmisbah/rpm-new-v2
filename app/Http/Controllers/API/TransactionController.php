<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $distributor = Auth::user()->employee->distributor;
        $transaction = $distributor->transactions()->get();
        foreach ($transaction as $key => $tran) {
            $transaction[$key]->date = $tran->billing_date->format('d/m/Y');
        }
        return response()->json($transaction, 200);
    }

    public function detail($id)
    {
        $distributor = Auth::user()->employee->distributor;
        $transaction = $distributor->transactions()->where('id',$id)->first();
        $transaction->date = $transaction->billing_date->format('d/m/Y');
        return response()->json($transaction, 200);
    }
}
