<div wire:init="init">
    <div class="flex flex-col flex-nowrap">
        <div>
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="px-4">
                        <div class="flex mb-1">
                            <div>
                                <p class="my-auto uppercase font-bold text-xl md:text-3xl">Prediksi Cuaca {{ $location->village }}</p>
                                <!-- <p class="my-auto text-2xl">{{ $location->village }}</p> -->
                                <div class="flex gap-2" wire:ignore>
                                    <select class="bg-yellow-400 p-2 font-bold rounded-sm text-2xl" name="location-id" id="location-id" wire:model.lazy="searchLocation">
                                        @foreach($locations as $val)
                                            <option value="{{$val->id}}" class="bg-white text-sm py-2 my-2">{{ ucwords(strtolower(str_replace("_"," ",$val->village))) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="hidden md:block my-auto">
                                        <i class='bx bx-search text-4xl font-bold'></i>
                                    </div>
                                </div>
                                <p id="forecast-date" class="my-auto">{{ \Carbon\Carbon::create($date)->translatedFormat("d F Y H:i") }}</p>
                            </div>
                        </div>
                        <p class="my-auto font-bold text-5xl"><span id="forecast-temperature">{{ number_format($currentForecast->temperature, 1,',','.') }}</span><span><sup>o</sup>C</span></p>
                        <p id="forecast-rain" class="my-auto font-bold text-xl">{{ ($currentForecast->rain < 1 ? "Cerah" : ($currentForecast->rain < 5 ? "Hujan Ringan" : ($currentForecast->rain < 10 ? "Hujan Sedang" : ($currentForecast->rain < 20 ? "Hujan Lebat" : "Hujan Sangat Lebat")))) }}</p>
                        <button class="modal-daily-open text-white text-sm bg-yellow-500 py-1 px-2 hover:bg-yellow-400 hover:text-black rounded-sm" onclick="getWeatherTable('{{ \Carbon\Carbon::now()->format("Y-m-d")}}')"><i class='bx bx-book-reader'></i> Cuaca Hari Ini</button>
                    </div>
                    <div class="hidden md:block my-2"><img id="forecast-img" src="{{ asset('img/' . ($currentForecast->rain < 1 ? 'day-clear' : 'day-rain') . '.png') }}" class="ml-auto img-fluid" style="max-height:200px;"></div>
                </div>
            </div>
            <div class="my-4">
                <div class="px-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <p class="uppercase font-bold">Prediksi Kebencanaan {{ $location->village }} Bulan {{\Carbon\Carbon::now()->translatedFormat('F Y')}}</p>
                        <table class="table-auto w-full text-sm">
                            <thead>
                                <tr class="border-b border-opacity-10 border-white bg-green-700 text-white">
                                    <th class="py-1 text-xs md:text-base" rowspan="2">Jenis</th>
                                    <th class="py-1 text-xs md:text-base" colspan="3">Kerentanan</th>
                                </tr>
                                <tr class="border-b border-opacity-10 border-white bg-green-700 text-white">
                                    <th class="py-1 text-xs md:text-base">Tanggal 1-10</th>
                                    <th class="py-1 text-xs md:text-base">Tanggal 11-20</th>
                                    <th class="py-1 text-xs md:text-base">Tanggal 21-30</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-opacity-10 border-gray-700">
                                    <td class="py-1 text-xs md:text-base">Hujan</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ $longterm->where("hazard_id",1)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ $longterm->where("hazard_id",1)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ $longterm->where("hazard_id",1)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value }}</td>
                                </tr>
                                <tr class="border-b border-opacity-10 border-gray-700 bg-gray-100">
                                    <td class="py-1 text-xs md:text-base">Banjir</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 5 ? "Aman" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 9.5 ? "Sangat Rendah" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 11 ? "Rendah" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 13.5 ? "Sedang" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 15 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 5 ? "Aman" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 9.5 ? "Sangat Rendah" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 11 ? "Rendah" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 13.5 ? "Sedang" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 15 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 5 ? "Aman" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 9.5 ? "Sangat Rendah" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 11 ? "Rendah" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 13.5 ? "Sedang" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 15 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                </tr>
                                <tr class="border-b border-opacity-10 border-gray-700">
                                    <td class="py-1 text-xs md:text-base">Longsor</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",4)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 0 ? "Aman" :($longterm->where("hazard_id",4)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 1 ? "Sangat Rendah" :($longterm->where("hazard_id",4)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 2 ? "Rendah" :($longterm->where("hazard_id",4)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 3 ? "Sedang" :($longterm->where("hazard_id",4)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 4 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",4)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 0 ? "Aman" :($longterm->where("hazard_id",4)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 1 ? "Sangat Rendah" :($longterm->where("hazard_id",4)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 2 ? "Rendah" :($longterm->where("hazard_id",4)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 3 ? "Sedang" :($longterm->where("hazard_id",4)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 4 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",4)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 0 ? "Aman" :($longterm->where("hazard_id",4)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 1 ? "Sangat Rendah" :($longterm->where("hazard_id",4)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 2 ? "Rendah" :($longterm->where("hazard_id",4)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 3 ? "Sedang" :($longterm->where("hazard_id",4)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value <= 4 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                </tr>
                                <tr class="border-b border-opacity-10 border-gray-700 bg-gray-100">
                                    <td class="py-1 text-xs md:text-base">Kekeringan</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 5 ? "Aman" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 9.5 ? "Sangat Rendah" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 11 ? "Rendah" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 13.5 ? "Sedang" :($longterm->where("hazard_id",3)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 15 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 5 ? "Aman" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 9.5 ? "Sangat Rendah" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 11 ? "Rendah" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 13.5 ? "Sedang" :($longterm->where("hazard_id",3)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 15 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                    <td class="py-1 text-center text-xs md:text-base font-bold">{{ ($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 5 ? "Aman" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 9.5 ? "Sangat Rendah" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 11 ? "Rendah" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 13.5 ? "Sedang" :($longterm->where("hazard_id",3)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value < 15 ? "Tinggi" :("Sangat Tinggi")))))) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p class="uppercase font-bold">Aktivitas Pertanian {{ $location->village }} Bulan {{\Carbon\Carbon::now()->translatedFormat('F Y')}}</p>
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="border-b border-opacity-10 border-white bg-green-700 text-white">
                                    <th class="text-xs md:text-base py-1">Tanggal</th>
                                    <th class="text-xs md:text-base py-1">Padi</th>
                                    <th class="text-xs md:text-base py-1">Palawija</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $katamCategories = ["Tanam","Pemupukan 1","Pemupukan 2","Pestisida 1","Pestisida 2","Panen"] @endphp
                                @php $katamPalawijaCategories = ["Tanam","Pemupukan 1","Pemupukan 2","Pestisida ","Panen"] @endphp
                                @php $katamCategories[9999] = "Bera" @endphp
                                @php $katamPalawijaCategories[9999] = "Bera" @endphp
                                <tr class="border-b border-opacity-10 border-gray-700">
                                    <td class="text-xs md:text-base py-1 text-center">1-10</td>
                                    <td class="text-xs md:text-base py-1 text-center font-bold">{{ $katamCategories[$longterm->where("hazard_id",2)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value] }}</td>
                                    <td class="text-xs md:text-base py-1 text-center font-bold">{{ $katamPalawijaCategories[$longterm->where("hazard_id",7)->where('dasarian',1)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value] }}</td>
                                </tr>
                                <tr class="border-b border-opacity-10 border-gray-700 bg-gray-100">
                                    <td class="text-xs md:text-base py-1 text-center">11-20</td>
                                    <td class="text-xs md:text-base py-1 text-center font-bold">{{ $katamCategories[$longterm->where("hazard_id",2)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value] }}</td>
                                    <td class="text-xs md:text-base py-1 text-center font-bold">{{ $katamPalawijaCategories[$longterm->where("hazard_id",7)->where('dasarian',2)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value] }}</td>
                                </tr>
                                <tr class="border-b border-opacity-10 border-gray-700">
                                    <td class="text-xs md:text-base py-1 text-center">21-30</td>
                                    <td class="text-xs md:text-base py-1 text-center font-bold">{{ $katamCategories[$longterm->where("hazard_id",2)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value] }}</td>
                                    <td class="text-xs md:text-base py-1 text-center font-bold">{{ $katamPalawijaCategories[$longterm->where("hazard_id",7)->where('dasarian',3)->where('date',\Carbon\Carbon::now()->format("Y-m-01"))->values()[0]->value] }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-end">
                            <a href="#kalender-tanam" class="text-sm my-2 text-green-700 hover:underline hover:underline">Lihat katam</a>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="z-10">
                <div id="weather-chart" style="height:300px;"></div>
            </div>
            <div class="px-4" style="max-width:auto;">                   
                <div>                    
                    <p class="uppercase font-bold">Prediksi Cuaca {{ $location->village }} 7 Hari ke Depan</p>
                    <div class="flex mt-2">
                        <button class="left left-button-daily forecast-container mr-1 border border-opacity-25 shadow-xs bg-green-700 hover:bg-green-600" style="width:25px;">
                            <p class="my-auto text-gray-100 font-bold"><</p>
                        </button>                        
                        <div id="forecast-daily" class="flex grabbable grabbable-daily" style="width:100%;overflow-x: hidden ;">
                            @foreach($daily as $value)
                            @if ($loop->first) @continue @endif
                            <div class="modal-daily-open text-center mx-1 px-1 py-2 border border-opacity-25 shadow-xs bg-green-700 hover:bg-green-600" style="min-width:175px;" onclick="getWeatherTable('{{ \Carbon\Carbon::create($value['date'])->format("Y-m-d")}}')">
                                <div>
                                    <p class="my-auto text-sm text-gray-100">{{ \Carbon\Carbon::create($value['date'])->translatedFormat("j F") }}</p>
                                    <img src="{{ URL::asset('img/' . ($value['rain'] < 1 ? 'day-clear' : 'day-rain') . '.png') }}" class="h-16 mx-auto mt-2">
                                    <p class="my-auto text-sm text-gray-100">{{ ($value['rain'] < 1 ? "Cerah" : ($value['rain'] < 5 ? "Hujan Ringan" : ($value['rain'] < 10 ? "Hujan Sedang" : ($value['rain'] < 20 ? "Hujan Lebat" : "Hujan Sangat Lebat")))) }}</p>
                                    <p class="my-auto text-sm text-gray-100"><span>{{ number_format($value['temperature'], 1,',','.') }}</span><span><sup>o</sup>C</span></p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="right right-button-daily forecast-container ml-1 border border-opacity-25 shadow-xs bg-green-700 hover:bg-green-600" style="width:25px;">
                            <p class="my-auto text-gray-100 font-bold">></p>
                        </button>
                    </div>                   
                </div>
            </div>
    <!--Modal-->
            <div class="modal-daily opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
                <div class="modal-daily-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                    <!-- Add margin if you want to see some of the overlay behind the modal-->
                    <div class="modal-content py-4 text-left px-2">
                        <!--Title-->
                        <div class="flex justify-between items-center pb-3 z-50">
                            <div>
                                <p class="text-xl font-bold uppercase" id="daily-title">Prediksi Cuaca {{ $location->village }}</p>
                                <p class="text-xs font-bold" id="daily-date">-</p>
                            </div>
                            <div class="modal-daily-close cursor-pointer">
                                <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="modal-body custom-scrollbar" style="max-height: 75vh;overflow-y: auto;">
                            <!--Body-->
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="border-b border-opacity-10 border-white bg-orange-500 text-white">
                                        <th class="text-center px-2 py-1">Waktu</th>
                                        <th class="text-center px-2 py-1">Temperatur (<sup>o</sup>C)</th>
                                        <th class="text-center px-2 py-1">Curah Hujan (mm)</th>
                                        <th class="text-center px-2 py-1">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-daily-content">
                                    @foreach($allData as $data)
                                    <tr class='border-b border-orange-500 border-opacity-50'>
                                        <td class='text-center py-1 px-2 hidden'>{{ \Carbon\Carbon::parse($data['date'])->format("Y-m-d H:i") }}</td>
                                        <td class='text-center py-1 px-2'>{{ \Carbon\Carbon::parse($data['date'])->format("H:i") }}</td>
                                        <td class='text-center py-1 px-2'>{{ $data['temperature']-273.15 }}</td>
                                        <td class='text-center py-1 px-2'>{{ $data['rain'] }}</td>
                                        <td class='text-center py-1 px-2'>{{ ($data['rain'] < 1 ? "Cerah" : ($data['rain'] < 5 ? "Hujan Ringan" : ($data['rain'] < 10 ? "Hujan Sedang" : ($data['rain'] < 20 ? "Hujan Lebat" : "Hujan Sangat Lebat") ) ) ) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>              
        </div>
  
        <section class="w-full mx-auto mt-4 md:flex gap-2 px-4">
            <p class="uppercase font-bold">Prediksi Jangka Panjang Tahun</p>
            <select id="filter-year" name="filter-year" class="bg-gray-200 font-bold rounded px-2" onchange="changeHazard()">
                <option value="2023" selected>2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
            </select>
        </section>
        <section id="kalender-tanam" class="w-full mx-auto my-4 px-4">
            <p class="uppercase font-bold my-2">Kalender Tanam Padi {{ $location->village }}</p>
    <!--         <div class="my-2 md:flex gap-4">
                <p class="my-auto"><i class="fa fa-square text-green-500"></i> Tanggal 1-10</p>
                <p class="my-auto"><i class="fa fa-square text-yellow-300"></i> Tanggal 11-20</p>
                <p class="my-auto"><i class="fa fa-square text-orange-500"></i> Tanggal 21-30</p>
            </div> -->
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
        </section>

        <section id="kalender-tanam-palawija" class="w-full mx-auto my-4 px-4">
            <p class="uppercase font-bold my-2">Kalender Tanam Palawija {{ $location->village }}</p>
    <!--         <div class="my-2 md:flex gap-4">
                <p class="my-auto"><i class="fa fa-square text-green-500"></i> Tanggal 1-10</p>
                <p class="my-auto"><i class="fa fa-square text-yellow-300"></i> Tanggal 11-20</p>
                <p class="my-auto"><i class="fa fa-square text-orange-500"></i> Tanggal 21-30</p>
            </div> -->
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
                    <tbody id="table-katam-palawija">
                    </tbody>
                </table>
            </div>
        </section>        
        <section id="kerentanan" class="w-full mx-auto mb-4 mt-2 px-4">
            <p class="uppercase font-bold">Prediksi Iklim {{ $location->village }}</p>
            <div id="chart-climate" style="height:250px;"></div>
        </section>    
        <section class="w-full mx-auto my-4 px-4">
            <p class="uppercase font-bold">Kerentanan Bencana Banjir {{ $location->village }}</p>
            <div id="chart-disaster-1" class="my-2" style="height:250px;"></div>
        </section>
        <section class="w-full mx-auto my-4 px-4">
            <p class="uppercase font-bold">Kerentanan Bencana Kekeringan {{ $location->village }}</p>
            <div id="chart-disaster-2" class="my-2" style="height:250px;"></div>
        </section>
        <section class="w-full mx-auto my-4 px-4">
            <p class="uppercase font-bold">Kerentanan Bencana Longsor {{ $location->village }}</p>
            <div id="chart-disaster-3" class="my-2" style="height:250px;"></div>
        </section>
    </div>           
</div>
@push('scripts')

    <script>
        $(document).ready(function () {
            $('#location-id').select2();
            $('#location-id').on('change', function (e) {
                var data = $('#location-id').select2("val");
            @this.set('searchLocation', data);

            });
        });
    </script>

@endpush