<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadHotspot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hotspot:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download Hotspot Data';

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
        $sources = ["modis","viirs"];

        foreach ($sources as $source) {
            $date = \Carbon\Carbon::now();
            for ($i=0; $i < 10; $i++) {
                if ($source == 'modis') {
                    $url = "http://167.205.106.70/web/FIRMS/modis-c6-neo/SouthEast_Asia/MODIS_C6_1_SouthEast_Asia_MCD14DL_NRT_" . $date->year . ($date->dayOfYear < 10 ? ("00" . $date->dayOfYear) : ($date->dayOfYear < 100 ? ("0" . $date->dayOfYear) : $date->dayOfYear)) . "_formatted.txt";
                }
                if ($source == 'viirs') {
                    $url = "http://167.205.106.70/web/FIRMS/suomi-viirs-neo/SouthEast_Asia/SUOMI_VIIRS_C2_SouthEast_Asia_VNP14IMGTDL_NRT_" . $date->year . ($date->dayOfYear < 10 ? ("00" . $date->dayOfYear) : ($date->dayOfYear < 100 ? ("0" . $date->dayOfYear) : $date->dayOfYear)) . "_formatted.txt";
                }
                
                $filename = basename($url);
                Storage::delete('hotspot/' . $source . '/' . $filename);
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
                    Storage::disk('local')->put('hotspot/' . $source . '/' . $filename, $result);
                }
                $date->addDays(-1);
            }
        }


    }
}
