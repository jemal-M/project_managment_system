<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function userAnalytics()
    {
          $totalUsers=User::count();
          $activeUsers=User::where('status',1)->count();
          $inactiveUsers=User::where('status', 0)->count();
          $data=['total'=>$totalUsers, 'active'=>$activeUsers, 'inactive'=>$inactiveUsers];
        return response()->json(
               ['data'=>$data]
        );
    }

    public function userChart()
    {
        $users = User::select(DB::raw("COUNT(*) as count"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('count');

        return response()->json(['data'=>$users]);
    }


    public function propertyAnalysis(){
          $properties=Property::select(DB::raw("COUNT(*) as count"))
          ->whereYear('created_at', date('Y'))
          ->groupBy(DB::raw("Month(created_at)"))
          ->pluck('count');
          return response()->json(['data'=>$properties]);
    }

    public function featuredProperties(){
         $featured=Property::where('featured', 1)->count();
         $total=Property::count();
         $data=['featured'=>$featured, 'total'=>$total];
         return response()->json(['data'=>$data]);
    }
    public function tenantAnalysis(){
         $tenants=Tenant::where('tenant', '!=', Null)->count();
         $total=Tenant::count();
         $data=['tenants'=>$tenants, 'total'=>$total];
         return response()->json(['data'=>$data]);
    }


    public function unitAnalysis(){
         $available=Property::where('status', 'Available')->count();
         $occupied=Property::where('status', 'Occupied')->count();
         $data=['available'=>$available, 'occupied'=>$occupied];
         return response()->json(['data'=>$data]);

    }

    public function recentActivities(){
         $activities=User::with('roles')->get();
         return response()->json(['data'=>$activities]);
    }

    public function propertyMap(){
         $properties=Property::all();
         return response()->json(['data'=>$properties]);
    }
}
