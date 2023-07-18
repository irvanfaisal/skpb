<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WeatherForecast;
use App\Models\Forecast;
use App\Models\Location;
use Stevebauman\Location\Facades\Location as Loc;
use Carbon\Carbon;
class FilterWeather extends Component
{

    public $searchLocation;
    public $locations;
    protected $listeners = ['getLocation'];

    public $readyToLoad = false;
 
    public function init()
    {
        $this->readyToLoad = true;
    }

    public function mount(){
        $locations = Location::orderBy('village','asc')->get();
        $position = Loc::get();
        if ($position->countryName == "Indonesia") {
            $locations = Location::orderBy('village','asc')->get();
            foreach ($locations as $key => $location)
            {
              $a = $position->latitude - $location['lat'];
              $b = $position->longitude - $location['lon'];
              $distance = sqrt(($a**2) + ($b**2));
              $distances[$key] = $distance;
            }

            asort($distances);
            $closest = $locations[key($distances)];
        } else {
            $closest = Location::where('id',2)->first();
        }

        $this->searchLocation = $closest->id;
        $this->locations = $locations;
    }

    public function getLocation($id)
    {
        $this->searchLocation = $id;
    }

    public function render()
    {
        $this->dispatchBrowserEvent('reload');
        $locationId = $this->searchLocation;
        $location = Location::whereId($locationId)->first();

        $dateDaily = Carbon::today()->format('Y-m-d H:00:00');
        $forecast = WeatherForecast::whereDate("date","=",$dateDaily)->where("location_id",$location->id)->orderBy('date','asc')->orderBy('forecast_time','desc')->get()->groupBy('date');
        $hourlyForecast = [];
        foreach ($forecast as $key => $value) {
            $value[0]['temperature'] =  $value[0]['temperature'] - 273.15;
            $hourlyForecast[] = $value[0];
        }


        Carbon::setLocale('id');
        $date = Carbon::now()->format('Y-m-d H:00:00');
        $dataDaily = [];
        $dataHourly = [];
        $allData = [];
        for ($i=0; $i < 8; $i++) {
            $dateDaily = Carbon::today()->addDays($i)->format('Y-m-d H:00:00');
            $forecast = WeatherForecast::whereDate("date","=",$dateDaily)->where("location_id",$location->id)->orderBy('date','asc')->orderBy('forecast_time','desc')->get()->groupBy('date');
            $hourlyForecast = [];
            foreach ($forecast as $key => $value) {
                $hourlyForecast[] = $value[0];
            }
            $allData = array_merge($allData,$hourlyForecast);
            $hourlyForecast = collect($hourlyForecast);
            $dataDaily[] = [
                "date" => $dateDaily,
                "rain" => $hourlyForecast->pluck("rain")->sum(),
                "temperature" => ($hourlyForecast->pluck("temperature")->avg() - 273.15)
            ];
        }

        for ($i=1; $i < 24; $i++) {
            $dateHourly = Carbon::now()->addHours($i)->format('Y-m-d H:00:00');
            $forecast = WeatherForecast::where("date",$dateHourly)->where("location_id",$location->id)->orderBy('date','asc')->orderBy('forecast_time','desc')->get()->groupBy('date');
            $hourlyForecast = [];
            foreach ($forecast as $key => $value) {
                $hourlyForecast[] = $value[0];
            }
            
            $hourlyForecast = collect($hourlyForecast);
            $dataHourly[] = [
                "date" => $dateHourly,
                "rain" => $hourlyForecast->pluck("rain")->sum(),
                "temperature" => ($hourlyForecast->pluck("temperature")->avg()- 273.15)
            ];
        }
        $forecast = WeatherForecast::where("date",$date)->where("location_id",$location->id)->orderBy('forecast_time','desc')->first();
        if (!$forecast) {
            $forecast = new \stdClass();
            $forecast->date = Carbon::now()->format("Y-m-d H:00");
            $forecast->rain = NULL;
            $forecast->temperature = NULL;
        }else{
            $forecast->temperature =  $forecast->temperature - 273.15;
        }

        $longterm = Forecast::where('location_id',$location->id)->get();

        $data = [
            "daily" => $dataDaily,
            "hourly" => $dataHourly,
            "date" => $forecast->date,
            "currentForecast" => $forecast,
            "location" => $location,
            "longterm" => $longterm,
        ];

        $chartData = collect($dataHourly)->filter(function ($value, $key) {
                return $value;
            // if(Carbon::parse($value["date"])->isSameDay(Carbon::now())) {
            // }            

        });

        $this->dispatchBrowserEvent('reload-chart', ['data' => $chartData,'longterm' => $longterm,'location' => $location]);        

        return view('livewire.filter-weather',[
            "daily" => $dataDaily,
            "hourly" => $dataHourly,
            "date" => $forecast->date,
            "currentForecast" => $forecast,
            "allData" => $allData,
            "location" => $location,
            "longterm" => $longterm
        ]);
    }
}
