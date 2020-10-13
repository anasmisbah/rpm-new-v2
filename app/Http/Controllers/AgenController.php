<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agen;
use App\User;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;

class AgenController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agens = Agen::orderBy('id','desc')->get();

        return view('agen.index',compact('agens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email_user'=>'required|email|unique:users,email',
            'password_user'=>'required',
            'no_agen'=>'required|unique:agens,no_agen',
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

        Agen::create([
            'no_agen'=>$request->no_agen,
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'website'=>$request->website,
            'logo'=>$logo,
            'npwp'=>$request->npwp,
            'user_id'=>$user->id
        ]);

        return redirect()->back()->with('status','Successfully created Agen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agen = Agen::findOrFail($id);

        return view('agen.detail',compact('agen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agen = Agen::findOrFail($id);

        return view('agen.edit',compact('agen'));
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
        $agen = Agen::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email_user'=>'required|email|unique:users,email,'.$agen->user->id,
            'no_agen'=>'required|unique:agens,no_agen,'.$agen->id,
        ]);

        if ($request->file('logo')) {
            $request->validate([
                'logo'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($agen->logo == "logos/default.jpg") && file_exists('uploads/'.$agen->logo)) {
                File::delete('uploads/'.$agen->logo);
            }
            $logo = 'logos/'.time().$request->file('logo')->getClientOriginalName();
            $request->file('logo')->move('uploads/logos', $logo);
            $agen->update([
                'logo'=> $logo
            ]);
        }

        if ($request->password) {
            $request->validate([
                'password'=>'min:6',
            ]);
            $agen->user()->update([
                'password'=>Hash::make($request->password_user),
            ]);
        }
        $agen->user()->update([
            'email'=>$request->email_user
        ]);

        $agen->update([
            'no_agen'=>$request->no_agen,
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'website'=>$request->website,
            'npwp'=>$request->npwp
        ]);

        return redirect()->back()->with('status','Successfully updated Agen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agen = Agen::findOrFail($id);
        $user = $agen->user;
        if (!($agen->logo == "logos/default.jpg") && file_exists('uploads/'.$agen->logo)) {
            File::delete('uploads/'.$agen->logo);
        }
        $agen->delete();
        $user->delete();
        return redirect()->back()->with('status','Successfully deleted Agen');
    }
}
