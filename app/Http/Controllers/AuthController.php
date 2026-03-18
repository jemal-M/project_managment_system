<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     public function register(Request $request)
    {
         $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|confirmed',
            'role'=>'required'
        ]);
        $user =new User();
         $user->fill($request->all());
         $user->save();
        return response()->json([

            'token'=>$user,
        ]
        );
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string',
            
        ]);
        $user =User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password))
        {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
        return response()->json([

            'token'=>$user->createToken('auth_token')->plainTextToken,
        ]
        );
    }
    

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message'=>'Logged out'
        ];
    }

    public function user(Request $request)
    {
        return $request->user();
    }
    
}
