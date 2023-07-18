<?php

namespace App\Imports;

use App\Models\WeatherForecast;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class WeatherImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new WeatherForecast([
            'location_id' => $row['village_id'],
            'forecast_time' => $row['model'],
            'date' => \Carbon\Carbon::parse($row['datetime'])->addHours(8)->format('Y-m-d H:i'),
            'rain' => $row['rain'],
            'temperature' => $row['temp'],
            'rh' => $row['rh'],
            'radiation' => $row['radiation'],
            'pressure' => $row['pressure'],
            'wdir' => $row['wdir'],
            'wspd' => $row['wspd']
        ]);
    }
    
    public function chunkSize(): int
    {
        return 10000;
    }    
}
