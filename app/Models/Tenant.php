<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
     protected $fillable = [
        'user_id', 'organization_id', 'id_number','address'
    ];
 
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function leases(){
        return $this->hasMany(Lease::class);
    
    }
    public function payments(){
          
        return $this->hasMany(Payment::class);

    }
    public function maintenanceRequest(){
           return $this->hasMany(MaintenanceRequest::class);

    
    }
}
