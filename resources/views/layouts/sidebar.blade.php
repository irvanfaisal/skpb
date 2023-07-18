    <div class="hidden sidebar bg-gray-100 open md:flex flex-col">
        <div class="logo-details">
            <a onclick="leavingAnimation();" href="{{ url('') }}" class="flex">
                <img src="{{ asset('img/logo-1.png') }}" class="icon mr-2" style="max-height:40px;">
                <div class="logo_name my-auto">SKPB</div>
            </a>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <div>
                <li id="menu-weather">
                    <a onclick="leavingAnimation();" href="{{ url('cuaca') }}">
                        <i class='text-gray-900 bx bx-cloud'></i>
                        <span class="links_name">Prediksi Cuaca</span>
                    </a>
                    <span class="tooltip">Prediksi Cuaca</span>
                </li>
                <li id="menu-iklim">
                    <a onclick="leavingAnimation();" href="{{ url('iklim') }}">
                        <i class='text-gray-900 bx bx-cloud-rain'></i>
                        <span class="links_name">Prediksi Iklim</span>
                    </a>
                    <span class="tooltip">Prediksi Iklim</span>
                </li>
                <li id="menu-prediksi">
                    <a onclick="leavingAnimation();" href="{{ url('prediksi') }}">
                        <i class='text-gray-900 bx bx-alarm-exclamation'></i>
                        <span class="links_name">Kerentanan Bencana</span>
                    </a>
                    <span class="tooltip">Kerentanan Bencana</span>
                </li>
                <li id="menu-hama">
                    <a onclick="leavingAnimation();" href="{{ url('hama') }}">
                        <i class='text-gray-900 bx bx-bug'></i>
                        <span class="links_name">Kerentanan Hama</span>
                    </a>
                    <span class="tooltip">Kerentanan Hama</span>
                </li>
                <li id="menu-katam">
                    <a onclick="leavingAnimation();" href="{{ url('katam') }}">
                        <i class='text-gray-900 bx bx-calendar'></i>
                        <span class="links_name">Kalender Tanam Padi</span>
                    </a>
                    <span class="tooltip">Kalender Tanam Padi</span>
                </li>
                <li id="menu-katam-palawija">
                    <a onclick="leavingAnimation();" href="{{ url('katamPalawija') }}">
                        <i class='text-gray-900 bx bx-calendar-alt'></i>
                        <span class="links_name">Kalender Tanam Palajiwa</span>
                    </a>
                    <span class="tooltip">Kalender Tanam Palawija</span>
                </li>
                <li id="menu-forecast">
                    <a onclick="leavingAnimation();" href="{{ url('forecast') }}">
                        <i class='text-gray-900 bx bx-chart'></i>
                        <span class="links_name">Rangkuman Informasi</span>
                    </a>
                    <span class="tooltip">Rangkuman Informasi</span>
                </li>
            </div>
        </ul>
        <div id="logo-footer" class="mt-auto flex gap-2 mx-auto my-2">
            <img src="{{ asset('img/logo-wn.png') }}" class="icon mr-2" style="max-height:30px;">
            <img src="{{ asset('img/logo-usaid.png') }}" class="icon mr-2" style="max-height:30px;">
        </div>
    </div>
    <nav id="navbar" class="z-50 w-full fixed md:hidden text-gray-100 transition-all bg-green-800 md:bg-transparent">

      <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">
          <div class="flex space-x-4">
            <div>
              <a href="{{ url('') }}" class="flex items-center py-3 px-2 gap-3">
                <img src="{{ URL::asset('img/logo-1.png') }}" style="max-height: 30px;">
                <img class="hidden md:block" src="{{ URL::asset('img/logo-2.png') }}" style="max-height: 30px;">
                <span class="hidden md:block font-bold text-xl text-white uppercase">Dinas Pertanian dan Perkebunan<br>Kabupaten Lombok Tengah</span>
                <span class="md:hidden font-bold text-xl text-white uppercase">SKPB</span>
              </a>
            </div>
          </div>
          <div class="hidden md:flex items-center">
            <div class="items-center">
              <a href="{{ url('') }}" class="bg-yellow-400 py-2 px-5 text-sm rounded-full md:hover:bg-opacity-100  bg-opacity-90 text-gray-900 hover:text-gray-900">Beranda</a>
              <a href="{{ url('forecast') }}" class="bg-red-600 py-2 mx-2 px-5 text-sm rounded-full md:hover:bg-opacity-100 bg-opacity-90 hover:text-gray-900">Rangkuman Informasi</a>
              <a href="{{ url('cuaca') }}" class="bg-green-600 py-2 px-5 text-sm rounded-full md:hover:bg-opacity-100 bg-opacity-90 hover:text-gray-900">Peta Prediksi Cuaca</a>
            </div>
          </div>

          <!-- mobile buttons -->
          <div class="md:hidden flex items-center">
            <button class="mobile-menu-button text-gray-100">
              <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
          <!-- /mobile buttons -->

        </div>
      </div>

      <!-- mobile menu -->
      <div class="mobile-menu bg-gray-100 hidden">
        <a href="{{ url('') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Beranda</a>
        <a href="{{ url('cuaca') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Peta Prediksi Cuaca</a>
        <a href="{{ url('iklim') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Prediksi Iklim</a>
        <a href="{{ url('prediksi') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Kerentanan Bencana</a>
        <a href="{{ url('hama') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Kerentanan Hama</a>
        <a href="{{ url('katam') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Kalender Tanam Padi</a>
        <a href="{{ url('katam') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Kalender Tanam Palawija</a>
        <a href="{{ url('forecast') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Rangkuman Informasi</a>
      </div>
      <!-- /mobile menu -->

    </nav>

