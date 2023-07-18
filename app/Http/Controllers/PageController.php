<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{

    public function index()
    {   
        return view('pages.index');
    }

    public function dashboard()
    {   
        return view('pages.dashboard');
    }

    public function prediksi()
    {   
        return view('pages.prediksi');
    }

    public function iklim()
    {   
        return view('pages.iklim');
    }

    public function hama()
    {   
        return view('pages.hama');
    }        

    public function katam()
    {   
        return view('pages.katam');
    }

    public function katamPalawija()
    {   
        return view('pages.katamPalawija');
    }    

    public function forecast(Request $request)
    {   

        $searchbar = Location::all();
      
        return view('pages.forecast');
    }

    public function cuaca(Request $request)
    {   

        $searchbar = Location::all();
      
        return view('pages.weather',compact('searchbar'));
    }    

}
