<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationProvince extends Model
{
    use HasFactory;
    
    public function regencies(){
        return $this -> hasMany(LocationRegency::class, 'province_id', 'province_id'); 
    }
}
