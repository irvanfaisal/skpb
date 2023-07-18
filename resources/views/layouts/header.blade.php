<nav id="navbar" class="z-50 fixed w-full text-gray-100 transition-all bg-green-800 md:bg-transparent">

  <div class="max-w-6xl mx-auto px-4">
    <div class="flex justify-between">
      <div class="flex space-x-4">
        <div>
          <a href="{{ url('') }}" class="flex items-center py-3 px-2 gap-3">
            <img src="{{ URL::asset('img/logo-1.png') }}" style="max-height: 50px;">
            <img class="hidden md:block" src="{{ URL::asset('img/logo-2.png') }}" style="max-height: 50px;">
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
        <a href="{{ url('prediksi') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Kerentanan Bencana</a>
        <a href="{{ url('katam') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Kalender Tanam</a>
        <a href="{{ url('forecast') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 text-gray-800 border-t border-gray-200">Rangkuman Informasi</a>
  </div>
  <!-- /mobile menu -->

</nav>

