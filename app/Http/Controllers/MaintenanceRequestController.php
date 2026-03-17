<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
         // get all maintenance requests
         $maintenanceRequests = MaintenanceRequest::all();
        return response()->json([
            'maintenance_requests' => $maintenanceRequests
        ]);
    }

    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:tenants,id',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'title' => 'required',
            'requested_at' => 'required|date',
            'completed_at' => 'nullable|date'
        ]);

        // create maintenance request
        $maintenanceRequest = MaintenanceRequest::create($request->all());

        return response()->json([
            'message' => 'Maintenance request created successfully',
            'maintenance_request' => $maintenanceRequest
        ], 201);
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        return response()->json([
            'maintenance_request' => $maintenanceRequest
        ]);
    }
     
    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        // validate request
        $request->validate([
            'property_id' => 'exists:properties,id',
            'tenant_id' => 'exists:tenants,id',
            'description' => 'string',
            'status' => 'in:pending,in_progress,completed',
            'title' => 'required',
            'requested_at' => 'date',
            'completed_at' => 'date'
        ]);

        // update maintenance request
        $maintenanceRequest->update($request->all());

        return response()->json([
            'message' => 'Maintenance request updated successfully',
            'maintenance_request' => $maintenanceRequest
        ]);
    }
      public function   destroy(MaintenanceRequest $maintenanceRequest)
    {
        // delete maintenance request
        $maintenanceRequest->delete();

        return response()->json([
            'message' => 'Maintenance request deleted successfully'
        ]);
    }

}
