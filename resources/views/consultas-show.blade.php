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
            @if ($lugar == 'paciente')
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('pacientes') }} "
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            {{-- {{ $product->subcategory->category->family->name }} --}}
                            Pacientes
                        </a>
                    </div>
                </li>
            @endif
            @if ($lugar == 'hoy' || $lugar == 'espera')
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        @if ($lugar == 'hoy')
                            <a href="{{ route('consultas_dia') }} "
                                class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                                Consultas del dia
                            </a>
                        @endif
                        @if ($lugar == 'espera')
                            <a href="{{ route('consultas_espera') }} "
                                class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                                Sala de espera
                            </a>
                        @endif

                    </div>
                </li>
            @endif
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ route('pacientes.show', ['id' => $consulta->paciente->id]) }} "
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        {{-- {{ $product->subcategory->category->family->name }} --}}
                        Detalles del pacientes
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
                        {{-- {{ $product->subcategory->category->family->name }} --}}
                        Detalles de la consulta
                    </span>
                </div>
            </li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                <div class="flex flex-col items-center">
                    <h1 class='text-4xl font-bold mb-6 text-indigo-800'>Detalles de la consulta</h1>
                </div>
                <div class="mb-3">
                    <li class="flex items-center mt-3 bg-green-400 p-3 rounded-t-lg">
                        <span class="w-1/3 text-sm lg:text-base">Tipo de consulta</span>
                        @if ($consulta->estado == 'Finalizada' || $consulta->estado == 'Cancelada')
                            <span class="w-1/3 text-sm lg:text-base">Estado de la consulta</span>
                        @endif
                        <span class="w-1/3 text-sm lg:text-base">Fecha de la consulta:</span>
                    </li>
                    <li class="flex items-center bg-green-200 p-3 rounded-b-lg">
                        @if ($consulta->tipo_consulta == 'Otro')
                            <span class="w-1/3 text-sm lg:text-base">{{ $consulta->detalles_consulta }}</span>
                        @else
                            <span class="w-1/3 text-sm lg:text-base">{{ $consulta->tipo_consulta }}</span>
                        @endif
                        @if ($consulta->estado == 'Finalizada' || $consulta->estado == 'Cancelada')
                            <span class="w-1/3 text-sm lg:text-base">{{ $consulta->estado }}</span>
                        @endif
                        <span class="w-1/3 text-sm lg:text-base">{{ $consulta->fecha }}</span>
                    </li>
                </div>
                <div class=" flex flex-col items-left">
                    <h1 class='text-1xl font-bold mb-3 text-purple-800'>Datos generales del paciente:</h1>
                </div>
                <x-paciente.datos-generales :paciente="$consulta->paciente" />
                <div class=" flex items-center justify-end mt-4 mb-3">
                    <div class="flex items-center mt-4">
                        <h1 class='text-1xl font-bold mb-2 text-purple-800'>Historial de consultas:</h1>
                    </div>
                    <div class="flex items-center ms-3">
                        <x-boton-mas id="mostrarHistorial" class="ps-5 pe-6">
                            {{ __('Mostrar') }}
                        </x-boton-mas>
                    </div>
                </div>
                <div id="divHistorial" style="display: none">
                    <x-paciente.lista-consultas :consultas="$consultas ?? null" />
                    <div class="flex items-center justify-end mt-4 mb-3">
                        <x-boton-cancelar id="ocultarHistorial">Ocultar</x-boton-cancelar>
                    </div>
                </div>
                <div id="cajaTriajePadre">
                    <div class="flex items-center justify-end mt-4">
                        <div class="items-left mt-8 mb-2 me-3">
                            <h1 class='text-1xl font-bold mb-3 text-purple-800'>Toma de primeros datos:</h1>
                        </div>
                        <x-boton-mas id="mostrarPrimerosDatos" class="ps-5 pe-6">Mostrar</x-boton-mas>
                    </div>
                    <div id="formPrimerosDatos" style="display: none">

                        <x-paciente.triaje :consulta="$consulta" :triaje="$triaje ?? null" />

                        <div class="flex items-center justify-end mt-4 mb-3">
                            <x-boton-cancelar id="ocultarPrimerosDatos">Ocultar</x-boton-cancelar>
                        </div>
                    </div>
                </div>

                @if ($consulta->estado != 'Sin confirmar')
                    <div id="cajaNotaPadre">
                        <div class="flex items-center justify-end">
                            <div class="items-left mt-8 mb-2 me-3">
                                <h1 class='text-1xl font-bold mb-3 text-purple-800'>Notas:</h1>
                            </div>
                            <x-boton-mas id="mostrarNota" class="ps-5 pe-6">Mostrar</x-boton-mas>
                        </div>
                        <div id="divNota" style="display: none">

                            <div>
                                <x-paciente.nota :consulta="$consulta ?? null" :nota="$nota ?? null" />
                            </div>

                            <div class="flex items-center justify-end mt-4 mb-3">
                                <x-boton-cancelar id="ocultarNota">Ocultar</x-boton-cancelar>
                            </div>
                        </div>
                    </div>
                @endif

                @if (
                    $consulta->tipo_consulta == 'Ginecologica' &&
                        ($consulta->estado == 'Confirmada' || $consulta->estado == 'Cancelada' || $consulta->estado == 'Finalizada'))
                    @if (
                        (auth()->user()->tipo_usuario == 'Administrador' or auth()->user()->tipo_usuario == 'Medico especialista') ||
                            (auth()->user()->tipo_usuario == 'Enfermeria consultorios' && $consulta->estado == 'Finalizada'))
                        <div id="cajaColposcopiaPadre">
                            <div class="flex items-center justify-end">
                                <div class="items-left mt-8 mb-2 me-3">
                                    <h1 class='text-1xl font-bold mb-3 text-purple-800'>Toma de datos colposcopia:</h1>
                                </div>
                                <x-boton-mas id="mostrarColposcopia" class="ps-5 pe-6">Mostrar</x-boton-mas>
                            </div>
                            <div id="divColposcopia" style="display: none">

                                <div>
                                    <h1 class='text-1xl font-bold mb-3 text-purple-800'>Colposcopia:</h1>
                                    <x-paciente.colposcopia :consulta="$consulta" :colposcopia="$colposcopia ?? null" :triaje="$triaje ?? null" />
                                </div>

                                <div class="flex items-center justify-end mt-4 mb-3">
                                    <x-boton-cancelar id="ocultarColposcopia">Ocultar</x-boton-cancelar>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if (auth()->user()->tipo_usuario == 'Administrador' ||
                        (auth()->user()->tipo_usuario == 'Medico especialista' && $consulta->triaje_id != 0) ||
                        (auth()->user()->tipo_usuario == 'Enfermeria consultorios' && $consulta->estado == 'Finalizada'))
                    <div id="cajaDiagnosticoPadre">
                        <div class="flex items-center justify-end">
                            <div class="items-left mt-8 mb-2 me-3">
                                <h1 class='text-1xl font-bold mb-3 text-purple-800'>Diagnostico y receta medica:</h1>
                            </div>
                            <x-boton-mas id="mostrarDiagnostico" class="ps-5 pe-6">Mostrar</x-boton-mas>
                        </div>
                        <div id="divDiagnostico" style="display: none">

                            <div>
                                <x-paciente.diagnostico :consulta="$consulta" :diagnostico="$diagnostico ?? null" :triaje="$triaje ?? null" />
                            </div>

                            <div class="flex items-center justify-end mt-4 mb-3">
                                <x-boton-cancelar id="ocultarDiagnostico">Ocultar</x-boton-cancelar>
                            </div>
                        </div>
                    </div>
                @endif
            </x-div-fondo>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>

    <script>
        let mostrandoHistorial = false;
        let creandoTriaje = false;
        let creandoColposcopia = false;
        let creandoDiagnostico = false;
        let creandoNota = false;


        let mostrarHistorial = document.getElementById('mostrarHistorial');
        if (mostrarHistorial) {
            mostrarHistorial.addEventListener('click', function() {
                if (!mostrandoHistorial) {

                    document.getElementById('divHistorial').style.display = 'inline';
                    deslizar('mostrarHistorial');
                    mostrandoHistorial = true;
                } else {
                    deslizar('mostrarPrimerosDatos');

                    setTimeout(function() {
                        document.getElementById('divHistorial').style.display = 'none';
                    }, 300);
                    mostrandoHistorial = false;
                }
                document.getElementById('ocultarHistorial').addEventListener('click', function() {
                    deslizar('divHistorial');
                    setTimeout(function() {
                        document.getElementById('divHistorial').style.display = 'none';
                    }, 300);
                    mostrandoHistorial = false;
                });
            });
        }

        document.getElementById('mostrarPrimerosDatos').addEventListener('click', function() {
            if (!creandoTriaje) {

                document.getElementById('formPrimerosDatos').style.display = 'inline';
                deslizar('mostrarPrimerosDatos');
                creandoTriaje = true;
            } else {
                deslizar('formPrimerosDatos');

                setTimeout(function() {
                    document.getElementById('formPrimerosDatos').style.display = 'none';
                }, 300);
                creandoTriaje = false;
            }
            document.getElementById('ocultarPrimerosDatos').addEventListener('click', function() {
                deslizar('formPrimerosDatos');
                setTimeout(function() {
                    document.getElementById('formPrimerosDatos').style.display = 'none';
                }, 300);
                creandoTriaje = false;
                // window.location.hash = '';
            });
        });

        let mostrarColposcopia = document.getElementById('mostrarColposcopia');
        if (mostrarColposcopia) {
            mostrarColposcopia.addEventListener('click', function() {
                if (!creandoColposcopia) {

                    document.getElementById('divColposcopia').style.display = 'inline';
                    deslizar('mostrarColposcopia');
                    creandoColposcopia = true;
                } else {
                    deslizar('mostrarPrimerosDatos');

                    setTimeout(function() {
                        document.getElementById('divColposcopia').style.display = 'none';
                    }, 300);
                    creandoColposcopia = false;
                }
                document.getElementById('ocultarColposcopia').addEventListener('click', function() {
                    deslizar('divColposcopia');
                    setTimeout(function() {
                        document.getElementById('divColposcopia').style.display = 'none';
                    }, 300);
                    creandoColposcopia = false;
                });
            });
        }

        let mostrarDiagnostico = document.getElementById('mostrarDiagnostico');
        if (mostrarDiagnostico) {
            mostrarDiagnostico.addEventListener('click', function() {
                if (!creandoDiagnostico) {

                    document.getElementById('divDiagnostico').style.display = 'inline';
                    deslizar('mostrarDiagnostico');
                    creandoDiagnostico = true;
                } else {
                    deslizar('mostrarPrimerosDatos');

                    setTimeout(function() {
                        document.getElementById('divDiagnostico').style.display = 'none';
                    }, 300);
                    creandoDiagnostico = false;
                }
                document.getElementById('ocultarDiagnostico').addEventListener('click', function() {
                    deslizar('divDiagnostico');
                    setTimeout(function() {
                        document.getElementById('divDiagnostico').style.display = 'none';
                    }, 300);
                    creandoDiagnostico = false;
                });
            });
        }

        let mostrarNota = document.getElementById('mostrarNota');
        if (mostrarNota) {
            mostrarNota.addEventListener('click', function() {
                if (!creandoNota) {

                    document.getElementById('divNota').style.display = 'inline';
                    deslizar('mostrarNota');
                    creandoNota = true;
                } else {
                    deslizar('mostrarPrimerosDatos');

                    setTimeout(function() {
                        document.getElementById('divNota').style.display = 'none';
                    }, 300);
                    creandoNota = false;
                }
                document.getElementById('ocultarNota').addEventListener('click', function() {
                    deslizar('divNota');
                    setTimeout(function() {
                        document.getElementById('divNota').style.display = 'none';
                    }, 300);
                    creandoNota = false;
                });
            });
        }

        function autoNewLine(textArea) {
            const maxLineLength = 65;
            let lines = textArea.value.split('\n');
            let modified = false;

            for (let i = 0; i < lines.length; i++) {
                if (lines[i].length > maxLineLength) {
                    let spaceIndex = lines[i].lastIndexOf(' ', maxLineLength);
                    if (spaceIndex === -1) spaceIndex = maxLineLength; // Si no hay espacio, corta en el límite máximo
                    lines[i] = lines[i].substring(0, spaceIndex) + '\n' + lines[i].substring(spaceIndex).trim();
                    modified = true;
                }
            }

            if (modified) {
                textArea.value = lines.join('\n');
            }
        }
    </script>
</x-app-layout>
