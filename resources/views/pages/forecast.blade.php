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

    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <!-- Load Esri Leaflet Vector from CDN -->
  <script src="https://unpkg.com/esri-leaflet-vector@3.1.1/dist/esri-leaflet-vector.js"
    integrity="sha512-7rLAors9em7cR3/583gZSvu1mxwPBUjWjdFJ000pc4Wpu+fq84lXF1l4dbG4ShiPQ4pSBUTb4e9xaO6xtMZIlA=="
    crossorigin=""></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment-with-locales.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @livewireStyles
@endsection
@section('content')

@include('layouts.header')
<main class="py-10 pt-24">
    <section class="md:w-5/6 mx-auto">
    @livewire('filter-weather')
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


    var scrollpos = window.scrollY;
    var header = document.getElementById("navbar");

    $(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top - 90
    }, 500);
});
    document.getElementById("navbar").classList.add("bg-green-800");
    document.getElementById("navbar").classList.add("bg-opacity-100");
    document.getElementById("navbar").classList.remove("md:bg-transparent");
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

    function changeHazard(){

        content = "";
        content += "<tr><td class='py-1 px-2 border text-xs'>Mulai Tanam</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 0 ? "<td class='p-2 text-center text-white border' style='background:#8dd3c7;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 1</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 1 ? "<td class='p-2 text-center text-white border' style='background:#ffffb3;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 2</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 2 ? "<td class='p-2 text-center text-white border' style='background:#bebada;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 1</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 3 ? "<td class='p-2 text-center text-white border' style='background:#fb8072;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 2</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 4 ? "<td class='p-2 text-center text-white border' style='background:#fdb462;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Panen</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 5 ? "<td class='p-2 text-center text-white border' style='background:#b3de69;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        document.getElementById("table-katam").innerHTML = content;

        content = "";
        content += "<tr><td class='py-1 px-2 border text-xs'>Mulai Tanam</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 0 ? "<td class='p-2 text-center text-white border' style='background:#8dd3c7;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 1</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 1 ? "<td class='p-2 text-center text-white border' style='background:#ffffb3;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 2</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 2 ? "<td class='p-2 text-center text-white border' style='background:#bebada;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 3 ? "<td class='p-2 text-center text-white border' style='background:#fb8072;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Panen</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 4 ? "<td class='p-2 text-center text-white border' style='background:#b3de69;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        document.getElementById("table-katam-palawija").innerHTML = content;        
        Highcharts.chart('chart-climate', {
            chart: {
                zoomType: 'xy',
            },
            title: {
                text: ''
            },
            exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbolStroke: 'rgba(255,255,255,.75)',
                        theme: {
                            fill: 'transparent',
                            stroke: 'transparent',
                            states:{
                                hover:{
                                    fill: 'rgba(0,0,0,.25)',
                                },
                                select:{
                                    fill: 'rgba(0,0,0,.25)',
                                },
                            }
                        }
                    }
                }
            },
            xAxis: [{
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true,
            }],
            credits:false,
            yAxis: { // Primary yAxis
                labels: {
                    format: '{value} mm',
                    style: {
                        fontWeight:'bold',
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                title: {
                    text: 'Curah Hujan',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                }
            },
            tooltip: {
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        radius: 3
                    }
                }
            },            
            legend: {
                layout: 'horizontal',
                margin:5,
                align: 'center',
                verticalAlign: 'top',
                floating: false,
            },
            series: [{
                name: 'Tanggal 1-10',
                type: 'column',
                data: climate.filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: Highcharts.getOptions().colors[7],
                tooltip: {
                    valueSuffix: ' mm'
                }
            },{
                name: 'Tanggal 11-20',
                type: 'column',
                data: climate.filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: Highcharts.getOptions().colors[3],
                tooltip: {
                    valueSuffix: ' mm'
                }
            },{
                name: 'Tanggal 21-30',
                type: 'column',
                data: climate.filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: Highcharts.getOptions().colors[0],
                tooltip: {
                    valueSuffix: ' mm'
                }
            }]
        });

        Highcharts.chart('chart-disaster-1', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "",
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true
            },
            yAxis: {

                labels:{
                    enabled:false
                },
                max:5,
                plotBands: [{ // mark the weekend
                    color: "rgba(158, 203, 70,0.8)",
                    from: 0,
                    to: 1
                },{ // mark the weekend
                    color: "rgba(207, 219, 65,0.8)",
                    from: 1,
                    to: 2
                },{ // mark the weekend
                    color: "rgba(241, 174, 55,0.8)",
                    from: 2,
                    to: 3
                },{ // mark the weekend
                    color: "rgba(225, 107, 51,0.8)",
                    from: 3,
                    to: 4
                },{ // mark the weekend
                    color: "rgba(211, 47, 47,0.8)",
                    from: 4,
                    to: 10
                }], 
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Aman',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 1,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Rendah',
                        align: 'left',
                        x: -90,
                        y:5,
                    }
                },{
                    value: 2,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Rendah',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 3,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sedang',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 4,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Tinggi',
                        align: 'left',
                        x: -45,
                        y:5,
                    }
                },{
                    value: 5,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Tinggi',
                        align: 'left',
                        x: -85,
                        y:5,
                    }
                }],                
                tickInterval:5,
                title: {
                    text: ''
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                footerFormat: '</table>',
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + '<br/><span style="color:' + point.series.color + '">&#9646;</span>' + point.series.name + ': <b><span style="padding:0 5px;background:' + (point.y <= 0 ? "#4caf50" : (point.y <= 1 ? "#9ecb46" : (point.y <= 2 ? "#cfdb41" : (point.y <= 3 ? "#f1ae37" : (point.y <= 4 ? "#e16b33" : ("#d32f2f")))))) + ';">' +
                            (point.y <= 0 ? "Aman" : (point.y <= 1 ? "Sangat Rendah" : (point.y <= 2 ? "Rendah" : (point.y <= 3 ? "Sedang" : (point.y <= 4 ? "Tinggi" : ("Sangat Tinggi")))))) + "</b>";
                    }, '<b>' + this.x + '</span></b>');
                },             
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.25,
                    borderWidth: 0.75,
                    borderColor: '#111'
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: hazard.filter(o => o.hazard_id == 3).filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: hazard.filter(o => o.hazard_id == 3).filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: hazard.filter(o => o.hazard_id == 3).filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(200,200,200,1)"
            }]
        });


        Highcharts.chart('chart-disaster-2', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "",
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true
            },
            yAxis: {

                labels:{
                    enabled:false
                },
                max:5,
                plotBands: [{ // mark the weekend
                    color: "rgba(158, 203, 70,0.8)",
                    from: 0,
                    to: 1
                },{ // mark the weekend
                    color: "rgba(207, 219, 65,0.8)",
                    from: 1,
                    to: 2
                },{ // mark the weekend
                    color: "rgba(241, 174, 55,0.8)",
                    from: 2,
                    to: 3
                },{ // mark the weekend
                    color: "rgba(225, 107, 51,0.8)",
                    from: 3,
                    to: 4
                },{ // mark the weekend
                    color: "rgba(211, 47, 47,0.8)",
                    from: 4,
                    to: 10
                }], 
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Aman',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 1,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Rendah',
                        align: 'left',
                        x: -90,
                        y:5,
                    }
                },{
                    value: 2,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Rendah',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 3,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sedang',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 4,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Tinggi',
                        align: 'left',
                        x: -45,
                        y:5,
                    }
                },{
                    value: 5,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Tinggi',
                        align: 'left',
                        x: -85,
                        y:5,
                    }
                }],                
                tickInterval:5,
                title: {
                    text: ''
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                footerFormat: '</table>',
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + '<br/><span style="color:' + point.series.color + '">&#9646;</span>' + point.series.name + ': <b><span style="padding:0 5px;background:' + (point.y <= 0 ? "#4caf50" : (point.y <= 1 ? "#9ecb46" : (point.y <= 2 ? "#cfdb41" : (point.y <= 3 ? "#f1ae37" : (point.y <= 4 ? "#e16b33" : ("#d32f2f")))))) + ';">' +
                            (point.y <= 0 ? "Aman" : (point.y <= 1 ? "Sangat Rendah" : (point.y <= 2 ? "Rendah" : (point.y <= 3 ? "Sedang" : (point.y <= 4 ? "Tinggi" : ("Sangat Tinggi")))))) + "</b>";
                    }, '<b>' + this.x + '</span></b>');
                },             
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.25,
                    borderWidth: 0.75,
                    borderColor: '#111'
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: hazard.filter(o => o.hazard_id == 5).filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: hazard.filter(o => o.hazard_id == 5).filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: hazard.filter(o => o.hazard_id == 5).filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(200,200,200,1)"
            }]
        });

        Highcharts.chart('chart-disaster-3', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "",
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true
            },
            yAxis: {

                labels:{
                    enabled:false
                },
                max:5,
                plotBands: [{ // mark the weekend
                    color: "rgba(158, 203, 70,0.8)",
                    from: 0,
                    to: 1
                },{ // mark the weekend
                    color: "rgba(207, 219, 65,0.8)",
                    from: 1,
                    to: 2
                },{ // mark the weekend
                    color: "rgba(241, 174, 55,0.8)",
                    from: 2,
                    to: 3
                },{ // mark the weekend
                    color: "rgba(225, 107, 51,0.8)",
                    from: 3,
                    to: 4
                },{ // mark the weekend
                    color: "rgba(211, 47, 47,0.8)",
                    from: 4,
                    to: 10
                }], 
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Aman',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 1,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Rendah',
                        align: 'left',
                        x: -90,
                        y:5,
                    }
                },{
                    value: 2,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Rendah',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 3,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sedang',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 4,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Tinggi',
                        align: 'left',
                        x: -45,
                        y:5,
                    }
                },{
                    value: 5,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Tinggi',
                        align: 'left',
                        x: -85,
                        y:5,
                    }
                }],                
                tickInterval:5,
                title: {
                    text: ''
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                footerFormat: '</table>',
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + '<br/><span style="color:' + point.series.color + '">&#9646;</span>' + point.series.name + ': <b><span style="padding:0 5px;background:' + (point.y <= 0 ? "#4caf50" : (point.y <= 1 ? "#9ecb46" : (point.y <= 2 ? "#cfdb41" : (point.y <= 3 ? "#f1ae37" : (point.y <= 4 ? "#e16b33" : ("#d32f2f")))))) + ';">' +
                            (point.y <= 0 ? "Aman" : (point.y <= 1 ? "Sangat Rendah" : (point.y <= 2 ? "Rendah" : (point.y <= 3 ? "Sedang" : (point.y <= 4 ? "Tinggi" : ("Sangat Tinggi")))))) + "</b>";
                    }, '<b>' + this.x + '</span></b>');
                },             
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.25,
                    borderWidth: 0.75,
                    borderColor: '#111'
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: hazard.filter(o => o.hazard_id == 4).filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: hazard.filter(o => o.hazard_id == 4).filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: hazard.filter(o => o.hazard_id == 4).filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(200,200,200,1)"
            }]
        });

    }
           
    window.addEventListener('reload-chart', event => {

        climate = JSON.parse(JSON.stringify(event.detail.longterm)).filter(o => o.hazard_id == 1);
        hazard = JSON.parse(JSON.stringify(event.detail.longterm));

        katam = JSON.parse(JSON.stringify(event.detail.longterm)).filter(o => o.hazard_id == 2);
        katamPalawija = JSON.parse(JSON.stringify(event.detail.longterm)).filter(o => o.hazard_id == 7);
        content = "";
        content += "<tr><td class='py-1 px-2 border text-xs'>Mulai Tanam</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 0 ? "<td class='p-2 text-center text-white border' style='background:#8dd3c7;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 1</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 1 ? "<td class='p-2 text-center text-white border' style='background:#ffffb3;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 2</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 2 ? "<td class='p-2 text-center text-white border' style='background:#bebada;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 1</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 3 ? "<td class='p-2 text-center text-white border' style='background:#fb8072;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 2</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 4 ? "<td class='p-2 text-center text-white border' style='background:#fdb462;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Panen</td>";
        for (var i = 0; i < 36; i++) {
            content += (katam.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 5 ? "<td class='p-2 text-center text-white border' style='background:#b3de69;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        document.getElementById("table-katam").innerHTML = content;

        content = "";
        content += "<tr><td class='py-1 px-2 border text-xs'>Mulai Tanam</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 0 ? "<td class='p-2 text-center text-white border' style='background:#8dd3c7;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 1</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 1 ? "<td class='p-2 text-center text-white border' style='background:#ffffb3;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 2</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 2 ? "<td class='p-2 text-center text-white border' style='background:#bebada;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 3 ? "<td class='p-2 text-center text-white border' style='background:#fb8072;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        content += "<tr><td class='py-1 px-2 border text-xs'>Panen</td>";
        for (var i = 0; i < 36; i++) {
            content += (katamPalawija.filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value)[i] == 4 ? "<td class='p-2 text-center text-white border' style='background:#b3de69;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
        }
        content += "</tr>";
        document.getElementById("table-katam-palawija").innerHTML = content;

		Highcharts.theme = {
          "colors": ['#d53e4f','#f46d43','#fdae61','#fee08b','#e6f598','#abdda4','#66c2a5','#3288bd'],
          "chart": {
            "style": {
              "fontFamily": "Encode Sans",
              // "color": "#fff"
            }
          },
          "xAxis": {
            "gridLineWidth": 1,
            "gridLineColor": "rgba(0,0,0,.075)",
            "lineColor": "rgba(0,0,0,.075)",
            "minorGridLineColor": "rgba(0,0,0,.075)",
            "tickColor": "rgba(0,0,0,.075)",
            "tickWidth": 1
          },
          "yAxis": {
            "gridLineColor": "rgba(0,0,0,.075)",
            "lineColor": "rgba(0,0,0,.075)",
            "minorGridLineColor": "rgba(0,0,0,.075)",
            "tickColor": "rgba(0,0,0,.075)",
            "tickWidth": 1
          },
          "legendBackgroundColor": "rgba(0, 0, 0, 0.5)",
          "background2": "#505053",
          "dataLabelsColor": "#B0B0B3",
          "textColor": "#C0C0C0",
          "contrastTextColor": "#F0F0F3",
          "maskColor": "rgba(255,255,255,0.3)"
        }
        Highcharts.setOptions(Highcharts.theme);

        Highcharts.chart('chart-climate', {
            chart: {
                zoomType: 'xy',
            },
            title: {
                text: ''
            },
            exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbolStroke: 'rgba(255,255,255,.75)',
                        theme: {
                            fill: 'transparent',
                            stroke: 'transparent',
                            states:{
                                hover:{
                                    fill: 'rgba(0,0,0,.25)',
                                },
                                select:{
                                    fill: 'rgba(0,0,0,.25)',
                                },
                            }
                        }
                    }
                }
            },
            xAxis: [{
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true,
            }],
            credits:false,
            yAxis: { // Primary yAxis
                labels: {
                    format: '{value} mm',
                    style: {
                        fontWeight:'bold',
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                title: {
                    text: 'Curah Hujan',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                }
            },
            tooltip: {
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        radius: 3
                    }
                }
            },            
            legend: {
                layout: 'horizontal',
                margin:5,
                align: 'center',
                verticalAlign: 'bottom',
                floating: false,
            },
            series: [{
                name: 'Tanggal 1-10',
                type: 'column',
                data: climate.filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: Highcharts.getOptions().colors[7],
                tooltip: {
                    valueSuffix: ' mm'
                }
            },{
                name: 'Tanggal 11-20',
                type: 'column',
                data: climate.filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: Highcharts.getOptions().colors[3],
                tooltip: {
                    valueSuffix: ' mm'
                }
            },{
                name: 'Tanggal 21-30',
                type: 'column',
                data: climate.filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: Highcharts.getOptions().colors[0],
                tooltip: {
                    valueSuffix: ' mm'
                }
            }]
        });


        Highcharts.chart('chart-disaster-1', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "",
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true
            },
            yAxis: {

                labels:{
                    enabled:false
                },
                max:5,
                plotBands: [{ // mark the weekend
                    color: "rgba(158, 203, 70,0.8)",
                    from: 0,
                    to: 1
                },{ // mark the weekend
                    color: "rgba(207, 219, 65,0.8)",
                    from: 1,
                    to: 2
                },{ // mark the weekend
                    color: "rgba(241, 174, 55,0.8)",
                    from: 2,
                    to: 3
                },{ // mark the weekend
                    color: "rgba(225, 107, 51,0.8)",
                    from: 3,
                    to: 4
                },{ // mark the weekend
                    color: "rgba(211, 47, 47,0.8)",
                    from: 4,
                    to: 10
                }], 
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Aman',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 1,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Rendah',
                        align: 'left',
                        x: -90,
                        y:5,
                    }
                },{
                    value: 2,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Rendah',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 3,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sedang',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 4,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Tinggi',
                        align: 'left',
                        x: -45,
                        y:5,
                    }
                },{
                    value: 5,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Tinggi',
                        align: 'left',
                        x: -85,
                        y:5,
                    }
                }],                
                tickInterval:5,
                title: {
                    text: ''
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                footerFormat: '</table>',
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + '<br/><span style="color:' + point.series.color + '">&#9646;</span>' + point.series.name + ': <b><span style="padding:0 5px;background:' + (point.y <= 0 ? "#4caf50" : (point.y <= 1 ? "#9ecb46" : (point.y <= 2 ? "#cfdb41" : (point.y <= 3 ? "#f1ae37" : (point.y <= 4 ? "#e16b33" : ("#d32f2f")))))) + ';">' +
                            (point.y <= 0 ? "Aman" : (point.y <= 1 ? "Sangat Rendah" : (point.y <= 2 ? "Rendah" : (point.y <= 3 ? "Sedang" : (point.y <= 4 ? "Tinggi" : ("Sangat Tinggi")))))) + "</b>";
                    }, '<b>' + this.x + '</span></b>');
                },             
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.25,
                    borderWidth: 0.75,
                    borderColor: '#111'
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: hazard.filter(o => o.hazard_id == 3).filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: hazard.filter(o => o.hazard_id == 3).filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: hazard.filter(o => o.hazard_id == 3).filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(200,200,200,1)"
            }]
        });


        Highcharts.chart('chart-disaster-2', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "",
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true
            },
            yAxis: {

                labels:{
                    enabled:true
                },
                max:5,
                plotBands: [{ // mark the weekend
                    color: "rgba(158, 203, 70,0.8)",
                    from: 0,
                    to: 1
                },{ // mark the weekend
                    color: "rgba(207, 219, 65,0.8)",
                    from: 1,
                    to: 2
                },{ // mark the weekend
                    color: "rgba(241, 174, 55,0.8)",
                    from: 2,
                    to: 3
                },{ // mark the weekend
                    color: "rgba(225, 107, 51,0.8)",
                    from: 3,
                    to: 4
                },{ // mark the weekend
                    color: "rgba(211, 47, 47,0.8)",
                    from: 4,
                    to: 10
                }], 
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Aman',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 1,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Rendah',
                        align: 'left',
                        x: -90,
                        y:5,
                    }
                },{
                    value: 2,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Rendah',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 3,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sedang',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 4,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Tinggi',
                        align: 'left',
                        x: -45,
                        y:5,
                    }
                },{
                    value: 5,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Tinggi',
                        align: 'left',
                        x: -85,
                        y:5,
                    }
                }],                
                tickInterval:5,
                title: {
                    text: ''
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                footerFormat: '</table>',
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + '<br/><span style="color:' + point.series.color + '">&#9646;</span>' + point.series.name + ': <b><span style="padding:0 5px;background:' + (point.y <= 0 ? "#4caf50" : (point.y <= 1 ? "#9ecb46" : (point.y <= 2 ? "#cfdb41" : (point.y <= 3 ? "#f1ae37" : (point.y <= 4 ? "#e16b33" : ("#d32f2f")))))) + ';">' +
                            (point.y <= 0 ? "Aman" : (point.y <= 1 ? "Sangat Rendah" : (point.y <= 2 ? "Rendah" : (point.y <= 3 ? "Sedang" : (point.y <= 4 ? "Tinggi" : ("Sangat Tinggi")))))) + "</b>";
                    }, '<b>' + this.x + '</span></b>');
                },             
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.25,
                    borderWidth: 0.75,
                    borderColor: '#111'
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: hazard.filter(o => o.hazard_id == 5).filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: hazard.filter(o => o.hazard_id == 5).filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: hazard.filter(o => o.hazard_id == 5).filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(200,200,200,1)"
            }]
        });

        Highcharts.chart('chart-disaster-3', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "",
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
                crosshair: true
            },
            yAxis: {

                labels:{
                    enabled:false
                },
                max:5,
                plotBands: [{ // mark the weekend
                    color: "rgba(158, 203, 70,0.8)",
                    from: 0,
                    to: 1
                },{ // mark the weekend
                    color: "rgba(207, 219, 65,0.8)",
                    from: 1,
                    to: 2
                },{ // mark the weekend
                    color: "rgba(241, 174, 55,0.8)",
                    from: 2,
                    to: 3
                },{ // mark the weekend
                    color: "rgba(225, 107, 51,0.8)",
                    from: 3,
                    to: 4
                },{ // mark the weekend
                    color: "rgba(211, 47, 47,0.8)",
                    from: 4,
                    to: 10
                }], 
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Aman',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 1,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Rendah',
                        align: 'left',
                        x: -90,
                        y:5,
                    }
                },{
                    value: 2,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Rendah',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 3,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sedang',
                        align: 'left',
                        x: -50,
                        y:5,
                    }
                },{
                    value: 4,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Tinggi',
                        align: 'left',
                        x: -45,
                        y:5,
                    }
                },{
                    value: 5,
                    width: 1,
                    color:"rgba(0,0,0,.075)",
                    label: {
                        text: 'Sangat Tinggi',
                        align: 'left',
                        x: -85,
                        y:5,
                    }
                }],                
                tickInterval:5,
                title: {
                    text: ''
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                footerFormat: '</table>',
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + '<br/><span style="color:' + point.series.color + '">&#9646;</span>' + point.series.name + ': <b><span style="padding:0 5px;background:' + (point.y <= 0 ? "#4caf50" : (point.y <= 1 ? "#9ecb46" : (point.y <= 2 ? "#cfdb41" : (point.y <= 3 ? "#f1ae37" : (point.y <= 4 ? "#e16b33" : ("#d32f2f")))))) + ';">' +
                            (point.y <= 0 ? "Aman" : (point.y <= 1 ? "Sangat Rendah" : (point.y <= 2 ? "Rendah" : (point.y <= 3 ? "Sedang" : (point.y <= 4 ? "Tinggi" : ("Sangat Tinggi")))))) + "</b>";
                    }, '<b>' + this.x + '</span></b>');
                },             
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.25,
                    borderWidth: 0.75,
                    borderColor: '#111'
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: hazard.filter(o => o.hazard_id == 4).filter(o => o.dasarian == 1).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: hazard.filter(o => o.hazard_id == 4).filter(o => o.dasarian == 2).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: hazard.filter(o => o.hazard_id == 4).filter(o => o.dasarian == 3).filter(o => o.date.slice(0,4) == document.getElementById('filter-year').value).map(a => a.value),
                color: "rgba(200,200,200,1)"
            }]
        });

        dataHourly = JSON.parse(JSON.stringify(event.detail.data));
        dataLocation = JSON.parse(JSON.stringify(event.detail.location));
        Highcharts.chart('weather-chart', {
            chart: {
                zoomType: 'xy',
            },
            title: {
                text: 'Prediksi Cuaca ' + dataLocation.village.replace(/_/g," ") + ' 24 Jam ke Depan'
            },
            exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbolStroke: 'rgba(255,255,255,.75)',
                        theme: {
                            fill: 'transparent',
                            stroke: 'transparent',
                            states:{
                                hover:{
                                    fill: 'rgba(0,0,0,.25)',
                                },
                                select:{
                                    fill: 'rgba(0,0,0,.25)',
                                },
                            }
                        }
                    }
                }
            },
            xAxis: [{
                categories: dataHourly.map(function (el) { return moment(el.date).format("HH:mm"); }),
                crosshair: true,
                tickInterval: 3,
            }],
            credits:false,
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}°C',
                    style: {
                        fontWeight:'bold',
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                title: {
                    text: 'Temperatur',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Curah Hujan',
                    style: {
                        color: Highcharts.getOptions().colors[7]
                    }
                },
                labels: {
                    format: '{value} mm',
                    style: {
                        fontWeight:'bold',
                        color: Highcharts.getOptions().colors[7]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        radius: 3
                    }
                }
            },            
            legend: {
                layout: 'horizontal',
                margin:5,
                align: 'center',
                verticalAlign: 'top',
                floating: false,
            },
            series: [{
                name: 'Curah Hujan',
                type: 'column',
                yAxis: 1,
                data: dataHourly.map(function (el) { return parseFloat(el.rain); }),
                color: Highcharts.getOptions().colors[7],
                tooltip: {
                    valueSuffix: ' mm'
                }

            }, {
                name: 'Temperatur Udara',
                type: 'spline',
                data: dataHourly.map(function (el) { return parseFloat(el.temperature.toFixed(1)); }),
                color: Highcharts.getOptions().colors[0],
                tooltip: {
                    valueSuffix: '°C'
                }
            }]
        });

    })  
    // grabbableHourly.addEventListener('mousedown', (e) => {
    //     isDown = true;
    //     grabbableHourly.classList.add('active');
    //     startX = e.pageX - grabbableHourly.offsetLeft;
    //     scrollLeft = grabbableHourly.scrollLeft;
    // });
    // grabbableHourly.addEventListener('mouseleave', () => {
    //     isDown = false;
    //     grabbableHourly.classList.remove('active');
    // });
    // grabbableHourly.addEventListener('mouseup', () => {
    //     isDown = false;
    //     grabbableHourly.classList.remove('active');
    // });
    // grabbableHourly.addEventListener('mousemove', (e) => {
    //     if(!isDown) return;
    //     e.preventDefault();
    //     const x = e.pageX - grabbableHourly.offsetLeft;
    //     const walk = (x - startX); //scroll-fast
    //     grabbableHourly.scrollLeft = scrollLeft - walk;
    // });


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
