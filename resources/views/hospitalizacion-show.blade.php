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
                    <span class="ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400">
                        Detalles de hospitalizacion
                    </span>
                </div>
            </li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                @if (isset($hospitalizacion->paciente))
                    <div class="titulo-listado flex flex-col items-center">
                        <h1 class='text-4xl font-bold mb-6 text-purple-800'>Detalles del la hospitalizacion</h1>
                    </div>
                    @if (auth()->user()->tipo_usuario != 'Contador')
                        <div class=" flex items-end mt-2 mb-5">
                            <div class="flex items-center mt-3">

                                <h1 class='text-1xl font-bold mb-2 text-purple-800'>Archivos PDF guardados:</h1>
                            </div>
                            <div class="flex items-center ms-3">
                                <a href="{{ route('archivos', $hospitalizacion->paciente->id) }}">
                                    <x-boton-mas>
                                        {{ __('archivos pdf') }}
                                    </x-boton-mas>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="titulo-listado flex flex-col items-left mb-3 mt-6">
                        <h1 class='text-1xl font-bold text-purple-800'>Datos generales del paciente:</h1>
                    </div>
                    <x-paciente.datos-generales :paciente="$hospitalizacion->paciente" />
                    @php
                        $consumo = \App\Models\ConsumoHospital::where(
                            'hospitalizacion_id',
                            $hospitalizacion->id,
                        )->first();
                    @endphp
                    <div>
                        <form id="hospitalizacionForm" method="POST"
                            action="{{ route('hospitalizacion.update', $hospitalizacion->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-7 gap-6 mt-3">
                                <div>
                                    <x-label for="habitacion" value="{{ __('Habitacion') }}" />
                                    <x-input id="habitacion" class="block mt-1 w-full" type="text" name="habitacion"
                                        value="{{ $hospitalizacion->habitacion }}" readonly />
                                </div>
                                <div>
                                    <x-label for="servicio" value="{{ __('Servicio') }}" />
                                    <x-input id="servicio" class="block mt-1 w-full" type="text" name="servicio"
                                        value="{{ $hospitalizacion->servicio }}" readonly />
                                </div>
                                <div>
                                    <x-label for="medico_tratante" value="{{ __('Medico tratante') }}" />
                                    <x-input id="medico_tratante" class="block mt-1 w-full" type="text"
                                        name="medico_tratante" value="{{ $hospitalizacion->medico_tratante }}"
                                        readonly />
                                </div>

                                <div>
                                    <x-label for="procedimiento" value="{{ __('Procedimiento') }}" />
                                    <x-input id="procedimiento" class="block mt-1 w-full" type="text"
                                        name="procedimiento" value="{{ $hospitalizacion->procedimiento }}" readonly />
                                </div>

                                <div>
                                    <x-label for="dietas" value="{{ __('Dietas') }}" />
                                    <x-input id="dietas" class="block mt-1 w-full" type="text" name="dietas"
                                        value="{{ $hospitalizacion->dietas }}" readonly />
                                </div>

                                <div>
                                    <x-label for="fecha_ingreso" value="{{ __('Fecha de ingreso') }}" />
                                    <x-input id="fecha_ingreso" class="block mt-1 w-full" type="date"
                                        name="fecha_ingreso"
                                        value="{{ $hospitalizacion->created_at->format('Y-m-d') }}" readonly />
                                </div>
                                @if ($consumo)
                                    <div>
                                        <x-label for="fecha_alta" value="{{ __('Fecha de alta') }}" />
                                        <x-input id="fecha_alta" class="block mt-1 w-full" type="date"
                                            name="fecha_alta"
                                            value="{{ \Carbon\Carbon::parse($hospitalizacion->fecha_alta)->format('Y-m-d') }}"
                                            readonly />
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <div class=" flex items-end" id="editarHospi">
                                    <div class="flex items-center">
                                        <h1 class='text-1xl font-bold mb-2 text-purple-800'>Editar los datos de la
                                            hospitalizacion:</h1>
                                    </div>
                                    <div class="flex items-center ms-3">
                                        <x-boton-editar>
                                            &nbsp;&nbsp;Editar&nbsp;&nbsp;
                                        </x-boton-editar>
                                    </div>
                                </div>
                                <x-boton-cancelar id="cancelarHospi" class="ms-4" style="display: none;">
                                    {{ __('Cancelar') }}
                                </x-boton-cancelar>

                                <x-boton-mas id="botonActualizarHospi" class="ms-4" style="display: none;">
                                    {{ __('Guardar') }}
                                </x-boton-mas>
                            </div>
                        </form>
                        <div class="flex items-center justify-end mt-4">
                            <div class=" flex items-end">
                                <div class="flex items-center">
                                    <h1 class='text-1xl font-bold mb-2 text-purple-800'>Eliminar hospitalizacion:</h1>
                                </div>
                                <div class="flex items-center ms-3">
                                    <form action="{{ route('hospitalizacion.eliminar', $hospitalizacion->id) }}"
                                        method="POST" id="deleteHospitalizacion" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-boton-eliminar
                                            onclick="event.preventDefault(); openConfirmModal(() => document.getElementById('deleteHospitalizacion').submit(), '¿Estás seguro que deseas eliminar la hospitalizacion de este paciente?', '{{ $hospitalizacion->paciente->nombre }} {{ $hospitalizacion->paciente->apellido_P }} {{ $hospitalizacion->paciente->apellido_M }}');">
                                            Eliminar
                                        </x-boton-eliminar>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @php
                    // Asumiendo que tienes una variable $carrito que contiene el carrito de hospitalización
                    $carrito = \App\Models\Cart::where('hospitalizacion_id', $hospitalizacion->id)->first();
                @endphp
                @if ($carrito && auth()->user()->tipo_usuario != 'Contador')
                    <div class="flex items-center justify-end mt-4">
                        <div class="flex items-center justify-end mt-4">
                            <x-label for="verConsumo" value="{{ __('Consumo total de hospitalizacion:') }}"
                                class="mr-2" />
                            <a href="{{ route('cart.show', $hospitalizacion->id) }}">
                                <x-boton-mas id="verConsumo">{{ 'Ver' }}</x-boton-mas>
                            </a>
                        </div>
                    </div>
                @endif

                @if (!$consumo)
                    @if (auth()->user()->tipo_usuario != 'Contador')
                        <div class="container mx-auto px-4">
                            <!-- Sección de Consumo de Hospitalización -->
                            <div class="text-center my-6">
                                <h1 class='text-2xl font-bold text-purple-800'>Agregar consumo de hospitalización</h1>
                            </div>

                            <!-- Sección de Materiales -->
                            <div class="my-6">
                                <h2 class='text-xl font-bold text-purple-800 text-center mb-4'>Materiales</h2>
                                <div class="flex flex-col lg:flex-row items-center mb-4">
                                    <h3 class='text-lg font-bold text-purple-800 mb-2 lg:mb-0 lg:mr-4'>Buscar en todos
                                        los
                                        registros:</h3>
                                    <form action="{{ route('hospitalizacion.show', $hospitalizacion->id) }}"
                                        method="GET" class="flex items-center">
                                        <input class="border border-gray-300 rounded-md px-4 py-2 mr-2" type="text"
                                            name="searchMateMongoHospitalizacion" placeholder="Material"
                                            value="{{ request()->searchMateMongoHospitalizacion }}">
                                        <x-boton-mas type="submit">Buscar</x-boton-mas>
                                    </form>
                                </div>

                                <!-- Listado de Materiales -->
                                @foreach ($materialesMongoHospitalizacion as $materialMongoHospitalizacion)
                                    <div
                                        class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300 mb-4">
                                        <div class="mb-2 md:mb-0">
                                            <h3 class='text-lg font-bold text-purple-800'>
                                                {{ $materialMongoHospitalizacion->concepto }}</h3>
                                            {{-- <p class='text-md text-purple-800'>
                                                @php
                                                    $fechaMongo1 = $materialMongoHospitalizacion->fecha;
    
                                                    // Verificar si $fechaMongo1 es un objeto UTCDateTime válido
                                                    if ($fechaMongo1 instanceof MongoDB\BSON\UTCDateTime) {
                                                        // Convertir UTCDateTime a DateTime de PHP
                                                        $dateTime1 = $fechaMongo1->toDateTime();
    
                                                        // Formatear la fecha
                                                        $fechaLegible1 = $dateTime1->format('d-m-Y H:i:s');
                                                    } else {
                                                        // Manejar caso donde $fechaMongo1 no es un objeto UTCDateTime válido
                                                        $fechaLegible1 = 'Fecha no válida';
                                                    }
                                                @endphp
                                                {{ $fechaLegible1 }}
                                            </p>
                                            <p class='text-md text-purple-800'>
                                                {{ $materialMongoHospitalizacion->fecha }}
                                            </p> --}}
                                            {{-- <p class='text-md text-purple-800'>{{ $materialMongoHospitalizacion->tipo }}
                                        </p> --}}
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="material_id"
                                                value="{{ $materialMongoHospitalizacion->id }}">
                                            <input type="hidden" name="hospitalizacion_id"
                                                value="{{ $hospitalizacion->id }}">
                                            <input type="number" name="cantidad" value="1" min="1"
                                                class="text-center w-20 border border-gray-300 rounded-md px-2 py-1 mr-2">
                                            <button type="submit" title="Agregar"
                                                class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Añadir
                                                al
                                                consumo</button>
                                        </form>
                                    </div>
                                @endforeach

                                <!-- Paginación de Materiales -->
                                <div class="mt-4">
                                    {{ $materialesMongoHospitalizacion->appends(request()->query())->links() }}
                                </div>
                            </div>


                            <!-- Sección de Medicamentos -->
                            <div class="my-6">
                                <h2 class='text-xl font-bold text-purple-800 text-center mb-4'>Medicamentos</h2>
                                <div class="flex flex-col lg:flex-row items-center mb-4">
                                    <h3 class='text-lg font-bold text-purple-800 mb-2 lg:mb-0 lg:mr-4'>Buscar en todos
                                        los
                                        registros:</h3>
                                    <form action="{{ route('hospitalizacion.show', $hospitalizacion->id) }}"
                                        method="GET" class="flex items-center">
                                        <input class="border border-gray-300 rounded-md px-4 py-2 mr-2" type="text"
                                            name="searchMediMongoHospitalizacion" placeholder="Medicamento"
                                            value="{{ request()->searchMediMongoHospitalizacion }}">
                                        <x-boton-mas type="submit">Buscar</x-boton-mas>
                                    </form>
                                </div>

                                <!-- Listado de Medicamentos -->
                                @foreach ($medicamentosMongoHospitalizacion as $medicamentoMongoHospitalizacion)
                                    <div
                                        class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300 mb-4">
                                        <div class="mb-2 md:mb-0">
                                            <h3 class='text-lg font-bold text-purple-800'>
                                                {{ $medicamentoMongoHospitalizacion->concepto }}</h3>
                                            {{-- <p class='text-md text-purple-800'>
                                            {{ $medicamentoMongoHospitalizacion->tipo }}
                                        </p> --}}
                                            {{-- <p class='text-md text-purple-800'>
                                            @php
                                                $fechaMongo = $medicamentoMongoHospitalizacion->fecha;

                                                // Verificar si $fechaMongo es un objeto UTCDateTime válido
                                                if ($fechaMongo instanceof MongoDB\BSON\UTCDateTime) {
                                                    // Convertir UTCDateTime a DateTime de PHP
                                                    $dateTime = $fechaMongo->toDateTime();

                                                    // Formatear la fecha
                                                    $fechaLegible = $dateTime->format('d-m-Y H:i:s');
                                                } else {
                                                    // Manejar caso donde $fechaMongo no es un objeto UTCDateTime válido
                                                    $fechaLegible = 'Fecha no válida';
                                                }
                                            @endphp
                                            {{ $fechaLegible }}
                                        </p> --}}
                                        </div>
                                        {{-- <p class='text-md text-purple-800'>
                                        {{ $medicamentoMongoHospitalizacion->fecha }}
                                    </p> --}}
                                        <form action="{{ route('cart.add') }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="medicamento_id"
                                                value="{{ $medicamentoMongoHospitalizacion->id }}">
                                            <input type="hidden" name="hospitalizacion_id"
                                                value="{{ $hospitalizacion->id }}">
                                            <input type="number" name="cantidad" value="1" min="1"
                                                class="text-center w-20 border border-gray-300 rounded-md px-2 py-1 mr-2">
                                            <button type="submit" title="Agregar"
                                                class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Añadir
                                                al
                                                consumo</button>
                                        </form>
                                    </div>
                                @endforeach

                                <!-- Paginación de Medicamentos -->
                                <div class="mt-4">
                                    {{ $medicamentosMongoHospitalizacion->appends(request()->query())->links() }}
                                </div>
                            </div>


                            <!-- Sección de Enfermeras de Guardia -->
                            <div class="my-6">
                                <h2 class='text-xl font-bold text-purple-800 text-center mb-4'>Enfermeras de guardia
                                </h2>
                                <form action="{{ route('cart.addEnfermera') }}" method="POST"
                                    class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300 mb-4">
                                    @csrf
                                    <input type="hidden" name="hospitalizacion_id"
                                        value="{{ $hospitalizacion->id }}">
                                    <div class="flex flex-wrap items-center mb-4 md:mb-0">
                                        <x-label for="turnoEnfermera" value="{{ __('Turno de la Enfermera:') }}"
                                            class="mr-2" />
                                        <x-input class="w-full md:w-1/4 mr-2" type="text" name="turnoEnfermera"
                                            autocomplete="turnoEnfermera" required />
                                        <x-label for="nombreEnfermera" value="{{ __('Nombre de la Enfermera:') }}"
                                            class="mr-2 mt-2 md:mt-0" />
                                        <x-input class="w-full md:w-1/4 mr-2" type="text" name="nombreEnfermera"
                                            autocomplete="nombreEnfermera" required />
                                    </div>
                                    <div class="flex items-center">
                                        <input type="number" name="cantidadEnfermera" value="1" min="1"
                                            class="text-center w-20 border border-gray-300 rounded-md px-2 py-1 mr-3">
                                        <button type="submit" title="Agregar"
                                            class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Añadir
                                            al
                                            consumo</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sección de Artículos de Hospitalización -->
                            <div class="my-6">
                                <h2 class='text-xl font-bold text-purple-800 text-center mb-4'>Hospitalización</h2>
                                <form action="{{ route('cart.addArticuloHospi') }}" method="POST"
                                    class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300 mb-4">
                                    @csrf
                                    <input type="hidden" name="hospitalizacion_id"
                                        value="{{ $hospitalizacion->id }}">
                                    <div class="flex flex-wrap items-center mb-4 md:mb-0">
                                        <x-label for="articuloHospi" value="{{ __('Artículo:') }}" class="mr-2" />
                                        <x-input class="w-full md:w-72" type="text" name="articuloHospi"
                                            autocomplete="articuloHospi" required />
                                    </div>
                                    <div class="flex items-center">
                                        <input type="number" name="cantidadArticuloHospi" value="1"
                                            min="1"
                                            class="text-center w-20 border border-gray-300 rounded-md px-2 py-1 mr-3">
                                        <button type="submit" title="Agregar"
                                            class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Añadir
                                            al
                                            consumo</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sección de Honorarios Médicos -->
                            <div class="my-6">
                                <h2 class='text-xl font-bold text-purple-800 text-center mb-4'>Honorarios médicos</h2>
                                <form action="{{ route('cart.addArticuloHonorario') }}" method="POST"
                                    class="flex flex-col md:flex-row justify-between items-center p-4 border-b border-gray-300 mb-4">
                                    @csrf
                                    <input type="hidden" name="hospitalizacion_id"
                                        value="{{ $hospitalizacion->id }}">
                                    <div class="flex flex-wrap items-center mb-4 md:mb-0">
                                        <x-label for="articuloHonorario" value="{{ __('Artículo:') }}"
                                            class="mr-2" />
                                        <x-input class="w-full md:w-72" type="text" name="articuloHonorario"
                                            autocomplete="articuloHonorario" required />
                                    </div>
                                    <div class="flex items-center">
                                        <input type="number" name="cantidadArticuloHonorario" value="1"
                                            min="1"
                                            class="text-center w-20 border border-gray-300 rounded-md px-2 py-1 mr-3">
                                        <button type="submit" title="Agregar"
                                            class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Añadir
                                            al
                                            consumo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center my-6">
                            <h1 class='text-2xl font-bold text-purple-800'>Consumo de hospitalización en proceso</h1>
                        </div>
                    @endif
                @else
                    @php
                        $hoja = \App\Models\HojaHospital::where('hospitalizacion_id', $hospitalizacion->id)->first();
                    @endphp
                    <div class="text-center my-6">
                        <h1 class='text-2xl font-bold text-purple-800'>Consumo de hospitalización Finalizada</h1>
                    </div>
                    <div class="container mx-auto p-4">
                        <form action="{{ route('guardarHojaHospital', $hospitalizacion->id) }}" method="POST">
                            @csrf
                            @foreach (['Materiales' => $materiales, 'Medicamentos' => $medicamentos, 'Enfermeras' => $enfermeras, 'Hospitalizacion' => $hospitalizacionSeccion, 'HonorariosMedicos' => $honorariosMedicos] as $tipo => $items)
                                <div class="mb-6">
                                    <h2 class="text-xl font-bold text-purple-800 mb-2">{{ $tipo }}</h2>
                                    @if (!empty($items))
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Fecha</th>
                                                        @if ($tipo === 'Enfermeras')
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Nombre</th>
                                                        @else
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Articulo</th>
                                                        @endif
                                                        @if ($tipo === 'Enfermeras')
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Turno</th>
                                                        @endif
                                                        @if (auth()->user()->tipo_usuario == 'Contador')
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Precio por unidad</th>
                                                        @endif
                                                        <th
                                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Cantidad</th>
                                                        @if (auth()->user()->tipo_usuario == 'Contador')
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Subtotal</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($items as $item)
                                                        <tr>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $item['fecha'] }}
                                                                {{-- <input type="hidden"
                                                                    name="{{ strtolower($tipo) }}[{{$loop->iteration }}][fecha]"
                                                                    value="{{ $item['fecha'] }}"> --}}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $item['nombre'] }}
                                                                {{-- <input type="hidden"
                                                                    name="{{ strtolower($tipo) }}[{{$loop->iteration }}][nombre]"
                                                                    value="{{ $item['nombre'] }}"> --}}
                                                            </td>
                                                            @if ($tipo === 'Enfermeras')
                                                                <td
                                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $item['turno'] }}
                                                                    {{-- <input type="hidden"
                                                                    name="{{ strtolower($tipo) }}[{{$loop->iteration }}][turno]"
                                                                    value="{{ $item['turno'] }}"> --}}
                                                                </td>
                                                            @endif
                                                            @if (auth()->user()->tipo_usuario == 'Contador')
                                                                <td
                                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    @if ($tipo === 'Materiales' || $tipo === 'Medicamentos')
                                                                        $<input type="number" style="display: none"
                                                                            name="{{ $tipo }}{{ $loop->iteration }}"
                                                                            value="{{ floatval($item['precio']) }}"
                                                                            class="text-center w-24 border border-gray-300 rounded-md px-2 py-1 mr-2">
                                                                        <span
                                                                            id="precio{{ $tipo }}{{ $loop->iteration }}">{{ $item['precio'] }}</span>
                                                                    @else
                                                                        @if ($hoja)
                                                                            $<span>{{ $item['precio'] }}</span>
                                                                            <input type="hidden"
                                                                                name="{{ $tipo }}{{ $loop->iteration }}"
                                                                                value="{{ $item['precio'] }}"
                                                                                min="0" step="0.50"
                                                                                class="text-center w-24 border border-gray-300 rounded-md px-2 py-1 mr-2"
                                                                                oninput="calculateSubtotal('{{ $tipo }}', {{ $loop->iteration }}, {{ $item['cantidad'] ?? ($item['cantidadArticuloHospi'] ?? $item['cantidadArticuloHonorario']) }})">
                                                                        @else
                                                                            $ <input type="number" required
                                                                                name="{{ $tipo }}{{ $loop->iteration }}"
                                                                                value="" min="0"
                                                                                step="0.50"
                                                                                class="text-center w-24 border border-gray-300 rounded-md px-2 py-1 mr-2"
                                                                                oninput="calculateSubtotal('{{ $tipo }}', {{ $loop->iteration }}, {{ $item['cantidad'] ?? ($item['cantidadArticuloHospi'] ?? $item['cantidadArticuloHonorario']) }})">
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $item['cantidad'] ?? ($item['cantidadArticuloHospi'] ?? $item['cantidadArticuloHonorario']) }}
                                                                {{-- <input type="hidden"
                                                                    name="{{ strtolower($tipo) }}[{{$loop->iteration }}][cantidad]"
                                                                    value="{{ $item['cantidad'] ?? ($item['cantidadArticuloHospi'] ?? $item['cantidadArticuloHonorario'])}}"> --}}
                                                            </td>
                                                            @if (auth()->user()->tipo_usuario == 'Contador')
                                                                <td
                                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    $<span
                                                                        id="subtotal{{ $tipo }}{{ $loop->iteration }}">0.00</span>
                                                                    {{-- <input type="hidden" id="subIn{{ $tipo }}{{ $loop->iteration }}"
                                                                    name="{{ strtolower($tipo) }}[{{$loop->iteration }}][subtotal]"
                                                                    value=""> --}}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p>No hay {{ strtolower($tipo) }} registrados.</p>
                                    @endif
                                </div>
                            @endforeach
                            @if (auth()->user()->tipo_usuario == 'Contador')
                                <div class="mt-6 text-right">
                                    <div class="text-xl font-bold text-purple-800 bg-indigo-50 p-3 rounded-lg">Total:
                                        $<span id="total">0.00</span>
                                        {{-- <input type="hidden" id="totalInput"
                                                                    name="total"
                                                                    value=""> --}}
                                    </div>
                                    @if (!$hoja)
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md mt-3">Guardar</button>
                                    @endif

                                </div>
                            @endif
                        </form>
                    </div>
                @endif

            </x-div-fondo>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = ['Materiales', 'Medicamentos', 'Enfermeras', 'Hospitalizacion', 'HonorariosMedicos'];
            items.forEach(tipo => {
                document.querySelectorAll(`input[name^="${tipo}"]`).forEach((input, index) => {
                    if (tipo == 'Enfermeras') {
                        const cantidad = parseFloat(input.closest('tr').children[4].innerText);
                        calculateSubtotal(tipo, index + 1, cantidad);
                    } else {
                        const cantidad = parseFloat(input.closest('tr').children[3].innerText);
                        calculateSubtotal(tipo, index + 1, cantidad);
                    }
                });
            });
        });

        function calculateSubtotal(tipo, iteration, cantidad) {
            const precioInput = document.querySelector(`input[name="${tipo}${iteration}"]`);
            const precio = parseFloat(precioInput.value);
            const subtotal = precio * cantidad;

            document.getElementById(`subtotal${tipo}${iteration}`).innerText = subtotal.toFixed(2);
            // document.getElementById(`subIn${tipo}${iteration}`).value = subtotal.toFixed(2);

            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const subtotals = document.querySelectorAll('[id^="subtotal"]');

            subtotals.forEach(subtotal => {
                total += parseFloat(subtotal.innerText);
            });

            document.getElementById('total').innerText = total.toFixed(2);
            // document.getElementById('totalInput').value = total.toFixed(2);
        }

        let botonActualizarHospi = document.getElementById('botonActualizarHospi');
        if (botonActualizarHospi) {
            botonActualizarHospi.addEventListener('click', function() {

                // event.preventDefault();
                document.getElementById('hospitalizacionForm').submit();

            });
        }

        let editarHospi = document.getElementById('editarHospi');
        if (editarHospi) {
            editarHospi.addEventListener('click', function() {
                // Habilitar la edición de los campos
                document.querySelectorAll('#hospitalizacionForm input').forEach(function(input) {
                    input.removeAttribute('readonly');
                });
                // Mostrar el botón de guardar y ocultar el botón de editar
                document.getElementById('botonActualizarHospi').style.display = 'inline';
                document.getElementById('cancelarHospi').style.display = 'inline';
                this.style.display = 'none';
            });
        }

        let cancelarHospi = document.getElementById('cancelarHospi');
        if (cancelarHospi) {
            cancelarHospi.addEventListener('click', function() {
                location.reload();
            });
        }
    </script>

</x-app-layout>
