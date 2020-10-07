<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use DataTables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('user.index',compact('users'));
    }
    public function user_data()
    {
        $users = User::select(['id','email','role_id']);

        $dataTable = DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('url_detail', function ($data) {
                return route('user.show', $data->id);
            });

        return $dataTable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('user.detail',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        $user = Auth::user();

        return view('auth.profile',compact('user'));
    }

    public function profileedit()
    {
        $user = Auth::user();

        return view('auth.edit',compact('user'));
    }

    public function profileupdate(Request $request)
    {
        $admin = Auth::user()->admin;
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required',
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
        ]);

        if ($request->password) {
            $admin->user()->update([
                'password'=>Hash::make($request->password),
            ]);
        }
        return redirect()->route('profile.user')->with('status','successfully Updated Admin');
    }
}
