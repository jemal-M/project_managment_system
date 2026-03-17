<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['property_id','unit_number','rent_amount','status'];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function lease()
    {
        return $this->hasOne(Lease::class);
    }
    public function maintenanceRequest()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
