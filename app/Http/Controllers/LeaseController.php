<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index(){
        $leases = Lease::all();
     return response()->json(['leases'=>$leases]);
    }
     
    public function store(Request $request){
        $request->validate([
            'unit_id'=>'required',
            'tenant_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'rent_amount'=>'required',
            'status'=>'required'

        ]);
        $lease = Lease::create($request->all());
        return response()->json(['lease'=>$lease]);
    }

    public function show($id){
        $lease = Lease::find($id);
        return response()->json(['lease'=>$lease]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'unit_id'=>'required',
            'tenant_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'rent_amount'=>'required',
            'status'=>'required'

        ]);
        $lease = Lease::find($id);
        $lease->update($request->all());
        return response()->json(['lease'=>$lease]);
    }

    public function destroy($id){
        $lease = Lease::find($id);
        $lease->delete();
        return response()->json(['message'=>'lease deleted']);
    }
     
}
