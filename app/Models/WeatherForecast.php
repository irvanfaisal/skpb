<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;
    protected $fillable = ['location_id','forecast_time','date','rain','temperature','rh','radiation','pressure','wdir','wspd'];

    public function location(){
        return $this -> belongsTo(Location::class); 
    }    
}
