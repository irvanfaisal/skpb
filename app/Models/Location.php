<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;


    public function weather_forecasts(){
        return $this -> hasMany(WeatherForecast::class); 
    }

    public function forecasts(){
        return $this -> hasMany(Forecast::class); 
    }    
}
