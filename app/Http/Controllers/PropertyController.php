<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
          $properties=Property::all();
        return response()->json([
             'properties'=>$properties
        ]
        );
    }

    public function show($id)
    {
        $property=Property::find($id);
        return response()->json([
             'property'=>$property
        ]
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'organization_id'=>'required',
            'description'=>'required',

            'type'=>'required',
            'address'=>'required',
            'total_units'=>'required'
        ]);
        $property=Property::create($request->all());
        return response()->json([
             'property'=>$property
        ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'organization_id'=>'required',
            'description'=>'required',

            'type'=>'required',
            'address'=>'required',
            'total_units'=>'required'
        ]);
        $property=Property::find($id);
        $property->update($request->all());
        return response()->json([
             'property'=>$property
        ]
        );
    }

    public function delete($id)
    {
        $property=Property::find($id);
        $property->delete();
        return response()->json([
             'message'=>'deleted successfully'
        ]
        );
    }
}
