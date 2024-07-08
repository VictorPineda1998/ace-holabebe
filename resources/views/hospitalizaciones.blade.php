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
                    <span
                        class="ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Hospitalizacion
                    </span>
                </div>
            </li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                <x-validation-errors />
                <x-boton-editar id="agregar_hospitalizacion" class="justify-end mt-2 mb-2">
                    {{ __('Agregar hospitalizacion') }}
                </x-boton-editar>

                <div id="listPacientes" class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="display: none">
                    @if (isset($pacientes))
                        <x-lista-pacientes :pacientes="$pacientes" />
                    @endif
                </div>
                <div>
                    <div class="titulo-listado flex flex-col items-center">
                        <h1 class='text-3xl font-bold mb-6 text-purple-400'>Hospitalizaciones</h1>
                    </div>
                    <div>
                        <div>
                            <ul class="overflow-x-auto">
                                <div class="w-full lg:w-[950px]" >                                    
                                    <ul class="hidden lg:flex items-center bg-purple-500 p-3 rounded-t-lg">
                                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                                        <span class="w-3/12 text-sm lg:text-base">Nombre(s)</span>
                                        <span class="w-2/12 text-sm lg:text-base">Apellido Paterno</span>
                                        <span class="w-2/12 text-sm lg:text-base">Apellido Materno</span>
                                        <span class="w-2/12 text-sm lg:text-base">Servicio</span>
                                        <span class="w-2/12 text-sm lg:text-base">Fehca de ingreso</span>                                        
                                        <span class="w-1/12 text-sm lg:text-base">Opciones</span>
                                    </ul>
                                    @foreach ($hospitalizaciones as $hospitalizacion)                                       
                                        <li
                                            class="rounded-lg flex flex-col lg:flex-row items-start lg:items-center border-b py-2 {{ $loop->odd ? 'bg-purple-300' : 'bg-purple-200' }} p-4 lg:p-2 mb-4 lg:mb-0 lg:rounded-none">
                                            <div class="flex w-full lg:w-auto mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden">ID: </span>
                                                <span class="text-center ms-1 lg:text-base lg:mr-2">{{ $hospitalizacion->id }}</span>
                                            </div>
                                            <div class="flex w-full lg:w-3/12 mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden">Nombre(s): </span>
                                                <span class="text-center ms-1 lg:text-base">{{ $hospitalizacion->paciente->nombre }}</span>
                                            </div>
                                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden">Apellido Paterno: </span>
                                                <span class="text-center ms-1 lg:text-base">{{ $hospitalizacion->paciente->apellido_P }}</span>
                                            </div>
                                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden">Apellido Materno: </span>
                                                <span class="text-center ms-1 lg:text-base"> {{ $hospitalizacion->paciente->apellido_M }}</span>
                                            </div>
                                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden">Servicio: </span>
                                                <span class="text-center ms-1 lg:text-base">{{ $hospitalizacion->servicio }}</span>
                                            </div>
                                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden">Fehca de ingreso: </span>
                                                <span class="text-center ms-1 lg:text-base">{{ $hospitalizacion->created_at->format('d/m/y') }}</span>
                                            </div>
                                            <div class="flex w-full lg:w-1/12 mb-2 lg:mb-0">
                                                <span class="font-bold lg:hidden me-2">Opciones: </span>                                               
                                                    <a href="{{ route('hospitalizacion.show', $hospitalizacion->id) }} ">
                                                        <x-boton-editar class="boton-editar" style="margin: 0; display: inline;">
                                                            Ver
                                                        </x-boton-editar>
                                                    </a>                                               
                                            </div> 
                                        </li>
                                    @endforeach
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </x-div-fondo>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>

    <script>
         let mostrando = false;
        document.getElementById('agregar_hospitalizacion').addEventListener('click', function() {
            if (!mostrando) {

                document.getElementById('listPacientes').style.display = 'inline';
                deslizar('agregar_hospitalizacion');
                mostrando = true;
            } else {
                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById('listPacientes').style.display = 'none';
                }, 300);
                mostrando = false;
            }
            document.getElementById('cancelar').addEventListener('click', function() {
                deslizar('inicio');
                setTimeout(function() {
                    document.getElementById('listPacientes').style.display = 'none';
                }, 300);
                mostrando = false;
            });
        });
    </script>
</x-app-layout>
