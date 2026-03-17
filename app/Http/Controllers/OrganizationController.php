<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return response()->json(['organizations'=>$organizations]);
    }

    public function show($id)
    {
        $organization = Organization::find($id);
        if(!$organization){
            return response()->json(['message'=>'Organization not found'], 404);
        }
        return response()->json(['organization'=>$organization]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'phone'=>'required',
            'address'=>'required'
        ]);
        $organization = Organization::create($request->all());
        return response()->json(['organization'=>$organization, 'message'=>'Organization created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string',
            'phone'=>'',
            'address'=>''
        ]);
        $organization = Organization::find($id);
        if(!$organization){
            return response()->json(['message'=>'Organization not found'], 404);
        }
        $organization->update($request->all());
        return response()->json(['organization'=>$organization, 'message'=>'Organization updated successfully']);
    }
      
    public function delete($id)
    {
        $organization = Organization::find($id);
        if(!$organization){
            return response()->json(['message'=>'Organization not found'], 404);
        }
        $organization->delete();
        return response()->json(['message'=>'Organization deleted successfully']);
    }
    
}
