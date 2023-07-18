@extends('layouts.master')
@section('content')
    @include('layouts.header')

<main>

    <section class="bg-main px-4 pt-24 pb-10">
        <div class="md:w-5/6 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="col-span-2 pr-4">
                    <h1 class="block font-bold text-2xl md:text-5xl uppercase text-yellow-400"><span>Sistem Kesiapsiagaan</span><br><span>Pertanian dan Bencana</span><br><span>(SKPB)</span></h1>
                    <p class="my-4 text-white font-bold uppercase text-2xl md:text-4xl">Kabupaten Lombok Tengah</p>
                    <div class="inline-flex my-auto text-center mx-auto gap-2 md:gap-5 bg-white p-2 bg-opacity-50">
                        <img src="{{ asset('img/logo-1.png') }}" class="h-8 md:h-20">
                        <img src="{{ asset('img/logo-wn.png') }}" class="h-8 md:h-20">
                        <img src="{{ asset('img/logo-usaid.png') }}" class="h-8 md:h-20">
                    </div>
                </div>
                <div class="hidden md:inline-flex my-auto text-center mx-auto">
                    <img src="{{ asset('img/logo-skpb.png') }}" class="mx-2 max-h-60">
                </div>                
            </div>
        </div>
    </section>
    <section class="py-8 px-4">
        <div class="md:w-4/5 mx-auto text-center my-4">
            <p class="my-auto text-black uppercase font-bold text-2xl my-5">Fitur</p>        
        </div>
        <div class="md:w-3/5 z-30 grid grid-cols-1 md:grid-cols-3 gap-4 mx-auto">
            <div class="mx-1 px-1 py-1 text-white grow h-full">
                <div class="main-feature flex flex-col group grow h-full">
                    <hr class="main-feature-border">
                    <div class="group p-4 text-white hover:bg-yellow-400 bg-green-700 shadow main-feature-container h-full flex flex-col">
                        <div>
                            <i class="mb-1 group-hover:text-black text-yellow-500 bx bxs-cloud fa-2x"></i>
                            <p class="my-auto fw-bold">Prediksi Cuaca</p>
                        </div>
                        <div>
                            <div class="divide-y divide-gray-900 divide-opacity-25 flex flex-col h-full main-feature-detail place-content-between">
                                <div class="my-4">
                                    <p class="text-sm">
                                        Prediksi cuaca tiap jam hingga 7 Hari ke depan
                                    </p>
                                </div>
                                <div class="mt-auto main-feature-link" style="opacity:0;">
                                    
                                    <a href="{{ url('cuaca') }}" class="my-auto mt-2 text-sm flex text-dark justify-content-between align-items-center">
                                        <span>
                                            Info Lanjut
                                        </span>
                                        <span data-feather="arrow-right" class="feather-16"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-1 px-1 py-1 text-white grow h-full">
                <div class="main-feature flex flex-col group grow h-full">
                    <hr class="main-feature-border">
                    <div class="group p-4 text-white hover:bg-yellow-400 bg-green-700 shadow main-feature-container h-full flex flex-col">
                        <div>
                            <i class="mb-1 group-hover:text-black text-yellow-500 bx bxs-cloud-rain fa-2x"></i>
                            <p class="my-auto fw-bold">Prediksi Iklim</p>
                        </div>
                        <div>
                            <div class="divide-y divide-gray-900 divide-opacity-25 flex flex-col h-full main-feature-detail place-content-between">
                                <div class="my-4">
                                    <p class="text-sm">
                                        Prediksi curah hujan jangka panjang tiap dasarian
                                    </p>
                                </div>
                                <div class="mt-auto main-feature-link" style="opacity:0;">
                                    
                                    <a href="{{ url('iklim') }}" class="my-auto mt-2 text-sm flex text-dark justify-content-between align-items-center">
                                        <span>
                                            Info Lanjut
                                        </span>
                                        <span data-feather="arrow-right" class="feather-16"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-1 px-1 py-1 text-white grow h-full">
                <div class="main-feature flex flex-col group grow h-full">
                    <hr class="main-feature-border">
                    <div class="group p-4 text-white hover:bg-yellow-400 bg-green-700 shadow main-feature-container h-full flex flex-col">
                        <div>
                            <i class="mb-1 group-hover:text-black text-yellow-500 bx bxs-calendar fa-2x"></i>
                            <p class="my-auto fw-bold">Kalender Tanam Padi</p>
                        </div>
                        <div >
                            <div class="divide-y divide-gray-900 divide-opacity-25 flex flex-col h-full main-feature-detail place-content-between">
                                <div class="my-4">                                  
                                    <!-- <img class="group-hover:block hidden" src="{{URL::asset('img/agriculture-4.jpg')}}" />           -->
                                    <p class="text-sm">
                                        Rekomendasi penentuan jadwal tanam untuk tanaman padi
                                    </p>
                                </div>
                                <div class="mt-auto main-feature-link" style="opacity:0;">
                                    
                                    <a href="{{ url('katam') }}" class="my-auto mt-2 text-sm flex text-dark justify-content-between align-items-center">
                                        <span>
                                            Info Lanjut
                                        </span>
                                        <span data-feather="arrow-right" class="feather-16"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-1 px-1 py-1 text-white grow h-full">
                <div class="main-feature flex flex-col group grow h-full">
                    <hr class="main-feature-border">
                    <div class="group p-4 text-white hover:bg-yellow-400 bg-green-700 shadow main-feature-container h-full flex flex-col">
                        <div>
                            <i class="mb-1 group-hover:text-black text-yellow-500 bx bxs-calendar-alt fa-2x"></i>
                            <p class="my-auto fw-bold">Kalender Tanam Palawija</p>
                        </div>
                        <div >
                            <div class="divide-y divide-gray-900 divide-opacity-25 flex flex-col h-full main-feature-detail place-content-between">
                                <div class="my-4">                                  
                                    <!-- <img class="group-hover:block hidden" src="{{URL::asset('img/agriculture-4.jpg')}}" />           -->
                                    <p class="text-sm">
                                        Rekomendasi penentuan jadwal tanam untuk tanaman palawija
                                    </p>
                                </div>
                                <div class="mt-auto main-feature-link" style="opacity:0;">
                                    
                                    <a href="{{ url('katamPalawija') }}" class="my-auto mt-2 text-sm flex text-dark justify-content-between align-items-center">
                                        <span>
                                            Info Lanjut
                                        </span>
                                        <span data-feather="arrow-right" class="feather-16"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-1 px-1 py-1 text-white grow h-full">
                <div class="main-feature flex flex-col group grow h-full">
                    <hr class="main-feature-border">
                    <div class="group p-4 text-white hover:bg-yellow-400 bg-green-700 shadow main-feature-container h-full flex flex-col">
                        <div>
                            <i class="mb-1 group-hover:text-black text-yellow-500 bx bxs-alarm-exclamation fa-2x"></i>
                            <p class="my-auto fw-bold">Kerentanan Bencana</p>
                        </div>
                        <div>
                            <div class="divide-y divide-gray-900 divide-opacity-25 flex flex-col h-full main-feature-detail place-content-between">
                                <div class="my-4">
                                    <p class="text-sm">
                                        Prediksi kerentanan banjir, kekeringan, dan longsor
                                    </p>
                                </div>
                                <div class="mt-auto main-feature-link" style="opacity:0;">
                                    
                                    <a href="{{ url('prediksi') }}" class="my-auto mt-2 text-sm flex text-dark justify-content-between align-items-center">
                                        <span>
                                            Info Lanjut
                                        </span>
                                        <span data-feather="arrow-right" class="feather-16"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-1 px-1 py-1 text-white grow h-full">
                <div class="main-feature flex flex-col group grow h-full">
                    <hr class="main-feature-border">
                    <div class="group p-4 text-white hover:bg-yellow-400 bg-green-700 shadow main-feature-container h-full flex flex-col">
                        <div>
                            <i class="mb-1 group-hover:text-black text-yellow-500 bx bxs-bug fa-2x"></i>
                            <p class="my-auto fw-bold">Kerentanan Hama</p>
                        </div>
                        <div>
                            <div class="divide-y divide-gray-900 divide-opacity-25 flex flex-col h-full main-feature-detail place-content-between">
                                <div class="my-4">
                                    <p class="text-sm">
                                        Prediksi kerentanan hama
                                    </p>
                                </div>
                                <div class="mt-auto main-feature-link" style="opacity:0;">
                                    
                                    <a href="{{ url('hama') }}" class="my-auto mt-2 text-sm flex text-dark justify-content-between align-items-center">
                                        <span>
                                            Info Lanjut
                                        </span>
                                        <span data-feather="arrow-right" class="feather-16"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>       
    <section class="px-4 py-10">
        <div class="md:w-5/6 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div class="pr-4 md:w-4/5 text-center mx-auto">
                    <h2 class="font-bold text-2xl text-green-600 uppercase">Tentang SKPB</h2>
                    <hr class="my-2">  
                    <p class="text-gray-900"><span class="font-bold">Sistem Kesiapsiagaan Pertanian dan Bencana (SKPB)</span> dibangun menggunakan teknologi <span class="font-bold">prediksi iklim</span> untuk curah hujan dan cuaca dengan <span class="font-bold">akurasi tinggi</span>, dilengkapi dukungan data satelit dan data lapangan untuk menghasilkan <span class="font-bold">Kalender Tanam</span> dan <span class="font-bold">Potensi Bahaya Bencana</span> yang lebih aman dan terkontrol.</p>
                </div>
                <div>
                    <video autoplay loop muted class="mr-2">
                    <source src="{{URL::asset('video/sica.mkv')}}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </section>
</main>




@endsection

@section('js')
    <script type="text/javascript">
// grab everything we need
const btn = document.querySelector("button.mobile-menu-button");
const menu = document.querySelector(".mobile-menu");

// add event listeners
btn.addEventListener("click", () => {
  menu.classList.toggle("hidden");
});


    var scrollpos = window.scrollY;
    var header = document.getElementById("navbar");

    function add_class_on_scroll() {
        header.classList.remove("md:bg-transparent");
        header.classList.add("shadow-sm");
        header.classList.add("text-grey-200");
    }

    function remove_class_on_scroll() {
        header.classList.remove("text-grey-200");
        header.classList.add("md:bg-transparent");
        header.classList.remove("shadow-sm");
    }

    window.addEventListener('scroll', function(){ 
        //Here you forgot to update the value
        scrollpos = window.scrollY;

        if(scrollpos > 10){
            add_class_on_scroll();
        }
        else {
            remove_class_on_scroll();
        }
    });
        
    </script>
@endsection