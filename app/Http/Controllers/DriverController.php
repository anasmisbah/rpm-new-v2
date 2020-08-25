<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;
use App\User;
use App\Agen;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;
class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $agen = Agen::findOrFail($id);

        return view('driver.index',compact('agen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $agen = Agen::findOrFail($id);
        return view('driver.create',compact('agen'));
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
            'address'=>'required|min:5',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'route'=>'required'
        ]);

        $avatar='avatars/default.jpg';
        if ($request->file('avatar')) {
            $request->validate([
                'avatar'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            $avatar = 'avatars/'.time().$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move('uploads/avatars', $avatar);
        }

        $user = User::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role_id'=>5
        ]);

        Driver::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'avatar'=>$avatar,
            'user_id'=>$user->id,
            'agen_id'=>$agen->id,
            'route'=>$request->route
        ]);

        return redirect()->back()->with('status','successfully created Driver');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        $agen = $driver->agen;
        return view('driver.detail',compact('driver','agen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        $agen = $driver->agen;
        return view('driver.edit',compact('driver','agen'));
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
        $driver = Driver::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'address'=>'required|min:5',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email'=>'required|email|unique:users,email,'.$driver->user->id,
            'route'=>'required'
        ]);

        if ($request->file('avatar')) {
            $request->validate([
                'avatar'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($driver->avatar == "avatars/default.jpg") && file_exists('uploads/'.$driver->avatar)) {
                File::delete('uploads/'.$driver->avatar);
            }
            $avatar = 'avatars/'.time().$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move('uploads/avatars', $avatar);
            $driver->update([
                'avatar'=> $avatar
            ]);
        }

        if ($request->password) {
            $request->validate([
                'password'=>'min:6',
            ]);
            $driver->user()->update([
                'password'=>Hash::make($request->password),
            ]);
        }
        $driver->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'route'=>$request->route
        ]);

        $driver->user()->update([
            'email'=>$request->email,
        ]);

        return redirect()->back()->with('status','successfully Updated Driver');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $user = $driver->user;
        if (!($driver->avatar == "avatars/default.jpg") && file_exists('uploads/'.$driver->avatar)) {
            File::delete('uploads/'.$driver->avatar);
        }
        $driver->delete();
        $user->delete();

        return redirect()->back()->with('status','successfully Deleted Driver');
    }
}
