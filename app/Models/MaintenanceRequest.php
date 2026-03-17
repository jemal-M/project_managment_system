<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'unit_id',
        'tenant_id',
        'title',
        'requested_at',
        'completed_at',
        'description',
        'status',
    ];
    protected $dates=[
        'requested_at',
        'completed_at',
    ];
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
     
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
