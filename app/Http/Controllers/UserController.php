<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['users'=>$users]);
    }

    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'], 404);
        }
        return response()->json(['user'=>$user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message'=>'User deleted']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|confirmed',
            'role'=> 'required',
            'phone' => 'required|unique:users,phone,'.$id,
            'profile_image'=>'required'
        ]);
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'], 404);
        }
        $user->update($request->all());
        return response()->json(['user'=>$user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role'=> 'required',
            'phone' => 'required|unique:users',
            'profile_image'=>'required'
        ]);
        $user = User::create($request->all());
        return response()->json(['user'=>$user]);
    }
}
