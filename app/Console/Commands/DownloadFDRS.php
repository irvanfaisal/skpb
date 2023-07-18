<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadFDRS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fdrs:download';

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
        $date = \Carbon\Carbon::now();
        for ($i=0; $i < 4; $i++) {
            $url = "http://167.205.106.70/web/fdrs/FDRS/fdrs_" . $date->format("Ymd") . ".tif";
            
            $filename = basename($url);
            Storage::delete('public/fdrs/' . $filename);
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
                Storage::disk('local')->put('public/fdrs/' . $filename, $result);
            }
            $date->addDays(1);
        }
    }
}
