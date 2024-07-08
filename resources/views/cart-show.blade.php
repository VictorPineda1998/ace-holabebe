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
                    <a href="{{ route('hospitalizacion.show', $hospitalizacion_id) }} "
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Detalles de hospitalizacion
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
                    <span class="ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400">
                        Consumo de hospitalizacion
                    </span>
                </div>
            </li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                <div class="container mx-auto px-4">
                    <!-- Materiales -->
                    <div class="titulo-listado flex flex-col items-center mb-3 mt-6">
                        <h1 class='text-2xl font-bold text-purple-800'>Materiales</h1>
                    </div>
                    @foreach ($items as $item)
                        @if ($item['tipo'] == 'material')
                            <div
                                class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300">
                                <div class="mb-2 md:mb-0">
                                    <span class='text-lg font-bold mr-2'>Fecha: {{ $item['fecha'] }}</span>
                                    <h2 class='text-1xl font-bold text-purple-800'>{{ $item['nombre'] }}</h2>
                                </div>
                                <div class="flex items-center">
                                    <form id="materialesForm" method="POST" class="flex items-center"
                                        action="{{ route('cart.update', ['nombre' => $item['id'], 'hospitalizacion_id' => $hospitalizacion_id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <x-label for="cantidadUpdate" value="{{ __('Modificar cantidad') }}" />
                                        <x-input id="materiales{{ $loop->iteration }}" pattern="\d*" class="block ml-2 mr-2 w-20 numeric-input"
                                            required type="number" name="cantidadUpdate" />
                                            <x-boton-mas type="submit">Actualizar</x-boton-mas>
                                    </form>
                                </div>
                                <div class="flex items-center">
                                    <span class='text-lg font-bold mr-2'>Cantidad: {{ $item['cantidad'] }}</span>
                                    <x-input type="hidden" name="cantida" value="{{ $item['cantidad'] }}" />
                                    {{-- <span class='text-lg font-bold'>Precio: ${{ $item['precio'] }}</span> --}}
                                </div>
                            </div>
                            <div id="materiales{{ $loop->iteration }}Error" class="text-red-500 text-center bg-slate-50 m-1"></div>
                        @endif
                    @endforeach

                    <!-- Medicamentos -->
                    <div class="titulo-listado flex flex-col items-center mb-3 mt-6">
                        <h1 class='text-2xl font-bold text-purple-800'>Medicamentos</h1>
                    </div>
                    @foreach ($items as $item)
                        @if ($item['tipo'] == 'medicamento')
                            <div
                                class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300">
                                <div class="mb-2 md:mb-0">
                                    <span class='text-lg font-bold mr-2'>Fecha: {{ $item['fecha'] }}</span>
                                    <h2 class='text-1xl font-bold text-purple-800'>{{ $item['nombre'] }}</h2>
                                </div>
                                <div class="flex items-center">
                                    <form id="medicamentosForm" method="POST" class="flex items-center"
                                        action="{{ route('cart.update', ['nombre' => $item['id'], 'hospitalizacion_id' => $hospitalizacion_id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <x-label for="cantidadUpdate" value="{{ __('Modificar cantidad') }}" />
                                        <x-input id="medicamentos{{ $loop->iteration }}" pattern="\d*" class="block ml-2 mr-2 w-20 numeric-input"
                                            required type="number" name="cantidadUpdate" />
                                            <x-boton-mas type="submit">Actualizar</x-boton-mas>
                                    </form>
                                </div>
                                <div class="flex items-center">
                                    <span class='text-lg font-bold mr-2'>Cantidad: {{ $item['cantidad'] }}</span>
                                    {{-- <span class='text-lg font-bold'>Precio: ${{ $item['precio'] }}</span> --}}
                                </div>
                            </div>
                            <div id="medicamentos{{ $loop->iteration }}Error" class="text-red-500 text-center bg-slate-50 m-1"></div>
                        @endif
                    @endforeach

                    <!-- Enfermeras -->
                    <div class="titulo-listado flex flex-col items-center mb-3 mt-6">
                        <h1 class='text-2xl font-bold text-purple-800'>Enfermeras</h1>
                    </div>
                    @foreach ($items as $item)
                        @if ($item['tipo'] == 'Enfermera')
                            <div
                                class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300">
                                <div class="mb-2 md:mb-0">
                                    <span class='text-lg font-bold mr-2'>Fecha: {{ $item['fecha'] }}</span>
                                    <h2 class='text-1xl font-bold text-purple-800'>{{ $item['nombre'] }} - Turno:
                                        {{ $item['turno'] }}</h2>
                                </div>
                                <div class="flex items-center">
                                    <form id="enfermerasForm" method="POST" class="flex items-center"
                                        action="{{ route('cart.update', ['nombre' => $item['nombre'], 'hospitalizacion_id' => $hospitalizacion_id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <x-label for="cantidadUpdate" value="{{ __('Modificar cantidad') }}" />
                                        <x-input id="enfermeras{{ $loop->iteration }}" pattern="\d*" class="block ml-2 mr-2 w-20 numeric-input"
                                            required type="number" name="cantidadUpdate" />
                                            <x-boton-mas type="submit">Actualizar</x-boton-mas>
                                    </form>
                                </div>
                                <div class="flex items-center">
                                    <span class='text-lg font-bold mr-2'>Cantidad: {{ $item['cantidad'] }}</span>
                                </div>
                            </div>
                            <div id="enfermeras{{ $loop->iteration }}Error" class="text-red-500 text-center bg-slate-50 m-1"></div>
                        @endif
                    @endforeach

                    <!-- Artículos de Hospitalización -->
                    <div class="titulo-listado flex flex-col items-center mb-3 mt-6">
                        <h1 class='text-2xl font-bold text-purple-800'>Artículos de Hospitalización</h1>
                    </div>
                    @foreach ($items as $item)
                        @if ($item['tipo'] == 'articuloHospi')
                            <div
                                class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300">
                                <div class="mb-2 md:mb-0">
                                    <span class='text-lg font-bold mr-2'>Fecha: {{ $item['fecha'] }}</span>
                                    <h2 class='text-1xl font-bold text-purple-800'>{{ $item['nombre'] }}</h2>
                                </div>
                                <div class="flex items-center">
                                    <form id="hospitalizacionForm" method="POST" class="flex items-center"
                                        action="{{ route('cart.update', ['nombre' => $item['nombre'], 'hospitalizacion_id' => $hospitalizacion_id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <x-label for="cantidadUpdate" value="{{ __('Modificar cantidad') }}" />
                                        <x-input id="hospitalizacion{{ $loop->iteration }}" pattern="\d*" class="block ml-2 mr-2 w-20 numeric-input"
                                            required type="number" name="cantidadUpdate" />
                                            <x-boton-mas type="submit">Actualizar</x-boton-mas>
                                    </form>
                                </div>
                                <div class="flex items-center">
                                    <span class='text-lg font-bold mr-2'>Cantidad:
                                        {{ $item['cantidadArticuloHospi'] }}</span>
                                </div>
                            </div>
                            <div id="hospitalizacion{{ $loop->iteration }}Error" class="text-red-500 text-center bg-slate-50 m-1"></div>
                        @endif
                    @endforeach

                    <!-- Honorarios Médicos -->
                    <div class="titulo-listado flex flex-col items-center mb-3 mt-6">
                        <h1 class='text-2xl font-bold text-purple-800'>Honorarios Médicos</h1>
                    </div>
                    @foreach ($items as $item)
                        @if ($item['tipo'] == 'articuloHonorario')
                            <div
                                class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300">
                                <div class="mb-2 md:mb-0">
                                    <span class='text-lg font-bold mr-2'>Fecha: {{ $item['fecha'] }}</span>
                                    <h2 class='text-1xl font-bold text-purple-800'>{{ $item['nombre'] }}</h2>
                                </div>
                                <div class="flex items-center">
                                    <form id="honorariosMedicosForm" method="POST" class="flex items-center"
                                        action="{{ route('cart.update', ['nombre' => $item['nombre'], 'hospitalizacion_id' => $hospitalizacion_id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <x-label for="cantidadUpdate" value="{{ __('Modificar cantidad') }}" />
                                        <x-input id="honorariosMedicos{{ $loop->iteration }}" pattern="\d*" class="block ml-2 mr-2 w-20 numeric-input"
                                            required type="number" name="cantidadUpdate" />
                                            <x-boton-mas type="submit">Actualizar</x-boton-mas>
                                    </form>
                                </div>
                                <div class="flex items-center">
                                    <span class='text-lg font-bold mr-2'>Cantidad:
                                        {{ $item['cantidadArticuloHonorario'] }}</span>
                                </div>
                            </div>
                            <div id="honorariosMedicos{{ $loop->iteration }}Error" class="text-red-500 text-center bg-slate-50 m-1"></div>
                        @endif
                    @endforeach
                    <div class="flex items-center justify-end mt-4">
                        <div class="flex items-center justify-end mt-4">
                            <x-label for="" value="{{ __('Finalizar consumo de hospitalizacion:') }}"
                                class="mr-2" />
                            <a href="{{ route('cart.confirmar', $hospitalizacion_id) }}">
                                <x-boton-mas>{{ 'Aceptar' }}</x-boton-mas>
                            </a>
                        </div>
                    </div>
                </div>
            </x-div-fondo>
        </div>
    </div>
    <script>
        document.querySelectorAll('.numeric-input').forEach(function(input) {
            input.addEventListener('input', function(event) {
                var inputValue = event.target.value;
                var errorSpan = document.getElementById(event.target.id + 'Error');

                if (!/^\d*$/.test(inputValue)) {
                    errorSpan.textContent =
                        "Por favor, ingresa solo números enteros igual o mayor a 0.";
                    event.target.value = inputValue.replace(/\D/g,
                        ''); // Elimina caracteres no numéricos
                } else {
                    errorSpan.textContent = "";
                }
            });
        });
    </script>

</x-app-layout>
