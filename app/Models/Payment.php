<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'tenant_id', 'lease_id', 'amount', 'payment_date','status','payment_method'
    ];
   protected $dates=[
    'payment_date'
   ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
