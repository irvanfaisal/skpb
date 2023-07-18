<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download Forecast Data from Server';

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
        $sources = ["WRF","BMKG","GFS"];
        $hazards = ["CUACA_EKSTREM","BANJIR"];
        foreach ($sources as $source) {
            foreach ($hazards as $hazard) {
                $date = \Carbon\Carbon::now();
                for ($i=0; $i < 10; $i++) {

                    $url = 'http://167.205.106.70/web/forecast/sibe/' . $source . '/' . $hazard . '/' . $date->format("Ymd") . '.json';
                    $filename = basename($url);
                    if ($hazard == "CUACA_EKSTREM") {
                        Storage::delete('public/forecast/' . $source . '/' . $hazard . '/' . $filename);
                    }
                    Storage::delete('forecast/' . $source . '/' . $hazard . '/' . $filename);
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
                        if ($hazard == "CUACA_EKSTREM") {
                            Storage::disk('local')->put('public/forecast/' . $source . '/' . $hazard . '/' . $filename, $result);
                        }
                        Storage::disk('local')->put('forecast/' . $source . '/' . $hazard . '/' . $filename, $result);
                    }
                    if ($hazard == "CUACA_EKSTREM") {
                        $url = 'http://167.205.106.70/web/forecast/sibe/' . $source . '/' . $hazard . '/area-' . $date->format("Ymd") . '.json';
                        $filename = basename($url);
                        Storage::delete('pubic/forecast/' . $source . '/' . $hazard . '/' . $filename);
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
                            Storage::disk('local')->put('public/forecast/' . $source . '/' . $hazard . '/' . $filename, $result);
                            Storage::disk('local')->put('forecast/' . $source . '/' . $hazard . '/' . $filename, $result);
                        }
                    }
                    $date->addDays(1);
                }
            }
        }
    }
}
