<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\FileImport;
use App\Upload;
use App\Agen;
use App\Customer;
use App\SalesOrder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function create()
    {
        return view('uploads.create');
    }

    public function store(Request $request)
    {
        set_time_limit(300);
        Upload::truncate();
        $import = new FileImport();
        $import->onlySheets('DATA');

        Excel::import($import,request()->file('data'));

        $data = Upload::select('id','no_so','no_agen','name_agen','no_customer','name_customer','quantity')->get();

        foreach ($data as $key => $row) {
            $resultCheckAgen = Agen::where('no_agen',$row->no_agen)->first();
            if ($resultCheckAgen) {
                $resultCustomer = Customer::where('no_customer',$row->no_customer)->first();
                if ($resultCustomer) {
                    $no_so = $row->no_so;
                    $point = $row->quantity;

                    $resultSalesOrder = SalesOrder::where('sales_order_number',$no_so)->first();
                    if (!$resultSalesOrder) {
                        $sales_order = SalesOrder::create([
                            'sales_order_number'=>$no_so,
                            'customer_id'=>$resultCustomer->id,
                            'agen_id'=>$resultCheckAgen->id
                        ]);
                    }

                    $resultCustomer->update([
                        'reward'=>($resultCustomer->reward + $point)
                    ]);
                } else {
                    $customer_name = $row->name_customer;
                    $no_customer = $row->no_customer;

                    $default_email_customer = "customer.".strtolower(preg_replace('/\s*/', '', $customer_name)).".$no_customer@mail.com";
                    $default_password_customer = Hash::make("123123");
                    $user_customer = User::create([
                        'email'=>$default_email_customer,
                        'password'=>$default_password_customer,
                        'role_id'=>4
                    ]);

                    $customer = Customer::create([
                        'user_id'=>$user_customer->id,
                        'name'=>$customer_name,
                        'no_customer'=>$no_customer,
                        'agen_id'=>$resultCheckAgen->id
                    ]);

                    $no_so = $row->no_so;
                    $point = $row->quantity;
                    $sales_order = SalesOrder::create([
                        'sales_order_number'=>$no_so,
                        'customer_id'=>$customer->id,
                        'agen_id'=>$resultCheckAgen->id
                    ]);

                    $customer->update([
                        'reward'=>($customer->reward + $point)
                    ]);

                }
            }else{
                $agen_name = $row->name_agen;
                $no_agen = $row->no_agen;

                $default_email = "agen.".strtolower(preg_replace('/\s*/', '', $agen_name))."$no_agen@mail.com";
                $default_password = Hash::make("123123");
                $user = User::create([
                    'email'=>$default_email,
                    'password'=>$default_password,
                    'role_id'=>3
                ]);

                $agen = Agen::create([
                    'user_id'=>$user->id,
                    'name' =>$agen_name,
                    'no_agen'=>$no_agen
                ]);

                $resultCustomer = Customer::where('no_customer',$row->no_customer)->first();
                if ($resultCustomer) {
                    $no_so = $row->no_so;
                    $point = $row->quantity;

                    $resultSalesOrder = SalesOrder::where('sales_order_number',$no_so)->first();
                    if (!$resultSalesOrder) {
                        $sales_order = SalesOrder::create([
                            'sales_order_number'=>$no_so,
                            'customer_id'=>$resultCustomer->id,
                            'agen_id'=>$agen->id
                        ]);
                    }

                    $resultCustomer->update([
                        'reward'=>($resultCustomer->reward + $point)
                    ]);
                } else {
                    $customer_name = $row->name_customer;
                    $no_customer = $row->no_customer;

                    $default_email_customer = "customer.".strtolower(preg_replace('/\s*/', '', $customer_name))."$no_customer@mail.com";
                    $default_password_customer = Hash::make("123123");
                    $user_customer = User::create([
                        'email'=>$default_email_customer,
                        'password'=>$default_password_customer,
                        'role_id'=>4
                    ]);

                    $customer = Customer::create([
                        'user_id'=>$user_customer->id,
                        'name'=>$customer_name,
                        'no_customer'=>$no_customer,
                        'agen_id'=>$agen->id
                    ]);

                    $no_so = $row->no_so;
                    $point = $row->quantity;
                    $sales_order = SalesOrder::create([
                        'sales_order_number'=>$no_so,
                        'customer_id'=>$customer->id,
                        'agen_id'=>$agen->id
                    ]);

                    $customer->update([
                        'reward'=>($customer->reward + $point)
                    ]);
                }
            }
        }
        return redirect()->back()->with('status','Successfully upload data');
    }
}
