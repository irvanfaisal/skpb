<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Dibi;

class UpdateDibi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dibi:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update DIBI from gis.bnpb.go.id';

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
        $today = Carbon::now();
        $file = fopen(Storage::disk('local')->path('dibi/dibi_2022-04-12.csv'), "r");
        $keys = fgetcsv($file, 0, ",");

        while (($line = fgetcsv($file, 0, ",")) !== FALSE) {
            $array[] = array_combine($keys, $line);
        }       
        // $lines = explode(PHP_EOL, $csvData);
        // $array = array();
        // foreach ($lines as $line) {
        //     $array[] = str_getcsv($line);
        // }
        $countCreate = 0;
        $countUpdate = 0;
        foreach (array_slice($array,-20,20,true) as $key => $value) {
            try{
                $tmp = Dibi::updateOrCreate(
                    ['regency_id' => $value['ID Kabupaten'],'date' => Carbon::parse($value['Tanggal Kejadian']),'hazard' => $value['Kejadian'],'location' => $value['Lokasi']],
                    ['regency_id' => $value['ID Kabupaten'], 'regency_name' => $value['Kabupaten'], 'province_name' => $value['Provinsi'], 'date' => Carbon::parse($value['Tanggal Kejadian']), 'hazard' => $value['Kejadian'], 'location' => $value['Lokasi'], 'chronology' => $value['Kronologi & Dokumentasi'], 'cause' => $value['Penyebab'], 'dead' => $value['Meninggal'], 'missing' => $value['Hilang'], 'injured' => $value['Terluka'], 'house' => $value['Rumah Rusak'], 'facility' => $value['Fasum Rusak']]
                );
            } catch(\Exception $e){

            }
        }
    }
}
