<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    public function location(){
        return $this -> belongsTo(Location::class); 
    }    

    public function hazard(){
        return $this -> belongsTo(Hazard::class); 
    }        
}
