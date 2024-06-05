@php
    $user = auth()->user()->name;
@endphp

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<style>
    .swiper-container {
        width: 100%;
        height: 100%;
    }
</style>

<div class="-mt-10 text-center py-8 bg-gradient-to-r from-pink-200 via-blue-200 to-purple-200">
    <p class="text-xl font-bold text-gray-600 mt-1">Hola, {{ $user }}.</p>
    <h1 class="mt-2 text-5xl font-bold text-gray-800">¡Bienvenido(a) a HolaBebé!</h1>
    <p class="text-xl font-bold text-gray-600 mt-1">Archivo Clinco Electronico.</p>
    <p class="text-xl text-gray-600 mt-2">Centro de Atención Integral del Embarazo</p>
</div>

<div class="swiper-container my-8">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="{{ asset('img-empresa/img-1.jpg') }}" alt="First slide"
                class="w-full h-64 object-cover rounded-lg shadow-2xl transition-transform duration-500 hover:scale-105" />
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('img-empresa/img-2.jpg') }}" alt="Second slide"
                class="w-full h-64 object-cover rounded-lg shadow-2xl transition-transform duration-500 hover:scale-105" />
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('img-empresa/img-3.jpg') }}" alt="Third slide"
                class="w-full h-64 object-cover rounded-lg shadow-2xl transition-transform duration-500 hover:scale-105" />
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('img-empresa/img-4.jpg') }}" alt="Third slide"
                class="w-full h-64 object-cover rounded-lg shadow-2xl transition-transform duration-500 hover:scale-105" />
        </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        effect: 'fade',
    });
</script>

