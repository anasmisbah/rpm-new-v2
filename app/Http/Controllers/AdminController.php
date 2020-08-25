<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Admin;
use File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();

        return view('admin.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
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
            'address'=>'required|min:5',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role_id'=>'required'
        ]);

        $user = User::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role_id'=>$request->role_id
        ]);

        $avatar='';
        if ($request->file('avatar')) {
            $request->validate([
                'avatar'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            $avatar = 'avatars/'.time().$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move('uploads/avatars', $avatar);
        }

        $user->admin()->create([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'avatar'=>$avatar,
        ]);

        return redirect()->back()->with('status','successfully created Admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.detail',compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.edit',compact('admin'));
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
        $admin = Admin::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'address'=>'required|min:5',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email'=>'required|email|unique:users,email,'.$admin->user->id,
            'role_id'=>'required'
        ]);

        if ($request->file('avatar')) {
            $request->validate([
                'avatar'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($admin->avatar == "avatars/default.jpg") && file_exists('uploads/'.$admin->avatar)) {
                File::delete('uploads/'.$admin->avatar);
            }
            $avatar = 'avatars/'.time().$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move('uploads/avatars', $avatar);
            $admin->update([
                'avatar'=> $avatar
            ]);
        }

        $admin->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
        ]);

        $admin->user()->update([
            'email'=>$request->email,
            'role_id'=>$request->role_id
        ]);

        if ($request->password) {
            $admin->user()->update([
                'password'=>Hash::make($request->password),
            ]);
        }
        return redirect()->back()->with('status','successfully Updated Admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $user = $admin->user;
        if (!($admin->avatar == "avatars/default.jpg") && file_exists('uploads/'.$admin->avatar)) {
            File::delete('uploads/'.$admin->avatar);
        }
        $admin->delete();
        $user->delete();

        return redirect()->back()->with('status','successfully Deleted Admin');
    }
}
