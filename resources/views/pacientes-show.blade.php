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
                    <a href="{{ route('pacientes') }} "
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">                        
                        Pacientes
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
                        Detalles del pacientes
                    </span>
                </div>
            </li>           
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-rose-200 overflow-hidden shadow-xl sm:rounded-lg p-6">                
                @if (isset($paciente))
                    <div class="titulo-listado flex flex-col items-center">
                        <h1 class='text-4xl font-bold mb-6 text-indigo-800'>Detalles del paciente</h1>
                    </div>
                    <div class=" flex items-end mt-2 mb-5">
                        <div class="flex items-center mt-3">
                            <h1 class='text-1xl font-bold mb-2 text-purple-800'>Archivos PDF guardados:</h1>
                        </div>
                        <div class="flex items-center ms-3">
                            <a href="{{ route('archivos', $paciente->id) }}">
                                <x-boton-mas>
                                    {{ __('archivos pdf') }}
                                </x-boton-mas>
                            </a>
                        </div>
                    </div>

                    <div class="titulo-listado flex flex-col items-left">
                        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Datos generales:</h1>
                    </div>

                    <x-paciente.datos-generales :paciente="$paciente" />
                    <div class="flex items-center justify-end mt-4">
                        <div class=" flex items-end" id="editar-btn">
                            <div class="flex items-center">
                                <h1 class='text-1xl font-bold mb-2 text-purple-800'>Eliminar el paciente:</h1>
                            </div>
                            <div class="flex items-center ms-3">
                                <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro que deseas eliminar este paciente?');"
                                    style="display: inline;" id="boton-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <x-boton-eliminar>Eliminar</x-boton-eliminar>
                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $hayProxima = false;
                        $hayConfirmada = false;
                        $hayFinalizada = false;
                        $hayCancelada = false;
                        foreach ($consultas as $consulta) {
                            if ($consulta->estado == 'Sin confirmar') {
                                $hayProxima = true;
                            } elseif ($consulta->estado == 'Confirmada') {
                                $hayConfirmada = true;
                            } elseif ($consulta->estado == 'Finalizada') {
                                $hayFinalizada = true;
                            } elseif ($consulta->estado == 'Cancelada') {
                                $hayCancelada = true;
                            }
                        }
                    @endphp
                    @if ($hayProxima or $hayConfirmada)
                        <div class="titulo-listado flex flex-col items-left">

                            <x-paciente.lista-consultas-proximas :consultas="$consultas" :paciente="$paciente" />

                        </div>
                    @elseif(!$hayProxima && !$hayConfirmada)
                        <div class=" overflow-hidden shadow-xl rounded-lg">
                            <x-boton-mas class="mb-2" id="mostrarRegistro">
                                {{ __('Agregar consulta') }}
                            </x-boton-mas>
                            <p id="inicioConsultas"></p>
                            <div id="formConsulta" style="display: none">
                                <form action="{{ route('consultas.store', $paciente->id) }}" method="POST"
                                    style="margin: 1%;" id="formRegistrar">
                                    @csrf

                                    <x-label for="tipo_consulta" value="{{ __('Tipo de consulta:') }}"
                                        style="margin: 0;" />
                                    <select id="tipo_consulta" name="tipo_consulta" required
                                        class="mt-1 w-full md:w-1/2 rounded-md bg-white py-2 pl-3 pr-10 text-gray-500 focus:ring-2 focus:ring-indigo-600"
                                        onchange="comprobar_tipo()">
                                        <option disabled selected class="text-gray-400 italic">Selecciona un tipo de
                                            consulta</option>
                                        <option value="Ginecologica">Ginecologica</option>
                                        <option value="Retiro de puntos">Retiro de puntos</option>
                                        <option value="Procedimientos">Procedimientos</option>
                                        <option value="Control prenatal">Control prenatal</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                    <div id="otro_tipo" style="display: none">
                                        <x-label for="otro_tipo_consulta" value="{{ __('Detalles:') }}"
                                            class="mt-1" />
                                        <x-input id="otro_tipo_consulta" class="block mt-1 w-full" type="text"
                                            name="otro_tipo_consulta" value=""
                                            autocomplete="new-otro-tipo-consulta" />
                                    </div>
                                    <div>
                                        <x-label for="fecha" value="{{ __('Fecha:') }}" />
                                        <x-input id="fecha" class="block mt-1 w-full md:w-1/2" type="date"
                                            name="fecha" value="" autocomplete="fecha" required />
                                    </div>
                                    <div class="flex mt-2 justify-end w-full md:w-1/2">
                                        <x-boton-cancelar id="cancelar-tipo-consulta">Cancelar</x-boton-cancelar>
                                        <x-button class="ms-4 mt-1">
                                            {{ __('Aceptar') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif


                    @if ($hayFinalizada or $hayCancelada)
                        <div class="titulo-listado flex flex-col items-left">
                            <h1 class='text-1xl font-bold mb-3 text-purple-800 mt-6'>Historial de
                                Consultas:
                            </h1>
                            <x-paciente.lista-consultas :consultas="$consultas" />
                        </div>
                    @endif

                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>

    <script>
        let creando = false;
        let cancelarTipoConsulta = false;
        let mostrarRegistro = document.getElementById('mostrarRegistro');

        if (mostrarRegistro) {
            mostrarRegistro.addEventListener('click', function() {

                if (!creando) {
                    document.getElementById('formConsulta').style.display = 'inline';
                    deslizar('inicioConsultas');
                    creando = true;
                    cancelarTipoConsulta = true;
                } else {
                    deslizar('inicioConsultas');
                    setTimeout(function() {
                        document.getElementById('formConsulta').style.display = 'none';
                        creando = false;
                        cancelarTipoConsulta = true;
                    }, 300);
                }
                if (cancelarTipoConsulta) {
                    document.getElementById('cancelar-tipo-consulta').addEventListener('click', function() {
                        deslizar('inicioConsultas');
                        setTimeout(function() {
                            document.getElementById('formConsulta').style.display = 'none';
                            creando = false;;
                        }, 200);
                    });
                }
            });
        }

        function comprobar_tipo() {
            var tipoconsulta = document.getElementsByName("tipo_consulta")[0];
            var otroTipoDiv = document.getElementById('otro_tipo');

            if (tipoconsulta.value.toLowerCase() === 'otro') {
                otroTipoDiv.style.display = 'inline';
            } else {
                otroTipoDiv.style.display = 'none';
            }
        }
    </script>
</x-app-layout>
