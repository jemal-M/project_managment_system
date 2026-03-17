<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return response()->json(['tenants'=>$tenants]);
    }

    public function show(Tenant $tenant)
    {
        return response()->json($tenant);
    }
     
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required',
            'id_number' => 'required',
            'user_id' => 'required',
            'address'=>'required'
        ]);
        $tenant = Tenant::create($request->all());
        return response()->json($tenant, 201);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'organization_id' => 'required',
            'id_number' => 'required',
            'user_id' => 'required',
            'address'=>'required'
        ]);
        $tenant->update($request->all());
        return response()->json($tenant, 200);
    }

    public function delete(Tenant $tenant)
    {
        $tenant->delete();
        return response()->json(null, 204);
    }

    public function getTenantsByOrganization($organization_id){
        $tenants = Tenant::where('organization_id', $organization_id)->get();
        return response()->json(['tenants'=>$tenants]);
    }

    public function getTenantByUser($user_id){
        $tenants = Tenant::where('user_id', $user_id)->get();
        return response()->json(['tenants'=>$tenants]);
    }

    public function getTenantByIdNumber($id_number){
        $tenants = Tenant::where('id_number', $id_number)->get();
        return response()->json(['tenants'=>$tenants]);
    }

    public function getTenantByAddress($address){
        $tenants = Tenant::where('address', $address)->get();
        return response()->json(['tenants'=>$tenants]);
    }
     
}
