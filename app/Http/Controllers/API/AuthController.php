<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $result = null;
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
            'fcm_token'=>'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $authToken = auth()->user()->createToken('authToken')->accessToken;

            $user->update([
                'fcm_token'=>$request->fcm_token
            ]);
            $result = ([
                'id'=>$user->id,
                'email'=>$user->email,
                'role'=>$user->role->name,
                'access_token'=>$authToken,
                'fcm_token'=>$user->fcm_token
            ]);
            return response()->json([
                'user'=>$result
            ]);

        }else{
            return response()->json([
                'error'=>'email dan password tidak valid'
            ],400);
        }
    }

    public function logout()
    {
        $userLogout = Auth::user();
        $userLogout->update([
            'fcm_token'=>null
        ]);
        $userLogout->token()->revoke();
        return response()->json([
            'status'=>true,
            'message'=>'user berhasil logout'
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'email'=>'required|email|unique:users,email,'.$user->id,
            'old_password'=>'required',
            'new_password'=>'required',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status'=>true,
                'message'=>'Password lama tidak cocok'
            ],404);
        }

        $user->update([
            'email'=>$request->email,
            'new_password'=>Hash::make($request->password),
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Data user berhasil diubah'
        ]);
    }
}
