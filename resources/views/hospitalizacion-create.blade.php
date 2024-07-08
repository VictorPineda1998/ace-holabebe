<x-app-layout>
    <x-slot name="header">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ route('hospitalizacion') }} "
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Hospitalizacion
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span
                        class="ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Registrar hospitalizacion
                    </span>
                </div>
            </li>
        </ol>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                <x-validation-errors />
            <x-authentication-card>
                <x-slot name="logo">
                    {{-- <x-authentication-card-logo /> --}}
                </x-slot>
                <div class="container mx-auto p-4">
                    <h1 class="text-2xl font-bold mb-2">Hospitalizacion para el paciente:</h1>
                    <h1 class="text-1xl font-semibold text-center mb-2">{{ $paciente->nombre }} {{ $paciente->apellido_P }} {{ $paciente->apellido_M }}</h1>
                <div>            
                <form method="POST" action="{{ route('hospitalizacion.store', $paciente->id) }}">
                    @csrf
                    <div class="mt-4">
                        <x-label for="habitacion" value="{{ __('Habitacion') }}" />
                        <x-input id="habitacion" class="block mt-1 w-full" type="text" name="habitacion"
                            :value="old('habitacion')" required autofocus autocomplete="habitacion" />
                    </div>
                    <div class="mt-4">
                        <x-label for="servicio" value="{{ __('Servicio') }}" />
                        <x-input id="servicio" class="block mt-1 w-full" type="text" name="servicio"
                            :value="old('servicio')" required autofocus autocomplete="servicio" />
                    </div>
                    <div class="mt-4">
                        <x-label for="procedimiento" value="{{ __('Procedimiento') }}" />
                        <x-input id="procedimiento" class="block mt-1 w-full" type="text" name="procedimiento"
                            :value="old('procedimiento')" required autofocus autocomplete="procedimiento" />
                    </div>

                    <div class="mt-4">
                        <x-label for="medico_tratante" value="{{ __('Medico tratante') }}" />
                        <x-input id="medico_tratante" class="block mt-1 w-full" type="text" name="medico_tratante"
                            :value="old('medico_tratante')" required autocomplete="medico_tratante" />
                    </div>

                    <div class="mt-4">
                        <x-label for="dietas" value="{{ __('Dietas') }}" />
                        <x-input id="dietas" class="block mt-1 w-full" type="text" name="dietas"
                            required autocomplete="dietas" :value="old('dietas')" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <a href="{{ route('hospitalizacion')}}">
                            <x-boton-cancelar class="ms-4">
                                {{ __('Cancelar') }}
                            </x-boton-cancelar>
                        </a>

                        <x-button class="ms-4">
                            {{ __('Registrar') }}
                        </x-button>
                    </div>
                </form>
            </x-div-fondo>
        </div>
    </div>
</x-authentication-card>
</x-app-layout>
