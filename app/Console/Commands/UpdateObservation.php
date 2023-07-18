<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\Station;
use App\Models\Observation;

class UpdateObservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'observation:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Observation Data';

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


        $stations = Station::all();
        foreach ($stations as $key => $station) {
            $count = 0;
            $errorCount = 0;
            $data = array();
            $this->line($key . '. processing ' . $station->station_id);
            $json = file_get_contents('http://202.4.179.117/API/api.php?Station=' . preg_replace('/[0-9]+/', '', $station->station_id) . '&Limit=3000');
            $rows = json_decode($json,true);
            if ($rows) {
                $rows = collect($rows)->sortBy('ts');
                $grouped = $rows->groupBy(function ($item, $key) {
                    return Carbon::parse($item['ts'])->timestamp - Carbon::parse($item['ts'])->timestamp % (1800);
                });
                foreach ($grouped as $key => $value){
                    $sensor_1 = null;
                    $sensor_2 = null;
                    $sensor_3 = null;                    
                    if ($value->average('CBS')) {
                        $sensor_1 = $value->average('CBS');
                    }
                    if ($value->average('SE200')) {
                        $sensor_2 = $value->average('SE200');
                    }
                    if ($value->average('KRG')) {
                        $sensor_3 = $value->average('KRG');
                    }
                    $this->line(Carbon::createFromTimestamp($key));
                    $hash = md5($station->id . '-' . Carbon::createFromTimestamp($key) . '-' . floatval($sensor_1) . '-' .floatval($sensor_2) . '-' .floatval($sensor_3));
                    $data = Observation::updateOrCreate(
                        ['date' => Carbon::createFromTimestamp($key),'station_id' => $station->id],
                        ['date' => Carbon::createFromTimestamp($key),'station_id' => $station->id,'sensor_1' => floatval($sensor_1),'sensor_2' => floatval($sensor_2),'sensor_3' => floatval($sensor_3),'hash' => $hash]
                    );                   
                }
                // $data = array_unique($data, SORT_REGULAR);
                // foreach (array_chunk($data,1500) as $t) {
                //    Observation::insert($t);
                //    $this->line($station->name . ' ' . $count . ' row inserted');
                // }                  
                // foreach ($rows as $idx => $value) {
                //     if ($value) {
                //         $sensor_1 = null;
                //         $sensor_2 = null;
                //         $sensor_3 = null;
                //         if (array_key_exists('CBS',$value)) {
                //             $sensor_1 = $value['CBS'];
                //         }
                //         if (array_key_exists('SE200',$value)) {
                //             $sensor_2 = $value['SE200'];
                //         }
                //         if (array_key_exists('KRG',$value)) {
                //             $sensor_3 = $value['KRG'];
                //         }
                //         $hash = md5($station->id . '-' . $value['ts'] . '-' . floatval($sensor_1) . '-' .floatval($sensor_2) . '-' .floatval($sensor_3));
                //         $tmp = [
                //             "station_id" => $station->id,
                //             "date" => Carbon::parse($value['ts']),
                //             "sensor_1" => floatval($sensor_1),
                //             "sensor_2" => floatval($sensor_2),
                //             "sensor_3" => floatval($sensor_3),
                //             "residu_1" => null,
                //             "residu_2" => null,
                //             "residu_3" => null,
                //             "hash" => $hash
                //         ];
                //         $check = Observation::where('hash',$hash)->first();
                //         // $this->line(Carbon::parse($value[1])->format("Y-m-d H:i:s"));
                //         // array_push($data, $tmp);
                            
                //         if(!$check){
                //             // $this->line(Carbon::parse($value[1])->format("Y-m-d H:i:s"));
                //             array_push($data, $tmp);
                //             $count++;
                //         }else{
                //             $errorCount++;
                //         }
                //         if ($errorCount > 10) {
                //             $this->line('Stop Checking');
                //             break;
                //         }
                //     }
                // }
                // $data = array_unique($data, SORT_REGULAR);
                // foreach (array_chunk($data,1500) as $t) {
                //    Observation::insert($t);
                //    $this->line($station->name . ' ' . $count . ' row inserted');
                // }                
            }
        }

        ///CRAWLING INA-SEALEVEL        
        // // $lists = ['0037BNTN01','0150SERA01','0164SBSI01','0080KTAG01','0006PANJ01','0036PTLN02'];
        // $lists = ['0009MMJU02','0051TLTL02','0016LMBR02','0082NUSA02','0145CRIK02','0043BDAS02'];
        // foreach ($lists as $idx => $list) {
        //     $station = Station::where('station_id',$list)->first();
        //     $date = Carbon::parse('2019-06-01');
        //     for ($i=0; $i <= 500 ; $i++) {
        //         $date->subDays(1);
        //         $count = 0;
        //         $errorCount = 0;
        //         $this->line('--------------------------------');
        //         $this->line($idx . '. Processing ' . $station->name . ' ' . $date->format('Y-m-d'));
        //         $client = new Client(HttpClient::create(['timeout' => 10]));
        //         $stationId = intval(substr($station->station_id,0,4));
        //         $crawler = $client->request('GET', 'http://ina-sealevelmonitoring.big.go.id/ipasut/data/residu/day/' . $stationId . '/' . $date->format('Y-m-d'));
        //         // $content  = $crawler->filter('table')->eq(2)->text();
        //         $data = array();
        //         $content  = $crawler->filter('table')->eq(2)->filter('tr')->each(function ($tr, $i) { return $tr->filter('td')->each(function ($td, $i) { return trim($td->text()); }); });
        //         foreach (array_reverse($content) as $key => $row) {
        //             if ($row) {
        //                 $hash = md5($station->id . '-' . $row[1]) . '-' . floatval($row[2]) . '-' .floatval($row[3]) . '-' .floatval($row[4]);
        //                 $tmp = [
        //                     "station_id" => $station->id,
        //                     "date" => Carbon::parse($row[1]),
        //                     "sensor_1" => floatval($row[2]),
        //                     "sensor_2" => floatval($row[3]),
        //                     "sensor_3" => floatval($row[4]),
        //                     "residu_1" => floatval($row[5]),
        //                     "residu_2" => floatval($row[6]),
        //                     "residu_3" => floatval($row[7]),
        //                     "hash" => $hash
        //                 ];
        //                 $check = Observation::where('hash',$hash)->first();
        //                 // $this->line(Carbon::parse($row[1])->format("Y-m-d H:i:s"));
        //                 // array_push($data, $tmp);
                            
        //                 if(!$check){
        //                     // $this->line(Carbon::parse($row[1])->format("Y-m-d H:i:s"));
        //                     array_push($data, $tmp);
        //                     $count++;
        //                 }else{
        //                     $errorCount++;
        //                 }
        //                 if ($errorCount > 10) {
        //                     $this->line('Stop Checking');
        //                     break;
        //                 }
        //             }
        //         };
        //         foreach (array_chunk($data,1500) as $t) {
        //            Observation::insert($t);
        //            $this->line($station->name . ' ' . $count . ' row inserted');
        //         }
        //         // if ($data){
        //         //     break;    
        //         // };
        //     }
        // }
    }
}
