<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $weather_variables = ['rain','wspd','temp','rh'];
        foreach ($weather_variables as $weather) {
            $date = \Carbon\Carbon::now()->addDays(-1);
            for ($i=1; $i < 168; $i++) {
                $url = "http://167.205.106.70/web/forecast/projects/belu/" . $weather . "/" . $weather . '-' . $date->format("YmdH") . ".tif";
                
                $filename = basename($url);
                Storage::delete('public/weather/' . $weather . "/" . $filename);
                $date->addHours(-1);
            }
            $date = \Carbon\Carbon::now();
            for ($i=0; $i < 168; $i++) {
                $url = "http://167.205.106.70/web/forecast/projects/belu/" . $weather . "/" . $weather . '-' . $date->format("YmdH") . ".tif";
                
                $filename = basename($url);
                Storage::delete('public/weather/' . $weather . "/" . $filename);
                $this->line("Checking " . $url);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
                $result = curl_exec($curl);
                $retry = 0;
                while(curl_errno($curl) == 28 && $retry < 10){
                    $result = curl_exec($curl);
                    $this->line("Retry Downloading " . $url);
                    $retry++;
                }
              
                curl_close($curl);
                if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
                    Storage::disk('local')->put('public/weather/' . $weather . '/' . $filename, $result);
                }
                $date->addHours(1);
            }

        }
    }
}
