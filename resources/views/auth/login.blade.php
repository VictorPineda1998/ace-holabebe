<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img class="h-15 w-15 rounded-full object-cover"
                src="{{ asset('img-empresa/logo-hola-bebe.jpg') }}"alt="logo">
        </x-slot>
        @if (DB::table('users')->count() === 0)
            <div class="titulo-listado flex flex-col items-center">
                <h1 class='text-1xl font-bold mb-6 text-black-800'>BIENVENIDO AL SISTEMA:</h1>
                <h1 class='text-1xl font-bold mb-6 text-black-800'> ARCHIVO CLINICO ELECTRONICO</h1>
            
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-900 hover:text-blue-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                <x-boton-mas> Registrece como primer usuario administrador</x-boton-mas>
            </a>
            
        </div>
        @else
            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>

                {{-- <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div> --}}

                <div class="flex items-center justify-end mt-4">
                    {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        @endif
    </x-authentication-card>
</x-guest-layout>
