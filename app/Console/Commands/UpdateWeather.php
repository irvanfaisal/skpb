<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\WeatherImport;
use Spatie\Browsershot\Browsershot;
        use Illuminate\Support\Facades\Auth;
        use App\Models\User;
        use App\Models\WeatherForecast;

class UpdateWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Weather Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://167.205.106.70/web/wrf/latest.txt");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


            $latest = curl_exec($ch);
            $retry = 0;
            while(curl_errno($ch) == 28 && $retry < 10){
                $latest = curl_exec($ch);
                $retry+=1;
                $this->line('Retry ' . $retry);
            }
            curl_close($ch);
            $currentLatest = file_get_contents(Storage::disk('local')->path('weather/latest.txt'));
            if ($currentLatest != $latest) {
                // $latest = '20221215_12';
                file_put_contents(Storage::disk('local')->path('weather/latest.txt'),$latest);                
                $latest = preg_replace( "/<br>|\n/", "", $latest);
                $latest = preg_replace("/ /", "_", $latest);
                $this->line('Updating ' . $latest . '.csv');
                Excel::import(new WeatherImport, Storage::disk('local')->path('weather/WRF_' . $latest . '.csv'));
            }
    }
}
