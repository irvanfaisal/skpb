@extends('layouts.master')
@section('content')
@include('layouts.header')
<main id="main-container">
    <section id="home" class="menu-navigation-content min-h-screen w-100 overflow-x-hidden flex flex-col flex-grow">
        <div class="text-center my-auto">
            <img src="{{ asset('img/logo.png') }}" class="h-20 mx-auto my-2">
            <hr class="my-2 w-1/5 mx-auto">
            <p class="text-4xl uppercase font-bold mx-auto mt-2 mb-5">Sistem Informasi Cerdas Agribisnis</p>
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif            
            <form class="md:w-1/5 mx-auto border shadow border-zinc-900 bg-white px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="uppercase block text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input class="text-center bg-transparent appearance-none rounded w-full py-2 px-3 border border-zinc-900 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username" name="username">
                </div>
                <div class="mb-2">
                    <label class="uppercase block text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="text-center bg-transparent appearance-none rounded w-full py-2 px-3 border border-zinc-900 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="******************">
                </div>
                <div class="flex">
                <button class="mx-auto bg-green-800 text-white hover:bg-green-700 font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="submit">
                    Sign In
                </button>
                </div>
            </form>
        </div>
    </section>    

</main>
@endsection

@section('js')
<script type="text/javascript">
    
    document.getElementById("navbar").classList.add("bg-green-800");
    document.getElementById("navbar").classList.remove("md:bg-transparent");
    document.getElementById("navbar").classList.add("bg-opacity-100");
</script>
@endsection