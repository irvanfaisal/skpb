@extends('layouts.master')

@section('head')
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
  <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@3.0.3/dist/esri-leaflet.js"
    integrity="sha512-kuYkbOFCV/SsxrpmaCRMEFmqU08n6vc+TfAVlIKjR1BPVgt75pmtU9nbQll+4M9PN2tmZSAgD1kGUCKL88CscA=="
    crossorigin=""></script>

  <!-- Load Esri Leaflet Vector from CDN -->
  <script src="https://unpkg.com/esri-leaflet-vector@3.1.1/dist/esri-leaflet-vector.js"
    integrity="sha512-7rLAors9em7cR3/583gZSvu1mxwPBUjWjdFJ000pc4Wpu+fq84lXF1l4dbG4ShiPQ4pSBUTb4e9xaO6xtMZIlA=="
    crossorigin=""></script>

    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment-with-locales.js"></script>
    <link rel="stylesheet" href="{{ asset('css/leaflet-velocity.css') }}">
    <script type="text/javascript" src="{{ asset('js/leaflet-velocity.js') }}"></script>
    <script src="//d3js.org/d3.v4.min.js"></script>
    <script src="//npmcdn.com/geotiff@0.4.1/dist/geotiff.browserify.js"></script>
    <script src="https://unpkg.com/leaflet-canvaslayer-field@1.4.1/dist/leaflet.canvaslayer.field.js"></script>
    <script src="https://d3js.org/topojson.v2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>    
    @livewireStyles
@endsection
@section('content')


<main>
    @include('layouts.sidebar')
    <section id="dashboard-container" class="flex flex-col home-section p-2">
        <div id="dashboard-title" class="bg-green-800 grid grid-cols-1 justify-between mb-2">
            <div class="bg-green-gradient py-1 px-1">
                <h1 class="text-white md:text-2xl uppercase font-bold"><span id="layer-name">Prediksi Cuaca Kabupaten Lombok Tengah</span></h1>
            </div>
<!--             <div class="py-1 px-1 text-right flex justify-end">
                <p class="text-white font-small my-auto">Update Terakhir: <span id="layer-update">{{ \Carbon\Carbon::now()->translatedFormat("d F Y") }}</span></p>
            </div> -->            
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 flex-grow">

            <div id="map" class="h-full col-span-4 flex-grow z-30">
                <div id="menu-top-left" >
                    
                @livewire('weather-map')
                </div>
                <div id="menu-title" class="hidden md:block bg-green-gradient-invert py-1 px-2 ml-none text-right" style="margin-left:0;">
                    <p id="map-title" class="text-white font-bold text-xl uppercase" style="text-shadow: 0 0 10px rgba(0, 0, 0,1);">Prediksi Cuaca</p>
                    <p id="map-date" class="text-white" style="text-shadow: 0 0 10px rgba(0, 0, 0,1);">-</p>
                </div>
                <div id="menu-date">
                    <div style="z-index: 99999;">
                        <input id="date" type='date' class="bg-paleblue-light bg-opacity-75 p-1 m-1 rounded-sm" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onchange="getWeather();">
                        <select id="time" class="bg-paleblue-light bg-opacity-75 p-1 m-1 rounded-sm" onchange='getWeather();'>
                            @for($i = 0;$i<24;$i++)

                                <option value="{{ sprintf('%02d',$i); }}" class="text-center" {{ ($i == \Carbon\Carbon::now()->format('G') ? 'selected' : '') }}>{{ sprintf('%02d',$i); }}:00</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div id="menu-layer" style="z-index:999;">
                    <div id="weather-legend-container"></div>                    
                    <div class="inline-block bg-black bg-opacity-25 p-2 mr-2 my-auto rounded-sm shadow-xs shadow-paleblue">
                        <div class="md:flex">
                            <div class="mr-2 flex">
                                <input type="radio" name="menu-layer" class="my-auto" data-text="Hujan" checked value='rain' onclick="getWeather();">
                                <label class="ml-1 my-auto text-white text-xs">Hujan</label>
                            </div>
                            <div class="mr-2 flex">
                                <input type="radio" name="menu-layer" class="my-auto" data-text="Kecepatan Angin" value='wspd' onclick="getWeather();">
                                <label class="ml-1 my-auto text-white text-xs">Kecepatan Angin</label>
                            </div>
                            <div class="mr-2 flex">
                                <input type="radio" name="menu-layer" class="my-auto" data-text="Temperatur" value='temp' onclick="getWeather();">
                                <label class="ml-1 my-auto text-white text-xs">Temperatur</label>
                            </div>
                            <div class="mr-2 flex">
                                <input type="radio" name="menu-layer" class="my-auto" data-text="Kelembapan" value='rh' onclick="getWeather();">
                                <label class="ml-1 my-auto text-white text-xs">Kelembapan</label>
                            </div>
                        </div>
                    </div> 
                </div>                
                <div id="map-zoom">
                    <div>
                        <div id='in' class="bg-white bg-opacity-25 mb-1 flex hover:bg-red-dark cursor-pointer" style="width: 25px;height: 25px;"><p class="cursor-pointer m-auto text-white font-bold">+</p></div>
                        <div id='out' class="bg-white bg-opacity-25 flex hover:bg-red-dark cursor-pointer" style="width: 25px;height: 25px;"><p class="cursor-pointer m-auto text-white font-bold">-</p></div>                  
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')

@livewireScripts
@stack('scripts')
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
<script type="text/javascript">
    const btn = document.querySelector("button.mobile-menu-button");
    const menu = document.querySelector(".mobile-menu");

    // add event listeners
    btn.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });    
    moment.locale('ID');    
    var layerData;
    var velocityLayer;
    var storagePath = "{{ asset("") }}";
    initSidebar();
    initMap();
    
    setTimeout(() => { getWeather();  }, 250);

    setTimeout(() => { 
        document.getElementById("dashboard-container").style.marginTop = document.getElementById("navbar").offsetHeight + "px";
        document.getElementById("map").style.height = window.innerHeight - (document.getElementById("navbar").offsetHeight + document.getElementById("dashboard-title").offsetHeight + 25) + "px";
        map.invalidateSize();
    }, 500);    
    addMapLayer('menu-date','topleft');
    addMapLayer('menu-title','topright');
    addMapLayer('menu-layer','bottomleft');
    addMapLayer('map-zoom','bottomright');
    addMapLayer('menu-top-left','topleft');
    // addMapLayer('menu-bottom-left','bottomleft');

    document.getElementById("menu-weather").classList.add("bg-yellow-500");
    document.getElementById("menu-weather").childNodes[1].childNodes[1].classList.remove("text-green");
    document.getElementById("menu-weather").childNodes[1].childNodes[1].classList.add("text-white");


    var openmodal = document.querySelectorAll('.modal-daily-open')
    for (var i = 0; i < openmodal.length; i++) {
      openmodal[i].addEventListener('click', function(event){
        event.preventDefault()
        toggleModalDaily()
      })
    }
    
    const overlayDaily = document.querySelector('.modal-daily-overlay')
    overlayDaily.addEventListener('click', toggleModalDaily)
    
    var closemodal = document.querySelectorAll('.modal-daily-close')
    for (var i = 0; i < closemodal.length; i++) {
      closemodal[i].addEventListener('click', toggleModalDaily)
    }
    
    function toggleModalDaily () {
      const body = document.querySelector('body')
      const modal = document.querySelector('.modal-daily')
      modal.classList.toggle('opacity-0')
      modal.classList.toggle('pointer-events-none')
      body.classList.toggle('modal-daily-active')
    }

    function getWeatherTable(date){
        document.getElementById('daily-date').innerHTML = moment(date).format("DD MMMM YYYY");
        let table = document.getElementById('table-daily-content');
        let tr = table.getElementsByTagName('tr');
        for (var i = 0; i < tr.length; i++) {
            if(moment(date).isSame(moment(tr[i].cells[0].innerHTML), 'day')){
                tr[i].style.display = "";
            }else{
                tr[i].style.display = "none";
            }
        }        
    }

    document.querySelector(".right-button-daily").addEventListener("click", ()=>{
        document.querySelector(".grabbable-daily").scrollBy({ 
            left: 100,  
            behavior: 'smooth' 
        });
    });
    document.querySelector(".left-button-daily").addEventListener("click", ()=>{
        document.querySelector(".grabbable-daily").scrollBy({ 
            left: -100,  
            behavior: 'smooth' 
        });
    });


    // const grabbableHourly = document.querySelector('.grabbable-hourly');
    const grabbableDaily = document.querySelector('.grabbable-daily');
    let isDown = false;
    let startX;
    let scrollLeft;    
    
    document.onkeydown = function(evt) {
      evt = evt || window.event
      var isEscape = false
      if ("key" in evt) {
        isEscape = (evt.key === "Escape" || evt.key === "Esc")
      } else {
        isEscape = (evt.keyCode === 27)
      }
      if (isEscape && document.body.classList.contains('modal-daily-active')) {
        toggleModalDaily()
      }      
    };
    grabbableDaily.addEventListener('mousedown', (e) => {
        isDown = true;
        grabbableDaily.classList.add('active');
        startX = e.pageX - grabbableDaily.offsetLeft;
        scrollLeft = grabbableDaily.scrollLeft;
    });
    grabbableDaily.addEventListener('mouseleave', () => {
        isDown = false;
        grabbableDaily.classList.remove('active');
    });
    grabbableDaily.addEventListener('mouseup', () => {
        isDown = false;
        grabbableDaily.classList.remove('active');
    });
    grabbableDaily.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - grabbableDaily.offsetLeft;
        const walk = (x - startX); //scroll-fast
        grabbableDaily.scrollLeft = scrollLeft - walk;
    });
</script>
@endsection