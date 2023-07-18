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
                <h1 class="text-gray-100 md:text-2xl uppercase font-bold"><span id="layer-name">-</span></h1>
            </div>
<!--             <div class="hidden py-1 px-1 text-right flex justify-end">
                <p class="text-gray-100 font-small my-auto">Update Terakhir: <span id="layer-update">{{ \Carbon\Carbon::now()->translatedformat("d F Y") }}</span></p>
            </div>  -->           
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 flex-grow">
            <div id="map" class="flex-grow col-span-12">
                    <div id="map-zoom">
                        <div>
                            <div id='in' class="bg-yellow-400 bg-opacity-50 mb-1 flex hover:bg-yellow-500 cursor-pointer" style="width: 25px;height: 25px;"><p class="cursor-pointer m-auto text-white font-bold">+</p></div>
                            <div id='out' class="bg-yellow-400 bg-opacity-50 flex hover:bg-yellow-500 cursor-pointer" style="width: 25px;height: 25px;"><p class="cursor-pointer m-auto text-white font-bold">-</p></div>                  
                        </div>
                    </div>
                    <div id="menu-layer" class="flex flex-col">
                        <input type="month" id="month" name="month" class="mb-1 p-2 bg-yellow-400 bg-opacity-90 hover:bg-opacity-100" onchange="getKatam()" style="max-width:130px;">
                        <select id="dasarian" class="mb-1 p-2 bg-yellow-400 bg-opacity-90 hover:bg-opacity-100" onchange="getKatam()" style="max-width:130px;">
                            <option class="text-black bg-white" value="1" selected>Tanggal 1-10</option>
                            <option class="text-black bg-white" value="2">Tanggal 11-21</option>
                            <option class="text-black bg-white" value="3">Tanggal 21-30</option>
                        </select>                        
                    </div>
                    <div id="menu-title" class="hidden md:block bg-green-700 bg-opacity-75 rounded-sm py-1 px-2 ml-none text-right" style="margin-left:0;">
                        <p id="map-title" class="text-gray-100 font-bold text-xl uppercase">-</p>
                        <p id="map-date" class="text-gray-100" style="text-shadow: 0 0 10px rgba(0, 0, 0,1);">-</p>
                    </div>
                    <div id="map-legend" class="my-auto text-right">
                        <div>
                            <div class="block md:flex">
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#80b1d3;">Bera</p>
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#8dd3c7;">Tanam</p>
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#ffffb3;">Pemupukan I</p>
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#bebada;">Pemupukan II</p>
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#fb8072;">Pestisida I</p>
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#fdb462;">Pestisida II</p>
                                <p class="text-black text-xs text-center font-bold py-1 px-2" style="background-color:#b3de69;">Panen</p>
                            </div>
                        </div>
                    </div>
            </div>

            <div id="summary-container" class="hidden md:flex flex-col flex-nowrap bg-black shadow-md bg-opacity-30 px-2 pb-2 rounded-sm">
                <input type="text" id="filter-table" onkeyup="filterTable()" placeholder="Cari Desa" title="Cari Desa" class="border mt-2 mb-1 px-2 py-1 bg-gray-500 text-white placeholder-white bg-opacity-60 rounded-sm">
                <div>
                    <div class="summary-table overflow-y-auto custom-scrollbar custom-scroll-vertical" style="height:50vh;overflow-y:auto;">    
                        <table id="table-1" class="table-auto text-xs w-full text-gray-100">
                            <thead class="bg-yellow-600 bg-opacity-50 text-gray-100 uppercase">
                                <tr>
                                    <th class="text-left p-1">Desa</th>
                                    <th class="whitespace-nowrap p-1">Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody id="table-1-content">
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </section>

    <div class="px-2 main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster"
        style="background: rgba(0,0,0,.7);display: none;">
        <div class="border border-teal-500 shadow-lg modal-container bg-white mx-auto rounded shadow-lg z-50 overflow-y-auto">
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

                <div class="w-full mx-auto my-4">
                    <p id="modal-title" class="uppercase font-bold my-2">Kalender Tanam Padi</p>
                    <div style="overflow-x:auto;">
                        
                        <table class="w-full table-auto border-collapse border">
                            <thead>
                                <tr>
                                    <th class="border px-2">Kegiatan</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Jan</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Feb</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Mar</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Apr</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Mei</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Jun</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Jul</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Agu</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Sep</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Okt</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Nov</th>
                                    <th colspan=3 class="border px-2 text-center" style="border-right:1px solid #000;">Des</th>
                                </tr>
                                <tr class="bg-gray-300">
                                    <th class="border text-xs px-2">Dasarian</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                    <th class="border text-xs px-2 text-center">1</th>
                                    <th class="border text-xs px-2 text-center">2</th>
                                    <th class="border text-xs px-2 text-center" style="border-right:1px solid #000;">3</th>
                                </tr>
                            </thead>
                            <tbody id="table-katam">
                            </tbody>
                        </table>
                    </div>
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
    
    setTimeout(() => { getKatam();  }, 250);
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

    map.invalidateSize();
    const tabs = document.querySelectorAll(".tabs");
    const tab = document.querySelectorAll(".tab");
    const panel = document.querySelectorAll(".tab-content");

    document.getElementById("menu-katam").classList.add("bg-yellow-500");
    document.getElementById("menu-katam").childNodes[1].childNodes[1].classList.remove("text-green");
    document.getElementById("menu-katam").childNodes[1].childNodes[1].classList.add("text-white");


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
            getVillageKatam(village);
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
        tab[i].classList.remove("bg-green");
      }

      for (let i = 0; i < panel.length; i++) {
        panel[i].classList.remove("active");
      }

      // activate new tabs and panel
      event.target.classList.add('active');
      let classString = event.target.getAttribute('data-target');
      document.getElementById('panels').getElementsByClassName(classString)[0].classList.add("active")
      event.target.classList.add("bg-green")
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
    }     
</script>
@endsection