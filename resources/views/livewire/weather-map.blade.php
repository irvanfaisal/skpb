<div wire:init="init">
    <div class="flex flex-col flex-nowrap z-30" style="z-index:999;">
        <div>
            <div class="text-white inline-block bg-black bg-opacity-30 p-4 rounded shadow ">
                <div>
                    <div id="map-weather-select">
                        <div class="mb-1">
                            <div wire:ignore>
                                <!-- <p class="my-auto text-2xl">{{ $location->village }}</p> -->
                                <select class="bg-transparent w-full font-bold text-sm" name="location-id" id="location-id" wire:model.lazy="searchLocation">
                                    @foreach($locations as $locationId)
                                        <option value="{{$locationId->id}}" class="py-2 my-2 text-black text-sm">{{ ucwords(strtolower(str_replace("_"," ",$locationId->village))) }}</option>
                                    @endforeach
                                </select>                                
                                <p id="forecast-date" class="mt-2">{{ \Carbon\Carbon::create($date)->translatedFormat("d F Y H:i") }}</p>
                            </div>
                        </div>
                        <p class="my-auto font-bold text-5xl"><span id="forecast-temperature">{{ number_format($currentForecast->temperature, 1,',','.') }}</span><span><sup>o</sup>C</span></p>
                        <p id="forecast-rain" class="my-auto font-bold text-xl">{{ ($currentForecast->rain < 1 ? "Cerah" : ($currentForecast->rain < 5 ? "Hujan Ringan" : ($currentForecast->rain < 10 ? "Hujan Sedang" : ($currentForecast->rain < 20 ? "Hujan Lebat" : "Hujan Sangat Lebat")))) }}</p>
                        <button class="my-1 modal-daily-open text-white text-sm bg-yellow-500 py-1 px-2 hover:bg-yellow-400 hover:text-black" onclick="getWeatherTable('{{ \Carbon\Carbon::now()->format("Y-m-d")}}')"><i class='bx bx-book-reader'></i> Cuaca Hari Ini</button>
                    </div>
                    <!-- <div><img id="forecast-img" src="{{ asset('img/' . ($currentForecast->rain < 1 ? 'day-clear' : 'day-rain') . '.png') }}" class="img-fluid" style="max-height:200px;"></div> -->
                </div>
            </div>
            <div class="hidden md:block" id="menu-bottom-left" style="max-width:400px;">                   
                <div>                    
                    <p class="uppercase font-bold text-white">Prediksi Cuaca 7 Hari ke Depan</p>
                    <div class="flex mt-2">
                        <button class="left left-button-daily forecast-container mr-1 border border-opacity-25 shadow-xs bg-green-700 rounded-sm bg-opacity-50 hover:bg-green-700" style="width:25px;">
                            <p class="my-auto text-gray-100 font-bold"><</p>
                        </button>                        
                        <div id="forecast-daily" class="flex grabbable grabbable-daily" style="width:100%;overflow-x: hidden ;">
                            @foreach($daily as $value)
                            @if ($loop->first) @continue @endif
                            <div class="modal-daily-open text-center mx-1 px-1 py-2 border border-opacity-25 shadow-xs bg-green-700 rounded-sm bg-opacity-50 hover:bg-green-700" style="min-width:100px;" onclick="getWeatherTable('{{ \Carbon\Carbon::create($value['date'])->format("Y-m-d")}}')">
                                <div>
                                    <p class="my-auto text-sm text-gray-100">{{ \Carbon\Carbon::create($value['date'])->translatedFormat("j F") }}</p>
                                    <img src="{{ URL::asset('img/' . ($value['rain'] < 1 ? 'day-clear' : 'day-rain') . '.png') }}" class="h-8 mx-auto mt-2">
                                    <p class="my-auto text-sm text-gray-100">{{ ($value['rain'] < 1 ? "Cerah" : ($value['rain'] < 5 ? "Hujan Ringan" : ($value['rain'] < 10 ? "Hujan Sedang" : ($value['rain'] < 20 ? "Hujan Lebat" : "Hujan Sangat Lebat")))) }}</p>
                                    <p class="my-auto text-sm text-gray-100"><span>{{ number_format($value['temperature'], 1,',','.') }}</span><span><sup>o</sup>C</span></p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="right right-button-daily forecast-container ml-1 border border-opacity-25 shadow-xs bg-green-700 rounded-sm bg-opacity-50 hover:bg-green-700" style="width:25px;">
                            <p class="my-auto text-gray-100 font-bold">></p>
                        </button>
                    </div>                   
                </div>
            </div>
    <!--Modal-->
            <div class="modal-daily opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center" style="z-index: 9999999;">
                <div class="modal-daily-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg overflow-y-auto h-3/5"  style="z-index: 9999999;">

                    <!-- Add margin if you want to see some of the overlay behind the modal-->
                    <div class="modal-content py-4 text-left px-2">
                        <!--Title-->
                        <div class="flex justify-between items-center pb-3 z-50">
                            <div>
                                <p class="text-xl font-bold uppercase" id="daily-title">Prediksi Cuaca  {{ $location->village }}</p>
                                <p class="text-xs font-bold" id="daily-date">-</p>
                            </div>
                            <div class="modal-daily-close cursor-pointer">
                                <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="modal-body custom-scrollbar">
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