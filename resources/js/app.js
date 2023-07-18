require('./bootstrap');

window.initSidebar = function () {
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");

    closeBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("open");
        document.getElementById("logo-footer").classList.toggle("hidden");
        menuBtnChange();//calling the function(optional)
    });
};

window.menuBtnChange = function () {
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");  
    if(sidebar.classList.contains("open")){
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
    }else {
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
    }
};

window.addMapLayer = function (container,position) {
    let layer = L.control({position:position});
    layer.onAdd = function(map){
        this._div = L.DomUtil.get(container)
        return this._div
    }
    layer.addTo(map);
    document.getElementById(container).addEventListener('mouseover', function () {
        map.dragging.disable();
        map.touchZoom.disable();
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        map.boxZoom.disable();
        map.keyboard.disable();
        if (map.tap) map.tap.disable();
        document.getElementById('map').style.cursor='default';
        action = true;
    });
    document.getElementById(container).addEventListener('click', function (e) {
        e.stopPropagation();
    });
    document.getElementById(container).addEventListener('mouseout', function () {
        map.dragging.enable();
        map.touchZoom.enable();
        map.doubleClickZoom.enable();
        map.scrollWheelZoom.enable();
        map.boxZoom.enable();
        map.keyboard.enable();
        if (map.tap) map.tap.enable();
        document.getElementById('map').style.cursor='grab';
        action = false;
    });
    if (container == 'map-zoom') {
        document.getElementById("in").addEventListener("click", function() {
            if (map.getZoom() < 13) {
                map.setZoom(map.getZoom() + 1)
            }
        });
        document.getElementById("out").addEventListener("click", function() {
            if (map.getZoom() > 3) {
                map.setZoom(map.getZoom() - 1)
            }
        });
    }

};

window.initMap = function () {
    var southWest = L.latLng(-9.034173, 115.840986),
        northEast = L.latLng(-8.306094, 116.758226),
        bounds = L.latLngBounds(southWest, northEast);
    map = L.map('map',{zoomControl: false,attributionControl: false,maxBounds: bounds,minZoom: 5}).setView([-8.710704, 116.281385], 10);
    // var CartoDB_DarkMatterNoLabels  = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}{r}.png', {
 //        maxZoom: 20
 //    }).addTo(map);
    // var Stadia_AlidadeSmoothDark = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png?api_key=581a69ec-f6c0-4c6b-8403-d8a8d2082a28', {
    //     maxZoom: 12
    // }).addTo(map);  
    var mapLight = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    }).addTo(map);   
    // let layerStatic = L.esri.dynamicMapLayer({
    //     url: "https://inarisk.bnpb.go.id:6443/arcgis/rest/services/basemap/batas_administrasi/MapServer",
    //     opacity: 0.75
    // }).addTo(map);
    province = L.geoJson(null, {style: style,onEachFeature: function (feature, layer) {
        // layer.bindTooltip(feature.properties.KABUPATEN, {permanent: true,     direction: 'right',className: 'leaflet-tooltip-own' }).openTooltip();
    }});   
    omnivore.topojson(flagsUrl + 'data/loteng.json', null, province).on('ready', function() {
            
    }).setZIndex(-999).bringToBack().addTo(map);
    
    function style(feature) {
        return {
            weight: 0.25,
            // opacity: 0.75,
            fillColor: '#545454',
            color: '#fff',
            fillOpacity: 0.2,
            opacity: 0.9
        };
    }    
};


window.getWeather = function () {
    var colorRGB        = {
        rain            : ['rgba(94,53,177 ,0)', 'rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        rainAcc            : ['rgba(67,160,71 ,0)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)','rgba(142,36,170 ,1)'],
        wspd            : ['rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        temp            : ['rgba(94,53,177 ,0)', 'rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        cloud           : ['rgba(94,53,177 ,0)','rgb(130, 0, 220)', 'rgb(34, 57, 254)', 'rgb(0, 202, 176)', 'rgb(158, 230, 49)', 'rgb(223, 221, 50)'],
        rh              : ['rgba(216,27,96 ,1)','rgba(229,57,53 ,1)','rgba(244,81,30 ,1)', 'rgba(255,179,0 ,1)', 'rgba(192,202,51 ,1)','rgba(67,160,71 ,1)', 'rgba(0,172,193 ,1)', 'rgba(30,136,229 ,1)','rgba(94,53,177 ,1)', 'rgba(94,53,177 ,1)'],
        wave            : ['rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        windWave        : ['rgba(94,53,177 ,0)', 'rgba(30,136,229 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        swell           : ['rgba(94,53,177 ,0)', 'rgba(30,136,229 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        current         : ['rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        sst             : ['rgba(94,53,177 ,1)', 'rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        salinity        : ['rgba(94,53,177 ,1)', 'rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)'],
        radiation       : ['rgba(94,53,177 ,0)', 'rgba(94,53,177 ,1)', 'rgba(30,136,229 ,1)', 'rgba(30,136,229 ,1)', 'rgba(0,172,193 ,1)', 'rgba(67,160,71 ,1)', 'rgba(192,202,51 ,1)', 'rgba(255,179,0 ,1)', 'rgba(244,81,30 ,1)', 'rgba(229,57,53 ,1)', 'rgba(216,27,96 ,1)']
    }
    var colorBreak      = {
        rain            : [0,5,10,15,20,25,30,35,40],
        rainAcc         : [0,25,50,75,100,125,150],
        wspd            : [0,1,2,5,6,8,10,12,14],
        temp            : [-50+273.15,18+273.15,20+273.15,22+273.15,24+273.15,26+273.15,28+273.15,30+273.15,32+273.15,34+273.15],
        cloud           : [0,20,40,60,80,100],
        rh              : [55,60,65,75,80,85,90,95,100],
        wave            : [0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0],
        windWave        : [0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0],
        swell           : [0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0],
        current         : [0,0.25,0.5,0.75,1,1.25,1.5,1.75,2],
        sst             : [18,20,22,24,26,28,30,32,34],
        salinity        : [32,32.5,33,33.5,34,34.5,35,35.5,36],
        radiation       : [0,200,300,400,500,600,700,800,900,1000]
    }
    var colorLegend         = {
        rain            : '<i style="width: calc(100%/10);">0</i><i style="width: calc(100%/10);">5</i><i style="width: calc(100%/10);">10</i><i style="width: calc(100%/10);">15</i><i style="width: calc(100%/10);">20</i><i style="width: calc(100%/10);">25</i><i style="width: calc(100%/10);">30</i><i style="width: calc(100%/10);">35</i><i style="width: calc(100%/10);">40</i><i style="width: calc((100%/10));">mm</i>',
        wspd            : '<i style="width: calc(100%/10);">0</i><i style="width: calc(100%/10);">1</i><i style="width: calc(100%/10);">2</i><i style="width: calc(100%/10);">5</i><i style="width: calc(100%/10);">6</i><i style="width: calc(100%/10);">8</i><i style="width: calc(100%/10);">10</i><i style="width: calc(100%/10);">12</i><i style="width: calc(100%/10);">14</i><i style="width: calc((100%/10));">m/s</i>',
        temp            : '<i style="width: calc(100%/10);">18</i><i style="width: calc(100%/10);">20</i><i style="width: calc(100%/10);">22</i><i style="width: calc(100%/10);">24</i><i style="width: calc(100%/10);">26</i><i style="width: calc(100%/10);">28</i><i style="width: calc(100%/10);">30</i><i style="width: calc(100%/10);">32</i><i style="width: calc(100%/10);">34</i><i style="width: calc((100%/10));"><sup>o</sup>C</i>',
        rh              : '<i style="width: calc(100%/11);">55</i><i style="width: calc(100%/11);">60</i><i style="width: calc(100%/11);">65</i><i style="width: calc(100%/11);">70</i><i style="width: calc(100%/11);">75</i><i style="width: calc(100%/11);">80</i><i style="width: calc(100%/11);">85</i><i style="width: calc(100%/11);">90</i><i style="width: calc(100%/11);">95</i><i style="width: calc(100%/11);">100</i><i style="width: calc((100%/11));">%</i>'
    }
    var layerInfo         = {
        rain            : ['Curah Hujan', 'mm'],
        wspd            : ['Kecepatan Angin', 'm/s'],
        temp            : ['Temperatur Udara', '<sup>o</sup>C'],
        rh              : ['Kelembapan',"%"]
    }

        if(layerData){
            layerData.remove();
            layerData = null;
        }
        tiffData = null;
        let menuLayer = document.getElementsByName('menu-layer');
        for (var i = 0; i < menuLayer.length; i++) {
            if (menuLayer[i].checked) {
                layer = menuLayer[i].value;
                break;

            }
        }
        document.getElementById('map-date').innerHTML = moment(document.getElementById("date").value + " " + document.getElementById("time").value + ":00").format("DD MMMM YYYY HH:00");
        date = moment(document.getElementById("date").value + " " + document.getElementById("time").value + ":00").utc().format("YYYYMMDDHH"); 
        d3.request(storagePath + '/storage/weather/' + layer + '/' + layer + '-' + date + '.tif').responseType('arraybuffer').get(
            function(tiffData) {
                let geo = L.ScalarField.fromGeoTIFF(tiffData.response);
                layerData = L.canvasLayer.scalarField(geo, {
                    color: chroma.scale(colorRGB[layer]).domain(colorBreak[layer]),
                    opacity: 0.6,
                    interpolate: true
                }).addTo(map);
                layerData.on('click', function(e) {
                    if (e.value !== null) {
                        let v = e.value.toFixed(2);
                        let html = (`<span class="popupText" style="margin-right:20px;">${layerInfo[layer][0]}: ${(layer == 'temp' ? (v-273.15).toFixed(1) : v)} ${layerInfo[layer][1]}</span>`);
                        let popup = L.popup()
                            .setLatLng(e.latlng)
                            .setContent(html)
                            .openOn(map);
                    }
                });                    
            }
        );

        var grad = chroma.scale(colorRGB[layer]).domain(colorBreak[layer]);
            var colorGradient = {
                rain        : 'linear-gradient(to right,' + grad(0) + ', ' + grad(5) + ', ' + grad(10) + ', ' + grad(15) + ', ' + grad(20) + ', ' + grad(25) + ', ' + grad(30) + ', ' + grad(35) + ', ' + grad(40) + ', ' + grad(40) + ', ' + grad(40) + ')',
                wspd        : 'linear-gradient(to right,' + grad(0) + ', ' + grad(1) + ', ' + grad(2) + ', ' + grad(5) + ', ' + grad(6) + ', ' + grad(8) + ', ' + grad(10) + ', ' + grad(12) + ', ' + grad(14) + ', ' + grad(14) + ')',
                temp        : 'linear-gradient(to right,' + grad(18+273.15) + ', ' + grad(20+273.15) + ', ' + grad(22+273.15) + ', ' + grad(24+273.15) + ', ' + grad(26+273.15) + ', ' + grad(28+273.15) + ', ' + grad(30+273.15) + ', ' + grad(32+273.15) + ', ' + grad(34+273.15) + ', ' + grad(34+273.15) + ')',
                rh          : 'linear-gradient(to right,' + grad(55) + ', ' + grad(60) + ', ' + grad(65) + ', ' + grad(70) + ', ' + grad(75) + ', ' + grad(80) + ', ' + grad(85) + ', ' + grad(90) + ', ' + grad(95) + ', ' + grad(100) + ', ' + grad(100) + ')'
      
            }
        var bg                      = document.getElementById('weather-legend-container');
        bg.style.backgroundImage    = colorGradient[layer];
        bg.innerHTML                = colorLegend[layer];

        if (velocityLayer) {
                velocityLayer.remove();
        }

        let data = { 
            date: date
        };
        fetch('getWindmap?' + new URLSearchParams(data), {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
                velocityLayer = L.velocityLayer({
                    displayValues: false,
                    data: data[0],
                    maxVelocity: 10,
                    lineWidth:1,
                    velocityScale: 0.005,
                    colorScale: ['#fff']  
                }).addTo(map);

        })
        .catch((error) => {
          console.error('Error:', error);
        }); 
        setTimeout(() => { map.fitBounds(map.getBounds());  }, 1000);  
};

window.getForecast = function () {
    // document.getElementById('layer-name').innerHTML = "Kerentanan Bencana Kabupaten Loteng";
    document.getElementById('map-title').innerHTML = "Peta Prediksi " + (document.getElementById("layer").value != "iklim" ? "Kerentanan " : "") + " " + document.getElementById("layer").value;
    document.getElementById('map-date').innerHTML = moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian").value;
    let currentLayer = document.getElementById("layer").value;

    var gradBanjir = chroma.scale(["#4caf50","#9ecb46","#cfdb41","#f1ae37","#e16b33","#d32f2f"]).domain([0,1,2,3,4,5]);
    var colorGradientBanjir = 'linear-gradient(to right,' + gradBanjir(0) + ', ' + gradBanjir(1) + ', ' + gradBanjir(2) + ', ' + gradBanjir(3) + ', ' + gradBanjir(4) + ', ' + gradBanjir(5) + ')';
    var legendInnerBanjir = '<span style="width: calc(100%/6);color:#111;font-weight:bold;">Aman</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sedang</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Tinggi</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Tinggi</span>';

    var gradLongsor = chroma.scale(["#4caf50","#9ecb46","#cfdb41","#f1ae37","#e16b33","#d32f2f"]).domain([0,1,2,3,4,5]);
    var colorGradientLongsor = 'linear-gradient(to right,' + gradLongsor(0) + ', ' + gradLongsor(1) + ', ' + gradLongsor(2) + ', ' + gradLongsor(3) + ', ' + gradLongsor(4) + ', ' + gradLongsor(5) + ')';
    var legendInnerLongsor = '<span style="width: calc(100%/6);color:#111;font-weight:bold;">Aman</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sedang</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Tinggi</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Tinggi</span>';

    var gradKekeringan = chroma.scale(["#4caf50","#9ecb46","#cfdb41","#f1ae37","#e16b33","#d32f2f"]).domain([0,1,2,3,4,5]);
    var colorGradientKekeringan = 'linear-gradient(to right,' + gradKekeringan(0) + ', ' + gradKekeringan(1) + ', ' + gradKekeringan(2) + ', ' + gradKekeringan(3) + ', ' + gradKekeringan(4) + ', ' + gradKekeringan(5) + ')';
    var legendInnerKekeringan = '<span style="width: calc(100%/6);color:#111;font-weight:bold;">Aman</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sedang</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Tinggi</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Tinggi</span>';

    var grad = chroma.scale(['#d32f2f','#ffeb3b','#1976d2']).domain([0,150,300]);
    var colorGradient = 'linear-gradient(to right,' + grad(0) + ', ' + grad(150) + ', ' + grad(300) + ')';
    var legendInner = '<span style="width: calc(100%/5);color:#111;font-weight:bold;">0</span><span style="width: calc(100%/5);color:#111;font-weight:bold;"></span><span style="width: calc(100%/5);color:#111;font-weight:bold;">150</span><span style="width: calc(100%/5);color:#111;font-weight:bold;"></span><span style="width: calc(100%/5);color:#111;font-weight:bold;">300</span>';



    let bg = document.getElementById('legend-gradient');
    if (currentLayer == 'banjir') {
        bg.style.background = colorGradientBanjir;
        bg.innerHTML = legendInnerBanjir;
        document.getElementById("legend-text").innerHTML = "Kerentanan Bencana Banjir:";
    }else if (currentLayer == 'longsor') {
        bg.style.background = colorGradientLongsor;
        bg.innerHTML = legendInnerLongsor;
        document.getElementById("legend-text").innerHTML = "Kerentanan Bencana Longsor:";
    }else if (currentLayer == 'kekeringan') {
        bg.style.background = colorGradientKekeringan;
        bg.innerHTML = legendInnerKekeringan;
        document.getElementById("legend-text").innerHTML = "Kerentanan Bencana Kekeringan:";
    }else{
        bg.style.background = colorGradient;
        bg.innerHTML = legendInner;
        document.getElementById("legend-text").innerHTML = "Curah Hujan (mm/10 Hari):";
    }

    let data = { 
        month: document.getElementById("month").value,
        dasarian: document.getElementById("dasarian").value, 
    };     
    fetch('getForecast?' + new URLSearchParams(data), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(dataJson => {
        var data = [];
        province.eachLayer(function(layer) {
            var feature = layer.toGeoJSON();
            for (var i = 0; i < dataJson.length; i++) {
                if (dataJson[i].location_id == feature.properties.id) {
                    data.push({
                        name: feature.properties.DESA,
                        longsor: dataJson[i].longsor,
                        banjir: dataJson[i].banjir,
                        kekeringan: dataJson[i].kekeringan,
                        iklim: dataJson[i].iklim
                    });
                    break;
                }
            }
        });
        data = data.sort((a,b) => (a.name > b.name) ? 1 : ((b.name > a.name) ? -1 : 0));
        let categories = ["Sangat Rendah","Rendah","Sedang","Tinggi","Sangat Tinggi"];
        let categoriesColor = ["#1a9641","#a6d96a","#ffffbf","#fdae61","#e65a5c"];

        if (currentLayer == "iklim") {
            filename = ((parseFloat(moment(document.getElementById("month").value).format('M'))-1) * 3 + parseInt(document.getElementById("dasarian").value));
            if(filename < 10){
                filename = '0' + filename;
            }
            fetch(flagsUrl + '/data/iklim/kmz_' + moment(document.getElementById("month").value).format('YYYY') + filename + '/doc.kml')
                .then(res => res.text())
                .then(kmltext => {
                    // Create new kml overlay
                    const parser = new DOMParser();
                    const kml = parser.parseFromString(kmltext, 'text/xml');
                    track = new L.KML(kml);
                    map.addLayer(track);

                    // Adjust map to show the kml
                    const bounds = track.getBounds();
                    map.fitBounds(bounds);
                track.setStyle({opacity: 0.8, fillOpacity: 0.8});
                });          

            province.eachLayer(function(layer) {
                var feature = layer.toGeoJSON();
                let value;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].name == feature.properties.DESA) {
                        feature.properties.longsor = data[i].longsor;
                        feature.properties.iklim = data[i].iklim;
                        feature.properties.banjir = data[i].banjir;
                        feature.properties.kekeringan = data[i].kekeringan;
                        value = data[i][currentLayer];    
                        break;
                    }
                }

                layer.setStyle({
                    color: '#111',
                    strokeWeight: 0,
                    fillOpacity: 0,
                    opacity:1
                });                
                var customOptions =
                {
                    'className' : 'custom'
                };
                content = "<div class='p-1'>" +
                    "<p class='font-bold text-sm' style='margin:2.5px !important;'>" + feature.properties.DESA.replace(/_/g, ' ') + "</p>" + 
                    "<p class='bg-red-700 p-1 font-bold uppercase' style='margin:2.5px !important;'>Tanggal:</p>" + 
                    "<p class='font-bold' style='margin:2.5px !important;'>" + moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian").value + "</p>" + 
                    "<p class='bg-green-700 uppercase font-bold p-1' style='margin:2.5px !important;'>Kerentanan</p>" +
                    "<p class='text-white font-bold' style='margin:2.5px !important;'>Banjir: <span class='px-2 rounded-sm text-gray-900' style='background-color:" + gradBanjir(feature.properties.banjir) + ";'>" + (feature.properties.banjir <= 0 ? "Aman" : (feature.properties.banjir <= 1 ? "Sangat Rendah" : (feature.properties.banjir <= 2 ? "Rendah" : (feature.properties.banjir <= 3 ? "Sedang" : (feature.properties.banjir <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</span></p>" + 
                    "<p class='text-white font-bold' style='margin:2.5px !important;'>Kekeringan: <span class='px-2 rounded-sm text-gray-900' style='background-color:" + gradKekeringan(feature.properties.kekeringan) + ";'>" + (feature.properties.kekeringan <= 0 ? "Aman" : (feature.properties.kekeringan <= 1 ? "Sangat Rendah" : (feature.properties.kekeringan <= 2 ? "Rendah" : (feature.properties.kekeringan <= 3 ? "Sedang" : (feature.properties.kekeringan <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</span></p>" + 
                    "<p class='text-white font-bold' style='margin:2.5px !important;'>longsor: <span class='px-2 rounded-sm text-gray-900' style='background-color:" + gradLongsor(feature.properties.longsor) + ";'>" + (feature.properties.longsor <= 0 ? "Aman" : (feature.properties.longsor <= 1 ? "Sangat Rendah" : (feature.properties.longsor <= 2 ? "Rendah" : (feature.properties.longsor <= 3 ? "Sedang" : (feature.properties.longsor <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</span></p>" + 
                    "<button onclick='openModal(\"" + feature.properties.id + "\");' class='bg-blue-500 w-full text-white py-1 px-2 uppercase text-left font-bold'>Informasi Detail</button>" + 
                "</div>"
                layer.bindPopup(content,customOptions);
            });                
        }else{
            province.eachLayer(function(layer) {
                var feature = layer.toGeoJSON();
                let value;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].name == feature.properties.DESA) {
                        feature.properties.longsor = data[i].longsor;
                        feature.properties.iklim = data[i].iklim;
                        feature.properties.banjir = data[i].banjir;
                        feature.properties.kekeringan = data[i].kekeringan;
                        value = data[i][currentLayer];    
                        break;
                    }
                }
                if (currentLayer == 'banjir') {
                    color = gradBanjir(value);
                }
                if (currentLayer == 'kekeringan') {
                    color = gradKekeringan(value);
                }
                if (currentLayer == 'longsor') {
                    color = gradLongsor(value);
                }

                layer.setStyle({
                    color: '#111',
                    fillColor: color,
                    strokeWeight: 0,
                    fillOpacity: 0.9,
                    opacity:1
                });
                var customOptions =
                {
                    'className' : 'custom'
                };
                content = "<div class='p-1'>" +
                    "<p class='font-bold text-sm' style='margin:2.5px !important;'>" + feature.properties.DESA.replace(/_/g, ' ') + "</p>" + 
                    "<p class='bg-red-700 p-1 font-bold uppercase' style='margin:2.5px !important;'>Tanggal:</p>" + 
                    "<p class='font-bold' style='margin:2.5px !important;'>" + moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian").value + "</p>" + 
                    "<p class='bg-green-700 uppercase font-bold p-1' style='margin:2.5px !important;'>Kerentanan</p>" + 
                    "<p class='text-white font-bold' style='margin:2.5px !important;'>Banjir: <span class='px-2 rounded-sm text-gray-900' style='background-color:" + gradBanjir(feature.properties.banjir) + ";'>" + (feature.properties.banjir <= 0 ? "Aman" : (feature.properties.banjir <= 1 ? "Sangat Rendah" : (feature.properties.banjir <= 2 ? "Rendah" : (feature.properties.banjir <= 3 ? "Sedang" : (feature.properties.banjir <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</span></p>" + 
                    "<p class='text-white font-bold' style='margin:2.5px !important;'>Kekeringan: <span class='px-2 rounded-sm text-gray-900' style='background-color:" + gradKekeringan(feature.properties.kekeringan) + ";'>" + (feature.properties.kekeringan <= 0 ? "Aman" : (feature.properties.kekeringan <= 1 ? "Sangat Rendah" : (feature.properties.kekeringan <= 2 ? "Rendah" : (feature.properties.kekeringan <= 3 ? "Sedang" : (feature.properties.kekeringan <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</span></p>" + 
                    "<p class='text-white font-bold' style='margin:2.5px !important;'>longsor: <span class='px-2 rounded-sm text-gray-900' style='background-color:" + gradLongsor(feature.properties.longsor) + ";'>" + (feature.properties.longsor <= 0 ? "Aman" : (feature.properties.longsor <= 1 ? "Sangat Rendah" : (feature.properties.longsor <= 2 ? "Rendah" : (feature.properties.longsor <= 3 ? "Sedang" : (feature.properties.longsor <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</span></p>" + 
                    "<button onclick='openModal(\"" + feature.properties.id + "\");' class='bg-blue-500 w-full text-white py-1 px-2 uppercase text-left font-bold'>Informasi Detail</button>" + 
                "</div>"
                layer.bindPopup(content,customOptions);
            });
        }


        let table1 = "";
        let table2 = "";
        let table3 = "";
        let table4 = "";
        dataIklim = data.slice(0);
        dataKekeringan = data.slice(0);
        dataBanjir = data.slice(0);
        dataLongsor = data.slice(0);
        dataIklim = dataIklim.sort( function ( a, b ) { return parseFloat(b.iklim) - parseFloat(a.iklim); } );
        dataKekeringan = dataKekeringan.sort( function ( a, b ) { return parseFloat(b.kekeringan) - parseFloat(a.kekeringan); } );
        dataBanjir = dataBanjir.sort( function ( a, b ) { return parseFloat(b.banjir) - parseFloat(a.banjir); } );
        dataLongsor = dataLongsor.sort( function ( a, b ) { return parseFloat(b.longsor) - parseFloat(a.longsor); } );

        for (var i = 0; i < dataIklim.length; i++) {
            table1 += "<tr class='bg-opacity-20 text-xs'>" + "<td class='p-1 border-b border-gray-100 border-opacity-25 font-bold'>" + dataIklim[i].name.replace(/_/g, ' ') + "</td><td class='p-1 text-center border-b border-gray-100 border-opacity-25 font-bold whitespace-nowrap'><span class='px-2 rounded-sm text-gray-900' style='background-color:" + grad(dataIklim[i].iklim) + "'>" + parseFloat(dataIklim[i].iklim.toFixed(1)).toLocaleString('id') + "</span></td>" + "</tr>";
        }
        for (var i = 0; i < dataBanjir.length; i++) {
            table2 += "<tr class='bg-opacity-20 text-xs'>" + "<td class='p-1 border-b border-gray-100 border-opacity-25 font-bold'>" + dataBanjir[i].name.replace(/_/g, ' ') + "</td><td class='p-1 text-center border-b border-gray-100 border-opacity-25 font-bold whitespace-nowrap'><p class='px-2 rounded-sm text-gray-900 inline-block' style='background-color:" + gradBanjir(dataBanjir[i].banjir) + "'><span class='hidden'>" + dataBanjir[i].banjir + "</span>" + (dataBanjir[i].banjir <= 0 ? "Aman" : (dataBanjir[i].banjir <= 1 ? "Sangat Rendah" : (dataBanjir[i].banjir <= 2 ? "Rendah" : (dataBanjir[i].banjir <= 3 ? "Sedang" : (dataBanjir[i].banjir <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</p></td>" + "</tr>";
        }
        for (var i = 0; i < dataKekeringan.length; i++) {
            table3 += "<tr class='bg-opacity-20 text-xs'>" + "<td class='p-1 border-b border-gray-100 border-opacity-25 font-bold'>" + dataKekeringan[i].name.replace(/_/g, ' ') + "</td><td class='p-1 text-center border-b border-gray-100 border-opacity-25 font-bold whitespace-nowrap'><p class='px-2 rounded-sm text-gray-900 inline-block' style='background-color:" + gradKekeringan(dataKekeringan[i].kekeringan) + "'><span class='hidden'>" + dataKekeringan[i].kekeringan + "</span>" + (dataKekeringan[i].kekeringan <= 0 ? "Aman" : (dataKekeringan[i].kekeringan <= 1 ? "Sangat Rendah" : (dataKekeringan[i].kekeringan <= 2 ? "Rendah" : (dataKekeringan[i].kekeringan <= 3 ? "Sedang" : (dataKekeringan[i].kekeringan <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</p></td>" + "</tr>";
        }
        for (var i = 0; i < dataLongsor.length; i++) {
            table4 += "<tr class='bg-opacity-20 text-xs'>" + "<td class='p-1 border-b border-gray-100 border-opacity-25 font-bold'>" + dataLongsor[i].name.replace(/_/g, ' ') + "</td><td class='p-1 text-center border-b border-gray-100 border-opacity-25 font-bold whitespace-nowrap'><p class='px-2 rounded-sm text-gray-900 inline-block' style='background-color:" + gradLongsor(dataLongsor[i].longsor) + "'><span class='hidden'>" + dataLongsor[i].longsor + "</span>" + (dataLongsor[i].longsor <= 0 ? "Aman" : (dataLongsor[i].longsor <= 1 ? "Sangat Rendah" : (dataLongsor[i].longsor <= 2 ? "Rendah" : (dataLongsor[i].longsor <= 3 ? "Sedang" : (dataLongsor[i].longsor <= 4 ? "Tinggi" : "Sangat Tinggi"))))) + "</p></td>" + "</tr>";
        }                        
        document.getElementById("table-2-content").innerHTML = table2;
        document.getElementById("table-3-content").innerHTML = table3;
        document.getElementById("table-4-content").innerHTML = table4;

        // sortTable(1,'table-1-content','float','desc');
        // sortTable(1,'table-2-content','text','desc');
        // sortTable(1,'table-3-content','text','desc');
        // sortTable(1,'table-4-content','text','desc');
        // tableRows = document.getElementById("table-1-content").getElementsByTagName('tr');
        // for (var i = 0; i < tableRows.length; i++) {
        //   tableRows[i].classList.add((i % 2)?"bg-yellow-400":"bg-transparent");
        // }

        // tableRows = document.getElementById("table-2-content").getElementsByTagName('tr');
        // for (var i = 0; i < tableRows.length; i++) {
        //   tableRows[i].classList.add((i % 2)?"bg-yellow-400":"bg-transparent");
        // }

        // tableRows = document.getElementById("table-3-content").getElementsByTagName('tr');
        // for (var i = 0; i < tableRows.length; i++) {
        //   tableRows[i].classList.add((i % 2)?"bg-yellow-400":"bg-transparent");
        // }

        // tableRows = document.getElementById("table-4-content").getElementsByTagName('tr');
        // for (var i = 0; i < tableRows.length; i++) {
        //   tableRows[i].classList.add((i % 2)?"bg-yellow-400":"bg-transparent");
        // }

    })
    .catch((error) => {
        console.error('Error:', error);
    });
};


window.getIklim = function () {
    // document.getElementById('layer-name').innerHTML = "Kerentanan Bencana Kabupaten Loteng";
    document.getElementById('map-title').innerHTML = "Peta Prediksi " + (document.getElementById("layer").value != "iklim" ? "Kerentanan " : "") + " " + document.getElementById("layer").value;
    document.getElementById('map-date').innerHTML = moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian").value;
    let currentLayer = document.getElementById("layer").value;

    var gradBanjir = chroma.scale(["#4caf50","#9ecb46","#cfdb41","#f1ae37","#e16b33","#d32f2f"]).domain([0,5,9.5,11,13.5,15]);
    var colorGradientBanjir = 'linear-gradient(to right,' + gradBanjir(0) + ', ' + gradBanjir(5) + ', ' + gradBanjir(9.5) + ', ' + gradBanjir(11) + ', ' + gradBanjir(13.5) + ', ' + gradBanjir(15) + ')';
    var legendInnerBanjir = '<span style="width: calc(100%/6);color:#111;font-weight:bold;">Aman</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sedang</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Tinggi</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Tinggi</span>';

    var gradLongsor = chroma.scale(["#4caf50","#9ecb46","#cfdb41","#f1ae37","#e16b33","#d32f2f"]).domain([0,1,2,3,4,5]);
    var colorGradientLongsor = 'linear-gradient(to right,' + gradLongsor(0) + ', ' + gradLongsor(1) + ', ' + gradLongsor(2) + ', ' + gradLongsor(3) + ', ' + gradLongsor(4) + ', ' + gradLongsor(5) + ')';
    var legendInnerLongsor = '<span style="width: calc(100%/6);color:#111;font-weight:bold;">Aman</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sedang</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Tinggi</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Tinggi</span>';

    var gradKekeringan = chroma.scale(["#d32f2f","#e47634","#ffeb3b","#9ecb46","#4caf50"]).domain([-2,-1.5,-1,1,1.5]);
    var colorGradientKekeringan = 'linear-gradient(to right,' + gradKekeringan(1.5) + ', ' + gradKekeringan(1) + ', ' + gradKekeringan(-1) + ', ' + gradKekeringan(-1.5) + ', ' + gradKekeringan(-2)  +  ')';
    var legendInnerKekeringan = '<span style="width: calc(100%/6);color:#111;font-weight:bold;">Aman</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Rendah</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sedang</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Tinggi</span><span style="width: calc(100%/6);color:#111;font-weight:bold;">Sangat Tinggi</span>';

    var grad = chroma.scale(["#c2523c", "#db7a25", "#f0b411", "#fcf003","#7bed00", "#06d41b", "#1ba87c","#18758c","0b2c7a"]).domain([0,25,50,75,100,125,150,175,200]);
    var colorGradient = 'linear-gradient(to right,' + grad(0) + ', ' + grad(25) + ', ' + grad(50) + ', ' + grad(75) + ', ' + grad(100) + ', ' + grad(125) + ', ' + grad(150) + ', ' + grad(175) + ', ' + grad(200) + ')';
    var legendInner = '<span style="width: calc(100%/5);color:#111;font-weight:bold;">0</span><span style="width: calc(100%/5);color:#111;font-weight:bold;"></span><span style="width: calc(100%/5);color:#111;font-weight:bold;">100</span><span style="width: calc(100%/5);color:#fff;font-weight:bold;"></span><span style="width: calc(100%/5);color:#fff;font-weight:bold;">200</span>';



    let bg = document.getElementById('legend-gradient');
    if (currentLayer == 'banjir') {
        bg.style.background = colorGradientBanjir;
        bg.innerHTML = legendInnerBanjir;
        document.getElementById("legend-text").innerHTML = "Kerentanan Bencana Banjir:";
    }else if (currentLayer == 'longsor') {
        bg.style.background = colorGradientLongsor;
        bg.innerHTML = legendInnerLongsor;
        document.getElementById("legend-text").innerHTML = "Kerentanan Bencana Longsor:";
    }else if (currentLayer == 'kekeringan') {
        bg.style.background = colorGradientKekeringan;
        bg.innerHTML = legendInnerKekeringan;
        document.getElementById("legend-text").innerHTML = "Kerentanan Bencana Kekeringan:";
    }else{
        bg.style.background = colorGradient;
        bg.innerHTML = legendInner;
        document.getElementById("legend-text").innerHTML = "Curah Hujan (mm/10 Hari):";
    }

    let data = { 
        month: document.getElementById("month").value,
        dasarian: document.getElementById("dasarian").value, 
    };     
    fetch('getForecast?' + new URLSearchParams(data), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(dataJson => {
        var data = [];
        province.eachLayer(function(layer) {
            var feature = layer.toGeoJSON();
            for (var i = 0; i < dataJson.length; i++) {
                if (dataJson[i].location_id == feature.properties.id) {
                    data.push({
                        name: feature.properties.DESA,
                        longsor: dataJson[i].longsor,
                        banjir: dataJson[i].banjir,
                        kekeringan: dataJson[i].kekeringan,
                        iklim: dataJson[i].iklim
                    });
                    break;
                }
            }
        });
        data = data.sort((a,b) => (a.name > b.name) ? 1 : ((b.name > a.name) ? -1 : 0));
        let categories = ["Sangat Rendah","Rendah","Sedang","Tinggi","Sangat Tinggi"];
        let categoriesColor = ["#1a9641","#a6d96a","#ffffbf","#fdae61","#e65a5c"];

        if (currentLayer == "iklim") {
            filename = ((parseFloat(moment(document.getElementById("month").value).format('M'))-1) * 3 + parseInt(document.getElementById("dasarian").value));
            if(filename < 10){
                filename = '0' + filename;
            }
            fetch(flagsUrl + '/data/iklim/kmz_' + moment(document.getElementById("month").value).format('YYYY') + filename + '/doc.kml')
                .then(res => res.text())
                .then(kmltext => {
                    // Create new kml overlay
                    const parser = new DOMParser();
                    const kml = parser.parseFromString(kmltext, 'text/xml');
                    track = new L.KML(kml);
                    map.addLayer(track);

                    // Adjust map to show the kml
                    const bounds = track.getBounds();
                    map.fitBounds(bounds);
                track.setStyle({opacity: 0.8, fillOpacity: 0.8});
                });          

            province.eachLayer(function(layer) {
                var feature = layer.toGeoJSON();
                let value;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].name == feature.properties.DESA) {
                        feature.properties.longsor = data[i].longsor;
                        feature.properties.iklim = data[i].iklim;
                        feature.properties.banjir = data[i].banjir;
                        feature.properties.kekeringan = data[i].kekeringan;
                        value = data[i][currentLayer];    
                        break;
                    }
                }

                layer.setStyle({
                    color: '#111',
                    strokeWeight: 0,
                    fillOpacity: 0,
                    opacity:1
                });                
                var customOptions =
                {
                    'className' : 'custom'
                };
                content = "<div class='p-1'>" +
                    "<p class='font-bold text-sm' style='margin:2.5px !important;'>" + feature.properties.DESA.replace(/_/g, ' ') + "</p>" + 
                    "<p class='bg-red-700 p-1 font-bold uppercase' style='margin:2.5px !important;'>Tanggal:</p>" + 
                    "<p class='font-bold' style='margin:2.5px !important;'>" + moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian").value + "</p>" + 
                    "<p class='bg-yellow-500 uppercase font-bold p-1' style='margin:2.5px !important;'>Iklim</p>" +
                    "<p class='text-yellow-500 font-bold' style='margin:2.5px !important;'>Curah Hujan: <span class='text-white'>" + Math.round(feature.properties.iklim).toLocaleString('id') + " mm</span></p>" + 
                    "<button onclick='openModal(\"" + feature.properties.id + "\");' class='bg-blue-500 w-full text-white py-1 px-2 uppercase text-left font-bold'>Informasi Detail</button>" + 
                "</div>"
                layer.bindPopup(content,customOptions);
            });                
        }


        let table1 = "";
        dataIklim = data.slice(0);
        dataIklim = dataIklim.sort( function ( a, b ) { return parseFloat(b.iklim) - parseFloat(a.iklim); } );

        for (var i = 0; i < dataIklim.length; i++) {
            table1 += "<tr class='bg-opacity-20 text-xs'>" + "<td class='p-1 border-b border-gray-100 border-opacity-25 font-bold'>" + dataIklim[i].name.replace(/_/g, ' ') + "</td><td class='p-1 text-center border-b border-gray-100 border-opacity-25 font-bold whitespace-nowrap'><span class='px-2 rounded-sm text-gray-900' style='background-color:" + grad(dataIklim[i].iklim) + "'>" + parseFloat(dataIklim[i].iklim.toFixed(1)).toLocaleString('id') + "</span></td>" + "</tr>";
        }
        document.getElementById("table-1-content").innerHTML = table1;

    })
    .catch((error) => {
        console.error('Error:', error);
    });
};


window.getHama = function () {
    document.getElementById('map-title').innerHTML = "Kerentanan Hama";
    document.getElementById('map-date').innerHTML = moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian")[document.getElementById("dasarian").value-1].innerHTML;


    let data = { 
        month: document.getElementById("month").value,
        dasarian: document.getElementById("dasarian").value, 
    };     
    fetch('getHama?' + new URLSearchParams(data), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
        .then(dataJson => {
            data = [];
            province.eachLayer(function(layer) {
                var feature = layer.toGeoJSON();
                layer.on('click', function (e) {
                    openModal(feature.properties.id)
                });
                var feature = layer.toGeoJSON();
                for (var i = 0; i < dataJson.length; i++) {
                    if (dataJson[i].location_id == feature.properties.id) {
                        data.push({
                            name: feature.properties.DESA,
                            value: dataJson[i].value,
                            description: dataJson[i].description
                        });
                        value = dataJson[i].value;
                        break;
                    }
                }
                if(value == 0){
                    color = '#8dd3c7';
                    // color = '#F9A3CB';
                }else if(value == 1){
                    color = '#ffffb3';
                    // color = '#E56AB3';
                }else if(value == 2){
                    color = '#bebada';
                }else if(value == 3){
                    color = '#fb8072';
                }else if(value == 4){
                    color = '#fdb462';
                }else if(value == 5){
                    color = '#b3de69';
                }else{
                    color = 'rgba(255,255,255 ,1)';
                }
                layer.setStyle({
                    color: '#111',
                    fillColor: color,
                    strokeWeight: 0,
                    fillOpacity: 0.9,
                    opacity:1
                });            
            });

            data = data.sort( function ( a, b ) { return parseFloat(b.value) - parseFloat(a.value); } );
            let table1 = "";
            let categoriesColor = ["#80b1d3","#8dd3c7","#ffffb3","#bebada","#fdb462","#fb8072","#b3de69"];
            categoriesColor[9999] = "";
            for (var i = 0; i < data.length; i++) {
                table1 += "<tr class='text-xs'>" + "<td class='font-bold p-1 border-b border-gray-200 border-opacity-20'>" + data[i].name.replace(/_/g, ' ') + "</td>" + "<td class='p-1 text-center border-b border-gray-200 border-opacity-20 whitespace-nowrap font-bold'><p class='px-2 inline-block text-gray-900' style='background-color:" + categoriesColor[(data[i].value)] + "'><span class='hidden'>" + (data[i].value) + "</span>" + data[i].value + "</p></td><td class='p-1 border-b border-gray-200 border-opacity-20'><p class='px-2 inline-block text-gray-200' style='max-width:150px;'>" + data[i].description + "</p></td>" + "</tr>";
            }

            document.getElementById("table-1-content").innerHTML = table1;

    })
    .catch((error) => {
        console.error('Error:', error);
    });
};

window.getKatam = function () {
    document.getElementById('layer-name').innerHTML = "Kalender Tanam Padi Kabupaten Loteng";
    document.getElementById('map-title').innerHTML = "Peta Kalender Tanam Padi";
    document.getElementById('map-date').innerHTML = moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian")[document.getElementById("dasarian").value-1].innerHTML;


    let data = { 
        month: document.getElementById("month").value,
        dasarian: document.getElementById("dasarian").value, 
    };     
    fetch('getKatam?' + new URLSearchParams(data), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
        .then(dataJson => {
            data = [];
            province.eachLayer(function(layer) {
                var feature = layer.toGeoJSON();
                layer.on('click', function (e) {
                    openModal(feature.properties.id)
                });
                var feature = layer.toGeoJSON();
                for (var i = 0; i < dataJson.length; i++) {
                    if (dataJson[i].location_id == feature.properties.id) {
                        data.push({
                            name: feature.properties.DESA,
                            value: dataJson[i].value
                        });
                        value = dataJson[i].value;
                        break;
                    }
                }
                if(value == 9999){
                    color = '#80b1d3';
                    // color = '#FFCEE6';
                }else if(value == 0){
                    color = '#8dd3c7';
                    // color = '#F9A3CB';
                }else if(value == 1){
                    color = '#ffffb3';
                    // color = '#E56AB3';
                }else if(value == 2){
                    color = '#bebada';
                }else if(value == 3){
                    color = '#fb8072';
                }else if(value == 4){
                    color = '#fdb462';
                }else if(value == 5){
                    color = '#b3de69';
                }else{
                    color = 'rgba(255,255,255 ,1)';
                }
                layer.setStyle({
                    color: '#111',
                    fillColor: color,
                    strokeWeight: 0,
                    fillOpacity: 0.9,
                    opacity:1
                });            
            });

            data = data.sort( function ( a, b ) { return parseFloat(b.value) - parseFloat(a.value); } );
            let table1 = "";
            let categories = ["Tanam","Pemupukan I","Pemupukan II","Pestisida I","Pestisida II","Panen"];
            categories[9999] = "Bera";
            let categoriesColor = ["#8dd3c7","#ffffb3","#bebada","#fb8072","#fdb462","#b3de69"];
            categoriesColor[9999] = "#80b1d3";
            for (var i = 0; i < data.length; i++) {
                table1 += "<tr class='text-xs'>" + "<td class='font-bold p-1 border-b border-gray-200 border-opacity-20'>" + data[i].name.replace(/_/g, ' ') + "</td>" + "<td class='p-1 text-center border-b border-gray-200 border-opacity-20 whitespace-nowrap font-bold'><p class='px-2 inline-block text-gray-900' style='background-color:" + categoriesColor[(data[i].value)] + "'><span class='hidden'>" + (data[i].value) + "</span>" + categories[data[i].value] + "</p></td>" + "</tr>";
            }

            document.getElementById("table-1-content").innerHTML = table1;

    })
    .catch((error) => {
        console.error('Error:', error);
    });
};


window.getKatamPalawija = function () {
    document.getElementById('layer-name').innerHTML = "Kalender Tanam Palawija Kabupaten Loteng";
    document.getElementById('map-title').innerHTML = "Peta Kalender Tanam Palawija";
    document.getElementById('map-date').innerHTML = moment(document.getElementById("month").value).format("MMMM YYYY") + " Dasarian " + document.getElementById("dasarian")[document.getElementById("dasarian").value-1].innerHTML;


    let data = { 
        month: document.getElementById("month").value,
        dasarian: document.getElementById("dasarian").value, 
    };     
    fetch('getKatamPalawija?' + new URLSearchParams(data), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
        .then(dataJson => {
            data = [];
            province.eachLayer(function(layer) {
                var feature = layer.toGeoJSON();
                layer.on('click', function (e) {
                    openModal(feature.properties.id)
                });
                var feature = layer.toGeoJSON();
                for (var i = 0; i < dataJson.length; i++) {
                    if (dataJson[i].location_id == feature.properties.id) {
                        data.push({
                            name: feature.properties.DESA,
                            value: dataJson[i].value
                        });
                        value = dataJson[i].value;
                        break;
                    }
                }
                if(value == 9999){
                    color = '#80b1d3';
                    // color = '#FFCEE6';
                }else if(value == 0){
                    color = '#8dd3c7';
                    // color = '#F9A3CB';
                }else if(value == 1){
                    color = '#ffffb3';
                    // color = '#E56AB3';
                }else if(value == 2){
                    color = '#bebada';
                }else if(value == 3){
                    color = '#fb8072';
                }else if(value == 4){
                    color = '#b3de69';
                }else{
                    color = 'rgba(255,255,255 ,1)';
                }
                layer.setStyle({
                    color: '#111',
                    fillColor: color,
                    strokeWeight: 0,
                    fillOpacity: 0.9,
                    opacity:1
                });            
            });

            data = data.sort( function ( a, b ) { return parseFloat(b.value) - parseFloat(a.value); } );
            let table1 = "";
            let categories = ["Tanam","Pemupukan I","Pemupukan II","Pestisida","Panen"];
            categories[9999] = "Bera";
            let categoriesColor = ["#8dd3c7","#ffffb3","#bebada","#fb8072","#fdb462","#b3de69"];
            categoriesColor[9999] = "#80b1d3";
            for (var i = 0; i < data.length; i++) {
                table1 += "<tr class='text-xs'>" + "<td class='font-bold p-1 border-b border-gray-200 border-opacity-20'>" + data[i].name.replace(/_/g, ' ') + "</td>" + "<td class='p-1 text-center border-b border-gray-200 border-opacity-20 whitespace-nowrap font-bold'><p class='px-2 inline-block text-gray-900' style='background-color:" + categoriesColor[(data[i].value)] + "'><span class='hidden'>" + (data[i].value) + "</span>" + categories[data[i].value] + "</p></td>" + "</tr>";
            }

            document.getElementById("table-1-content").innerHTML = table1;

    })
    .catch((error) => {
        console.error('Error:', error);
    });
};

window.getVillageForecast = function (village) {
    let dataInput = { 
        month: document.getElementById("month").value,
        village: village, 
    };     
    fetch('getVillageForecast?' + new URLSearchParams(dataInput), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
    categories = ["","Sangat Rendah","Rendah","Sedang","Tinggi","Sangat Tinggi"];

        Highcharts.theme = {
            "colors": ['#d53e4f','#f46d43','#fdae61','#fee08b','#e6f598','#abdda4','#66c2a5','#3288bd'],
            "chart": {
                "style": {
                  "fontFamily": "Roboto",
                  "color": "#111"
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
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });        
        
        Highcharts.chart('chart-1', {
            chart: {
                type: 'column',
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "PREDIKSI IKLIM<br>" + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY"),
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
                min: 0,
                max: 250,
                title: {
                    text: 'Curah Hujan (mm)'
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0 5px;font-weight:bold;">{series.name}: </td>' +
                    '<td style="padding:0 5px"><b>{point.y:,.0f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: data.iklim.dasarian1,
                color: Highcharts.getOptions().colors[7]
            },{
                name: 'Tanggal 11-20',
                data: data.iklim.dasarian2,
                color: Highcharts.getOptions().colors[2]
            },{
                name: 'Tanggal 21-30',
                data: data.iklim.dasarian3,
                color: Highcharts.getOptions().colors[0]
            }]
        });
        Highcharts.chart('chart-2', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "PREDIKSI KERENTANAN BANJIR<br>" + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY"),
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
                data: data.banjir.dasarian1,
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: data.banjir.dasarian2,
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: data.banjir.dasarian3,
                color: "rgba(200,200,200,1)"
            }]
        });

        Highcharts.chart('chart-3', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "PREDIKSI KERENTANAN KEKERINGAN<br>" + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY"),
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
                data: data.kekeringan.dasarian1,
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: data.kekeringan.dasarian2,
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: data.kekeringan.dasarian3,
                color: "rgba(200,200,200,1)"
            }]
        });

        Highcharts.chart('chart-4', {
            chart: {
                type: 'column',
                marginLeft:100,
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "PREDIKSI KERENTANAN LONGSOR<br>" + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY"),
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
                data: data.longsor.dasarian1,
                color: "rgba(0,0,0,1)"
            },{
                name: 'Tanggal 11-20',
                data: data.longsor.dasarian2,
                color: "rgba(100,100,100,1)"
            },{
                name: 'Tanggal 21-30',
                data: data.longsor.dasarian3,
                color: "rgba(200,200,200,1)"
            }]
        });
    })
    .catch((error) => {
        console.error('Error:', error);
    });    
};


window.getVillageHama = function (village) {
    let dataInput = { 
        month: document.getElementById("month").value,
        village: village, 
    };     
    fetch('getVillageHama?' + new URLSearchParams(dataInput), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        Highcharts.theme = {
            "colors": ['#d53e4f','#f46d43','#fdae61','#fee08b','#e6f598','#abdda4','#66c2a5','#3288bd'],
            "chart": {
                "style": {
                  "fontFamily": "Roboto",
                  "color": "#111"
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
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });        
        
        Highcharts.chart('chart-1', {
            chart: {
                type: 'column',
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "PREDIKSI KERENTANAN HAMA<br>" + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY"),
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
                min: 0,
                max: 5,
                interval: 1,
                title: {
                    text: 'Jenis Hama'
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0 5px;font-weight:bold;">{series.name}: </td>' +
                    '<td style="padding:0 5px"><b>{point.y:,.0f} Jenis</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Tanggal 1-10',
                data: data.katam.filter(o => o.dasarian == 1).map(a => a.value),
                color: Highcharts.getOptions().colors[7]
            },{
                name: 'Tanggal 11-20',
                data: data.katam.filter(o => o.dasarian == 2).map(a => a.value),
                color: Highcharts.getOptions().colors[2]
            },{
                name: 'Tanggal 21-30',
                data: data.katam.filter(o => o.dasarian == 3).map(a => a.value),
                color: Highcharts.getOptions().colors[0]
            }]
        });
    })
    .catch((error) => {
        console.error('Error:', error);
    });    
};


window.getVillageKatam = function (village) {
    let dataInput = { 
        month: document.getElementById("month").value,
        village: village, 
    };     
    fetch('getVillageKatam?' + new URLSearchParams(dataInput), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
            document.getElementById("modal-title").innerHTML = "Kalender Tanam Padi " + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY");
            content = "";
            content += "<tr><td class='py-1 px-2 border text-xs'>Mulai Tanam</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 0 ? "<td class='p-2 text-center text-white border' style='background:#8dd3c7;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 1</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 1 ? "<td class='p-2 text-center text-white border' style='background:#ffffb3;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 2</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 2 ? "<td class='p-2 text-center text-white border' style='background:#bebada;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 1</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 3 ? "<td class='p-2 text-center text-white border' style='background:#fb8072;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 2</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 4 ? "<td class='p-2 text-center text-white border' style='background:#fdb462;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Panen</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 5 ? "<td class='p-2 text-center text-white border' style='background:#b3de69;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            document.getElementById("table-katam").innerHTML = content;
    })
    .catch((error) => {
        console.error('Error:', error);
    });    
};

window.getVillageKatamPalawija = function (village) {
    let dataInput = { 
        month: document.getElementById("month").value,
        village: village, 
    };     
    fetch('getVillageKatamPalawija?' + new URLSearchParams(dataInput), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
            document.getElementById("modal-title").innerHTML = "Kalender Tanam Palawija " + data.location.village + " " + moment(document.getElementById("month").value).format("YYYY");
            content = "";
            content += "<tr><td class='py-1 px-2 border text-xs'>Mulai Tanam</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 0 ? "<td class='p-2 text-center text-white border' style='background:#8dd3c7;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 1</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 1 ? "<td class='p-2 text-center text-white border' style='background:#ffffb3;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pupuk Fase 2</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 2 ? "<td class='p-2 text-center text-white border' style='background:#bebada;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Pestisida 1</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 3 ? "<td class='p-2 text-center text-white border' style='background:#fb8072;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            content += "<tr><td class='py-1 px-2 border text-xs'>Panen</td>";
            for (var i = 0; i < 36; i++) {
                content += (data.katam[i] == 4 ? "<td class='p-2 text-center text-white border' style='background:#b3de69;" + ((i+1) % 3 == 0 ? "border-right:1px solid #000;" : "") + "'></td>" : "<td class='p-2 text-center border' " + ((i+1) % 3 == 0 ? "style='border-right:1px solid #000;'" : "") + "></td>");
            }
            content += "</tr>";
            document.getElementById("table-katam").innerHTML = content;
    })
    .catch((error) => {
        console.error('Error:', error);
    });    
};


window.getProvincePhase = function (province) {
            let name = province;
            if (province == "DAERAH ISTIMEWA YOGYAKARTA") {
                name = "YOGYAKARTA";
            }
            if (province == "DKI") {
                name = "DKI JAKARTA";
            }
            if (province == "NTB") {
                name = "NUSA TENGGARA BARAT";
            }
            if (province == "NTT") {
                name = "NUSA TENGGARA TIMUR";
            }
            if (province == "KEPULAUAN BANGKA BELITUNG") {
                name = "KEP BANGKA BELITUNG";
            }
            if (province == "KEPULAUAN RIAU") {
                name = "KEP RIAU";
            }
            let filterData = data.filter(function (el) {
              return el.Provinsi == name;
            });
            let groupKabupaten = [];
            regencies = [...new Set(filterData.map(a => a["Kabkot"]))];
            for (var i = 0; i < regencies.length; i++) {
                let tmp = filterData.filter(function (el) {
                  return el["Kabkot"] == regencies[i];
                });
                let sumPanen = (prev, cur) => ({Panen: parseFloat(prev.Panen) + parseFloat(cur.Panen)});
                let sumLahan = (prev, cur) => ({["Lhn Sawah"]: parseFloat(prev["Lhn Sawah"]) + parseFloat(cur["Lhn Sawah"])});
                let sumGen1 = (prev, cur) => ({["Gen 1"]: parseFloat(prev["Gen 1"]) + parseFloat(cur["Gen 1"])});
                let sumGen2 = (prev, cur) => ({["Gen 2"]: parseFloat(prev["Gen 2"]) + parseFloat(cur["Gen 2"])});
                let sumVeg1 = (prev, cur) => ({["Veg 1"]: parseFloat(prev["Veg 1"]) + parseFloat(cur["Veg 1"])});
                let sumVeg2 = (prev, cur) => ({["Veg 2"]: parseFloat(prev["Veg 2"]) + parseFloat(cur["Veg 2"])});
                let sumMaxVeg = (prev, cur) => ({["Max Veg"]: parseFloat(prev["Max Veg"]) + parseFloat(cur["Max Veg"])});
                groupKabupaten.push({
                    name: regencies[i],
                    ["Lhn Sawah"]: tmp.reduce(sumLahan)["Lhn Sawah"],
                    ["Panen"]: tmp.reduce(sumPanen)["Panen"],
                    ["Veg 1"]: tmp.reduce(sumVeg1)["Veg 1"],
                    ["Veg 2"]: tmp.reduce(sumVeg2)["Veg 2"],
                    ["Max Veg"]: tmp.reduce(sumMaxVeg)["Max Veg"],
                    ["Gen 1"]: tmp.reduce(sumGen1)["Gen 1"],
                    ["Gen 2"]: tmp.reduce(sumGen2)["Gen 2"]
                });

                groupKabupaten.sort((a, b) => {
                    return b["Panen"] - a["Panen"];
                });

            }
        Highcharts.theme = {
            "colors": ['#d53e4f','#f46d43','#fdae61','#fee08b','#e6f598','#abdda4','#66c2a5','#3288bd'],
            "chart": {
                "style": {
                  "fontFamily": "Roboto",
                  "color": "#fff"
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
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });        
        
        Highcharts.chart('chart-1', {
            chart: {
                type: 'column',
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: "FASE TANAMAN PADI " + province,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                max:7,
                categories: groupKabupaten.map(a => a.name),
                crosshair: true,
                scrollbar: {
                    enabled: true
                },                
            },
            yAxis: {
                min: 0,
                max: 100000,
                title: {
                    text: 'Luas (ha)'
                }
            },
            legend:{
                enabled:true
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0 5px;font-weight:bold;">{series.name}: </td>' +
                    '<td style="padding:0 5px"><b>{point.y:,.0f} ha</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
            // {
            //     name: 'Luas Sawah',
            //     data: groupKabupaten.map(a => parseFloat(a["Lhn Sawah"])),
            //     stack: 'Luas'
            // },
            // {
            //     name: 'Max Veg',
            //     data: groupKabupaten.map(a => parseFloat(a["Max Veg"])),
            //     stack: 'Max Veg'
            // },
            {
                name: 'Panen',
                data: groupKabupaten.map(a => parseFloat(a["Panen"])),
                stack: 'Fase'
            },
            {
                name: 'Gen 2',
                data: groupKabupaten.map(a => parseFloat(a["Gen 2"])),
                stack: 'Fase'
            },
            {
                name: 'Gen 1',
                data: groupKabupaten.map(a => parseFloat(a["Gen 1"])),
                stack: 'Fase'
            },
            {
                name: 'Veg 2',
                data: groupKabupaten.map(a => parseFloat(a["Veg 2"])),
                stack: 'Fase'
            },
            {
                name: 'Veg 1',
                data: groupKabupaten.map(a => parseFloat(a["Veg 1"])),
                stack: 'Fase'
            }]
        });
};

window.getProvinceCommodity = function (province,commodity) {
    let data = { 
        province: province,
        commodity: commodity, 
    };      
    fetch('getProvinceCommodity?' + new URLSearchParams(data), {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {

        Highcharts.theme = {
            "colors": ['#d53e4f','#f46d43','#fdae61','#fee08b','#e6f598','#abdda4','#66c2a5','#3288bd'],
            "chart": {
                "style": {
                  "fontFamily": "Roboto",
                  "color": "#fff"
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
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });        
        
        Highcharts.chart('chart-1', {
            chart: {
                type: 'column',
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: 'STOK ' + commodity.toUpperCase() + "<br>" + province,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            }, 
            exporting:false,
            credits:false,
            xAxis: {
                categories: data.map(a => a.tanggal),
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Stok (ton)'
                }
            },
            legend:{
                enabled:false
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0 5px;font-weight:bold;">{series.name}: </td>' +
                    '<td style="padding:0 5px"><b>{point.y:,.0f} ton</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Provinsi',
                data: data.map(a => a.stok_provinsi),
                color: Highcharts.getOptions().colors[7],
                stack: 'Stok'
            },{
                name: 'Bulog',
                data: data.map(a => a.stok_bulog),
                color: Highcharts.getOptions().colors[2],
                stack: 'Stok'
            },{
                name: 'Kebutuhan',
                data: data.map(a => a.kebutuhan),
                color: Highcharts.getOptions().colors[0],
                stack: 'Kebutuhan'
            }]
        });
        Highcharts.chart('chart-2', {
            chart: {
                type: 'line',
                style: {
                    fontFamily: 'Encode Sans'
                }
            },
            title: {
                text: 'HARGA ' + commodity.toUpperCase() + "<br>" + province,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            exporting:false,
            credits:false,
            xAxis: {
                categories: data.map(a => a.tanggal),
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Harga (Rp)'
                }
            },
            legend:{
                enabled:false
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px;padding:0 5px;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0 5px;font-weight:bold;">{series.name}: </td>' +
                    '<td style="padding:0 5px"><b>{point.y:,.0f} ton</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            series: [{
                name: 'Harga',
                data: data.map(a => a.harga)
            }]
        });
    })
    .catch((error) => {
        console.error('Error:', error);
    });

};

window.sortTable = function (n,container,type,sort) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(container);
  switching = true;
  // Set the sorting direction to ascending:
  dir = sort;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 0; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
    if (type == "text") {  
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }else{
      if (dir == "asc") {
        if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }        
    }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
};

window.generateRandomNumber = function (min, max) {
    let random = Math.random() * (max - min) + min;
    return random;
};