<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function properties(){
            
        return $this->hasMany(Property::class);
    
    }
    public function tenants(){
        return $this->hasMany(Tenant::class);
    }
}
 