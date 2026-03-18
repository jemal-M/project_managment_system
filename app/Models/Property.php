<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name', 'organization_id', 'description', 'type', 'address', 'total_units'
    ];
    public function organization(){
         
    
        return $this->belongsTo(Organization::class);

    }

    public function units(){

        return $this->hasMany(Unit::class);

    }
}
