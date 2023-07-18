<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\VolcanoEruption;
use App\Models\VolcanoActivity;
use Goutte\Client;

class UpdateVolcano extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volcano:update';

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

        $client = new Client();
        $date = \Carbon\Carbon::now();
        $crawler = $client->request('GET', 'https://magma.esdm.go.id/v1/gunung-api/informasi-letusan');
        $data = $crawler->filter('.timeline-item')->each(function($node){
            global $date;
            $check = $node->filter('.timeline-time')->first();
            if (strlen($check->text()) > 5) {
                $time = $check->text();
                $article = $node->filter('.timeline-text')->text();
                $title = $node->filter('.timeline-title')->text();
                $dateArticle = $date->format("Y-m-d");
                $img = $node->filter('img')->getNode(0)->getAttribute('src');
                if ($img) {
                    copy($img, (storage_path('app/public/eruption/') . basename($img)));
                }
                $tmp = [
                    "title" => $title,
                    "article" => $article,
                    "img" => 'eruption/' . basename($img),
                    "date" => $dateArticle,
                    "time" => $time
                ];
                return $tmp;
            }else{
                $tmp = $node->filter('.timeline-date')->text();
                $tmp = explode(", ", $tmp);
                foreach ($tmp as $y) {
                    try {
                         setlocale(LC_TIME, 'id_ID');
                         \Carbon\Carbon::setLocale('id');                        
                        $dateString = \Carbon\Carbon::translateTimeString($y,'id');
                        $date = \Carbon\Carbon::createFromFormat('d F Y',$dateString);
                        break;                
                    } catch (\Exception $e) {
                    }                    
                }        
            }
        });
        $data = array_filter($data);
        foreach ($data as $key => $value) {
                $tmp = VolcanoEruption::updateOrCreate(
                    ['date' => $value['date'],'time' => $value['time'],'article' => $value['article']],
                    ['title' => $value['title'], 'article' => $value['article'], 'img' => $value['img'], 'date' => $value['date'], 'time' => $value['time']]
                );
        }

        $client = new Client();
        $date = \Carbon\Carbon::now()->format("Y-m-d");
        $crawler = $client->request('GET', 'https://magma.esdm.go.id/v1/gunung-api/laporan');
        $data = $crawler->filter('.timeline-item')->each(function($node){
            global $date;
            $check = $node->filter('.timeline-time')->first();
            if (strlen($check->text()) > 5) {
                $time = $check->text();
                $article = $node->filter('p')->each(function($node2){
                    return $node2->text();
                });
                $dateArticle = $date->format("Y-m-d");
                $title = $node->filter('.timeline-title')->each(function($node2){
                    return strip_tags($node2->html());
                });
                $title = explode("\n",$title[0]);
                $tmp = [
                    "title" => trim($title[0]),
                    "status" => trim($title[1]),
                    "article" => $article[2],
                    "date" => $dateArticle,
                    "time" => $time
                ];
                return $tmp;
            }else{

                $tmp = $node->filter('.timeline-date')->text();
                $tmp = preg_split('/[,|-]/', $tmp);
                foreach ($tmp as $y) {
                    try {
                         setlocale(LC_TIME, 'id_ID');
                         \Carbon\Carbon::setLocale('id');                        
                        $dateString = \Carbon\Carbon::translateTimeString(trim($y),'id');
                        $date = \Carbon\Carbon::createFromFormat('d F Y',$dateString);
                        break;                
                    } catch (\Exception $e) {
                        // $this->line('error');
                    }                    
                }        
            }
        });
        $data = array_filter($data);
        foreach ($data as $key => $value) {
                $tmp = VolcanoActivity::updateOrCreate(
                    ['date' => $value['date'],'time' => $value['time'],'article' => $value['article']],
                    ['title' => $value['title'], 'article' => $value['article'], 'status' => $value['status'], 'date' => $value['date'], 'time' => $value['time']]
                );
        }


        $csvData = file_get_contents(Storage::disk('local')->path('volcano/aktivitas.csv'));
        $lines = explode(PHP_EOL, $csvData);
        $array = array();
        foreach ($lines as $line) {
            $array[] = str_getcsv($line);
        }
        $gatra = [];
        for ($i = 1;$i<count($array)-1; $i++) {
            $data = VolcanoActivity::updateOrCreate(
                ['date' => $array[$i][4],'time' => $array[$i][5],'article' => $array[$i][3]],
                ['title' => $array[$i][1], 'article' => $array[$i][3], 'status' => $array[$i][2], 'date' => $array[$i][4], 'time' => $array[$i][5]]
            );
        };   

    }
}
