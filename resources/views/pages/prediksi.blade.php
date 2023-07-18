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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment-with-locales.js"></script>
@endsection
@section('content')


<main>
    @include('layouts.sidebar')
    <section id="dashboard-container" class="flex flex-col home-section p-2">
        <div id="dashboard-title" class="bg-green-800 grid grid-cols-1 justify-between mb-2">
            <div class="bg-green-gradient py-1 px-1">
                <h1 class="text-white md:text-2xl uppercase font-bold"><span id="layer-name">Kerentanan Bencana Kabupaten Lombok Tengah</span></h1>
            </div>
<!--             <div class="hidden py-1 px-1 text-right flex justify-end">
                <p class="text-white font-small my-auto">Update Terakhir: <span id="layer-update">{{Carbon\Carbon::now()->translatedFormat("d F Y")}}</span></p>
            </div>             -->
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 flex-grow">
            <div id="map" class="h-full col-span-4 flex-grow z-30">
                    <div id="map-zoom">
                        <div>
                            <div id='in' class="bg-yellow-400 bg-opacity-50 mb-1 flex hover:bg-yellow-500 cursor-pointer" style="width: 25px;height: 25px;"><p class="cursor-pointer m-auto text-white font-bold">+</p></div>
                            <div id='out' class="bg-yellow-400 bg-opacity-50 flex hover:bg-yellow-500 cursor-pointer" style="width: 25px;height: 25px;"><p class="cursor-pointer m-auto text-white font-bold">-</p></div>                  
                        </div>
                    </div>
                    <div id="menu-layer" class="flex flex-col gap-2">
                        <div>
                            <select id="layer" class="p-2 shadow-sm bg-yellow-400 rounded-sm bg-opacity-75 border border-gray-900 border-opacity-10 hover:bg-opacity-100" onchange="getForecast()" style="max-width:130px;">
                                <option class="bg-white text-black" selected value="banjir">Kerentanan Banjir</option>
                                <option class="bg-white text-black" value="kekeringan">Kerentanan Kekeringan</option>
                                <option class="bg-white text-black" value="longsor">Kerentanan Longsor</option>
                            </select>
                        </div>
                        <div>
                            <input type="month" id="month" name="month" class="px-2 py-1 shadow-sm bg-yellow-400 rounded-sm bg-opacity-75 border border-gray-900 border-opacity-10 hover:bg-opacity-100" onchange="getForecast()" style="max-width:130px;">
                        </div>
                        <div>
                            <select id="dasarian" class="p-2 shadow-sm bg-yellow-400 rounded-sm bg-opacity-75 border border-gray-900 border-opacity-10 hover:bg-opacity-100" onchange="getForecast()" style="max-width:130px;">
                                <option class="text-black bg-white" value="1" selected>Tanggal 1-10</option>
                                <option class="text-black bg-white" value="2">Tanggal 11-20</option>
                                <option class="text-black bg-white" value="3">Tanggal 21-30</option>
                            </select>
                        </div>
                    </div>
                    <div id="menu-title" class="hidden md:block bg-green-700 bg-opacity-75 shadow-md rounded-sm py-1 px-2 ml-none text-right" style="margin-left:0;">
                        <p id="map-title" class="text-white font-bold text-xl uppercase" style="text-shadow: 0 0 10px rgba(0, 0, 0,1);">-</p>
                        <p id="map-date" class="text-white" style="text-shadow: 0 0 10px rgba(0, 0, 0,1);">-</p>
                    </div>
                    <div id="map-legend" class="text-white my-auto text-right">
<!--                         <div id="legend-vulnerability">
                            <p class="text-xs text-left">Kerentanan: </p>
                            <div class="flex">
                                <p class="text-white text-xs text-center py-1 px-2" style="background-color:#1a9641;">Sangat Rendah</p>
                                <p class="text-black text-xs text-center py-1 px-2" style="background-color:#a6d96a;">Rendah</p>
                                <p class="text-black text-xs text-center py-1 px-2" style="background-color:#ffffbf;">Sedang</p>
                                <p class="text-black text-xs text-center py-1 px-2" style="background-color:#fdae61;">Tinggi</p>
                                <p class="text-white text-xs text-center py-1 px-2" style="background-color:#d7191c;">Sangat Tinggi</p>
                            </div>
                        </div> -->
                        <div id="legend-climate">
                            <p id="legend-text" class="text-xs text-left"></p>
                            <div id="legend-gradient"></div>
                        </div>
                    </div>
            </div>

            <div id="summary-container" class="hidden md:flex flex-col flex-nowrap bg-gray-900 shadow-md border border-opacity-20 bg-opacity-50 px-2 pb-2 rounded">
                <div id="summary-tabs" class="mt-2">
                    <input type="text" id="filter-table" onkeyup="filterTable()" placeholder="Cari Desa" title="Cari Desa/Kecamatan" class="w-full border my-1 px-2 py-1 bg-gray-500 text-white placeholder-white bg-opacity-60 rounded-sm">
                    <nav class="tabs flex flex-col sm:flex-row">
                        <button data-target="panel-2" data-tab="tab-flood" class="tab active text-gray-100 bg-green-600 whitespace-nowrap text-xs py-1 px-2 block hover:bg-green-600 hover:bg-opacity-50 focus:outline-none flex-grow border-b border-r">
                            Banjir
                        </button>
                        <button data-target="panel-3" data-tab="tab-drought" class="tab text-gray-100 whitespace-nowrap text-xs py-1 px-2 block hover:bg-green-600 hover:bg-opacity-50 focus:outline-none flex-grow border-b border-r">
                            Kekeringan
                        </button>
                        <button data-target="panel-4" data-tab="tab-longsor" class="tab text-gray-100 whitespace-nowrap text-xs py-1 px-2 block hover:bg-green-600 hover:bg-opacity-50 focus:outline-none flex-grow border-b border-r">
                            Longsor
                        </button>
                    </nav>
                </div>
                <div id="panels" class="flex-grow flex-nowrap">
                    <div class="panel-2 active tab-content h-full">
                        <div class="text-white py-2 bg-opacity-20">
                            <div style="height:50vh;overflow-y:auto;" class="summary-table overflow-y-auto custom-scrollbar pr-1 custom-scroll-vertical">                            
                                <table id="table-2" class="table-auto text-xs w-full">
                                    <thead class="bg-green-800 uppercase text-white">
                                        <tr>
                                            <th class="text-left p-1">Desa</th>
                                            <th class="whitespace-nowrap p-1">Kerentanan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-2-content">                                      
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                    <div class="panel-3 tab-content h-full">
                        <div class="text-white py-2 bg-opacity-20">
                            <div style="height:50vh;overflow-y:auto;" class="summary-table overflow-y-auto custom-scrollbar pr-1 custom-scroll-vertical">                            
                                <table id="table-3" class="table-auto text-xs w-full">
                                    <thead class="bg-green-800 uppercase text-white">
                                        <tr>
                                            <th class="text-left p-1">Desa</th>
                                            <th class="whitespace-nowrap p-1">Kerentanan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-3-content">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel-4 tab-content h-full">
                        <div class="text-white py-2 bg-opacity-20">
                            <div style="height:50vh;overflow-y:auto;" class="summary-table overflow-y-auto custom-scrollbar pr-1 custom-scroll-vertical">                            
                                <table id="table-4" class="table-auto text-xs w-full">
                                    <thead class="bg-green-800 uppercase text-white">
                                        <tr>
                                            <th class="text-left p-1">Desa</th>
                                            <th class="whitespace-nowrap p-1">Kerentanan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-4-content">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </section>

    <div class="px-2 main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);display: none;">
        <div class="border mx-2 border-teal-500 shadow-lg modal-container bg-white mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="h-96 w-max custom-scroll-vertical custom-scroll-vertical-red" style="overflow-y:auto;">
                    <div id="chart-1" class="hidden" style="height:250px;"></div>
                    <div id="chart-2" style="height:250px;"></div>
                    <div id="chart-3" style="height:250px;"></div>
                    <div id="chart-4" style="height:250px;"></div>
                </div>
                <div class="flex justify-end mt-1">
                    
                    <button class="modal-close bg-red-600 text-white py-1 px-4 rounded-sm">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('js')

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
<script type="text/javascript" src="{{ asset('js/L.KML.js') }}"></script>
<script type="text/javascript">

    const btn = document.querySelector("button.mobile-menu-button");
    const menu = document.querySelector(".mobile-menu");

    // add event listeners
    btn.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });
  
    moment.locale('ID'); 
    document.getElementById("month").defaultValue = moment().format("YYYY-MM");    
    initSidebar();
    initMap();
    
    setTimeout(() => { getForecast();  }, 250)

    setTimeout(() => { 
        document.getElementById("dashboard-container").style.marginTop = document.getElementById("navbar").offsetHeight + "px";
        document.getElementById("map").style.height = window.innerHeight - (document.getElementById("navbar").offsetHeight + document.getElementById("dashboard-title").offsetHeight + 25) + "px";
        map.invalidateSize();
    }, 500);
    addMapLayer('menu-title','topright');
    addMapLayer('menu-layer','topleft');
    addMapLayer('map-legend','bottomleft');
    addMapLayer('map-zoom','bottomleft');
    addMapLayer('summary-container','topright');
    const tabs = document.querySelectorAll(".tabs");
    const tab = document.querySelectorAll(".tab");
    const panel = document.querySelectorAll(".tab-content");
    map.invalidateSize();

    document.getElementById("menu-prediksi").classList.add("bg-yellow-500");
    document.getElementById("menu-prediksi").childNodes[1].childNodes[1].classList.remove("text-green");
    document.getElementById("menu-prediksi").childNodes[1].childNodes[1].classList.add("text-white");


        const modal = document.querySelector('.main-modal');
        const closeButton = document.querySelectorAll('.modal-close');

        const modalClose = () => {
            modal.classList.remove('fadeIn');
            modal.classList.add('fadeOut');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 500);
        }

        const openModal = (village) => {
            getVillageForecast(village);
            modal.classList.remove('fadeOut');
            modal.classList.add('fadeIn');
            modal.style.display = 'flex';
        }

        for (let i = 0; i < closeButton.length; i++) {
            const elements = closeButton[i];
            elements.onclick = (e) => modalClose();
            modal.style.display = 'none';
            window.onclick = function (event) {
                if (event.target == modal) modalClose();
            }
        }

    function onTabClick(event) {

      // deactivate existing active tabs and panel

      for (let i = 0; i < tab.length; i++) {
        tab[i].classList.remove("active");
        tab[i].classList.remove("bg-green-600");
          // tab[i].classList.add("text-gray-900");
          // tab[i].classList.remove("text-gray-100");
      }

      for (let i = 0; i < panel.length; i++) {
        panel[i].classList.remove("active");

      }

      // activate new tabs and panel
      event.target.classList.add('active');
      let classString = event.target.getAttribute('data-target');
      document.getElementById('panels').getElementsByClassName(classString)[0].classList.add("active")
      event.target.classList.add("bg-green-600")
      // event.target.classList.remove("text-gray-900")
      // event.target.classList.add("text-gray-100")
    }

    for (let i = 0; i < tab.length; i++) {
      tab[i].addEventListener('click', onTabClick, false);
    }
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("filter-table");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-1");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    } 
                }
            }     
        }
        table = document.getElementById("table-2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    } 
                }
            }     
        }
        table = document.getElementById("table-3");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    } 
                }
            }     
        }
        table = document.getElementById("table-4");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    } 
                }
            }     
        }                        
    }    
</script>
@endsection