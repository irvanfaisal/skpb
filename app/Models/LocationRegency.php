<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationRegency extends Model
{
    use HasFactory;
    
    public function province(){
        return $this -> belongsTo(LocationProvince::class, 'province_id', 'province_id'); 
    }
}
