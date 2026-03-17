<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
         $units = Unit::with('products')->get();
        return response()->json([
            'units' => $units,
            'message' => 'success']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required',
            'unit_number'=>'required',
            'rent_amount'=>'required',
            'status'=>'required'
        ]);
        $unit = Unit::create($request->all());
        return response()->json([
            'unit' => $unit,
            'message' => 'success'
        ]);
    }

    public function show(Unit $unit)
    {
        return response()->json([
            'unit' => $unit,
            'message' => 'success'
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'property_id' => 'required',
            'unit_number'=>'required',
            'rent_amount'=>'required',
            'status'=>'required'
        ]);
        $unit->update($request->all());
        return response()->json([
            'unit' => $unit,
            'message' => 'success'
        ]);
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json([
            'message' => 'Unit deleted successfully'
        ]);
    }

    public function getAvailableUnits(){
        $units = Unit::where('status','available')->get();
        return response()->json([
            'units' => $units,
            'message' => 'success'
        ]);
    }

    public function getBookedUnits(){
        $units = Unit::where('status', 'booked')->get();
        return response()->json([
            'units' => $units,
            'message' => 'success'
        ]);
    }

    public function getOccupiedUnits(){
        $units = Unit::where('status', 'occupied')->get();
        return response()->json([
            'units' => $units,
            'message' => 'success'
        ]);
    }

    public function getUnitByProperty($property_id){
        $units = Unit::where('property_id', $property_id)->get();
        return response()->json([
            'units' => $units,
            'message' => 'success'
        ]);
    }

    public function getUnitByStatus($status){
        $units = Unit::where('status', $status)->get();
        return response()->json([
            'units' => $units,
            'message' => 'success'
        ]);
    }

    public function search(Request $request){
        $units = Unit::where('unit_number', 'like', '%'.$request->search.'%')->get();
        return response()->json([
            'units' => $units,
            'message' => 'success'
        ]);
    }
     
}
