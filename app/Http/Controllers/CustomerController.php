<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Agen;
use App\User;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;
use DataTables;
class CustomerController extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $agen = Agen::findOrFail($id);

        return view('customer.index',compact('agen'));
    }

    public function customer_data($id)
    {
        $promos = Customer::select(['id','name','coupon','member','reward','logo'])->orderBy('id','desc')
                    ->where('agen_id',$id);

        $dataTable = DataTables::of($promos)
        ->addIndexColumn()
        ->editColumn('logo', function ($data)
        {
            return url('/uploads/'.$data->logo);
        })
        ->addColumn('url_detail', function ($data) {
            return route('customer.agen.show',$data->id);
        })
        ->addColumn('url_edit', function ($data) {
            return route('customer.agen.edit',$data->id);
        })
        ->addColumn('url_delete', function ($data) {
            return route('customer.agen.destroy',$data->id);
        });

        return $dataTable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $agen = Agen::findOrFail($id);
        return view('customer.create',compact('agen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $agen = Agen::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'member'=>'required',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email_user'=>'required|email|unique:users,email',
            'password_user'=>'required',
        ]);
        $logo='logos/default.jpg';
        if ($request->file('logo')) {
            $request->validate([
                'logo'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            $logo = 'logos/'.time().$request->file('logo')->getClientOriginalName();
            $request->file('logo')->move('uploads/logos', $logo);
        }

        $user = User::create([
            'email'=>$request->email_user,
            'password'=>Hash::make($request->password_user),
            'role_id'=>3
        ]);

        Customer::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'member'=>$request->member,
            'phone'=>$request->phone,
            'website'=>$request->website,
            'logo'=>$logo,
            'npwp'=>$request->npwp,
            'user_id'=>$user->id,
            'agen_id'=>$agen->id
        ]);

        return redirect()->back()->with('status','Successfully created Customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $agen = $customer->agen;
        return view('customer.detail',compact('customer','agen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $agen = $customer->agen;
        return view('customer.edit',compact('customer','agen'));
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
        $customer = Customer::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'member'=>'required',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email_user'=>'required|email|unique:users,email,'.$customer->user->id,
        ]);

        if ($request->file('logo')) {
            $request->validate([
                'logo'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($customer->logo == "logos/default.jpg") && file_exists('uploads/'.$customer->logo)) {
                File::delete('uploads/'.$customer->logo);
            }
            $logo = 'logos/'.time().$request->file('logo')->getClientOriginalName();
            $request->file('logo')->move('uploads/logos', $logo);
            $customer->update([
                'logo'=> $logo
            ]);
        }

        if ($request->password) {
            $request->validate([
                'password'=>'min:6',
            ]);
            $customer->user()->update([
                'password'=>Hash::make($request->password_user),
            ]);
        }
        $customer->user()->update([
            'email'=>$request->email_user
        ]);

        $customer->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'member'=>$request->member,
            'phone'=>$request->phone,
            'website'=>$request->website,
            'npwp'=>$request->npwp
        ]);

        return redirect()->back()->with('status','Successfully updated Customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $user = $customer->user;
        if (!($customer->logo == "logos/default.jpg") && file_exists('uploads/'.$customer->logo)) {
            File::delete('uploads/'.$customer->logo);
        }
        $customer->delete();
        $user->delete();
        return redirect()->back()->with('status','Successfully deleted Customer');
    }
}
