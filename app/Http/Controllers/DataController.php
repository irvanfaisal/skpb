<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forecast;
use App\Models\Location;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function getForecast(Request $request)
    {        
        $forecast = Forecast::where('date',$request->month . '-01')->where('dasarian',$request->dasarian)->get()->groupBy('location_id');
        $data = [];
        foreach($forecast as $key => $value){
            $tmp = [
                "location_id" => $key,
                "iklim" => $value->where('hazard_id',1)->first()->value,
                "kekeringan" => $value->where('hazard_id',5)->first()->value,
                "banjir" => $value->where('hazard_id',3)->first()->value,
                "longsor" => $value->where('hazard_id',4)->first()->value,
            ];
            array_push($data,$tmp);
            
        }

        return $data;
    }

    public function getHama(Request $request)
    {        
        $data = Forecast::where('hazard_id',8)->where('date',$request->month . '-01')->where('dasarian',$request->dasarian)->get();
        return $data;
    }    
    
    public function getKatam(Request $request)
    {        
        $data = Forecast::where('date',$request->month . '-01')->where('dasarian',$request->dasarian)->where('hazard_id',2)->get();
        return $data;
    }
    
    public function getKatamPalawija(Request $request)
    {        
        $data = Forecast::where('date',$request->month . '-01')->where('dasarian',$request->dasarian)->where('hazard_id',7)->get();
        return $data;
    }

    public function getVillageForecast(Request $request)
    {        

        $forecast = Forecast::whereYear('date',$request->month . '-01')->where('location_id',$request->village)->get();
        $data = [
            "iklim" => [
                "dasarian1" => $forecast->where("hazard_id",1)->where("dasarian",1)->pluck("value")->toArray(),
                "dasarian2" => $forecast->where("hazard_id",1)->where("dasarian",2)->pluck("value")->toArray(),
                "dasarian3" => $forecast->where("hazard_id",1)->where("dasarian",3)->pluck("value")->toArray(),
            ],
            "kekeringan" => [
                "dasarian1" => $forecast->where("hazard_id",5)->where("dasarian",1)->pluck("value")->toArray(),
                "dasarian2" => $forecast->where("hazard_id",5)->where("dasarian",2)->pluck("value")->toArray(),
                "dasarian3" => $forecast->where("hazard_id",5)->where("dasarian",3)->pluck("value")->toArray(),
            ],
            "banjir" => [
                "dasarian1" => $forecast->where("hazard_id",3)->where("dasarian",1)->pluck("value")->toArray(),
                "dasarian2" => $forecast->where("hazard_id",3)->where("dasarian",2)->pluck("value")->toArray(),
                "dasarian3" => $forecast->where("hazard_id",3)->where("dasarian",3)->pluck("value")->toArray(),
            ],
            "longsor" => [
                "dasarian1" => $forecast->where("hazard_id",4)->where("dasarian",1)->pluck("value")->toArray(),
                "dasarian2" => $forecast->where("hazard_id",4)->where("dasarian",2)->pluck("value")->toArray(),
                "dasarian3" => $forecast->where("hazard_id",4)->where("dasarian",3)->pluck("value")->toArray(),
            ],
            "location" => Location::where("id",$request->village)->first()
        ];

        return $data;
    }  

    public function getVillageKatam(Request $request)
    {        

        $forecast = Forecast::whereYear('date',$request->month . '-01')->where('location_id',$request->village)->where("hazard_id",2)->get();
        $data = [
            "katam" => $forecast->pluck("value")->toArray(),
            "location" => Location::where("id",$request->village)->first()
        ];

        return $data;
    } 


    public function getVillageHama(Request $request)
    {        

        $forecast = Forecast::whereYear('date',$request->month . '-01')->where('location_id',$request->village)->where("hazard_id",8)->get();
        $data = [
            "katam" => $forecast,
            "location" => Location::where("id",$request->village)->first()
        ];

        return $data;
    }         

    public function getVillageKatamPalawija(Request $request)
    {        

        $forecast = Forecast::whereYear('date',$request->month . '-01')->where('location_id',$request->village)->where("hazard_id",7)->get();
        $data = [
            "katam" => $forecast->pluck("value")->toArray(),
            "location" => Location::where("id",$request->village)->first()
        ];

        return $data;
    }        

    public function getWindmap(Request $request)
    {

        $date = $request->date;
        $data = array();
        $url = 'http://167.205.106.70/web/forecast/projects/loteng/wdir/' . $date . '.json';
        $json = @file_get_contents($url);
        if($json){
            $tmp = json_decode($json, true);            
            $tmp[0]['data'] = array_map('round',$tmp[0]['data']);
            $tmp[1]['data'] = array_map('round',$tmp[1]['data']);
            array_push($data, $tmp);       
        }

        return $data;
    }
}
