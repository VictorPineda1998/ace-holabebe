<x-app-layout>
    {{-- @if (isset($triaje))
{{$triaje->observaciones->estado_conciencia}}{{ $lugar }}
@endif --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-rose-200 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($lugar == 'paciente')
                    <a href="{{ route('pacientes.show', ['id' => $consulta->paciente->id]) }} ">
                        <x-boton-mas>
                            {{ __('Regresar') }}
                        </x-boton-mas>
                    </a>
                @endif
                @if ($lugar == 'hoy')
                    <a href="{{ route('consultas_dia') }} ">
                        <x-boton-mas>
                            {{ __('Regresar') }}
                        </x-boton-mas>
                    </a>
                @endif
                @if ($lugar == 'espera')
                    <a href="{{ route('consultas_espera') }} ">
                        <x-boton-mas>
                            {{ __('Regresar') }}
                        </x-boton-mas>
                    </a>
                @endif

                <div class="flex flex-col items-center">
                    <h1 class='text-4xl font-bold mb-6 text-indigo-800'>Detalles de la consulta</h1>
                </div>

                <div class=" flex flex-col items-left">
                    <h1 class='text-1xl font-bold mb-3 text-purple-800'>Datos generales del paciente:</h1>
                </div>
                <x-paciente.datos-generales :paciente="$consulta->paciente" />
                <div class=" flex items-end mt-2">
                    <div class="flex items-center mt-3">
                        <h1 class='text-1xl font-bold mb-2 text-purple-800'>Historial de consultas:</h1>
                    </div>
                    <div class="flex items-center ms-3">
                        <a href="{{ route('pacientes.show', $consulta->paciente_id) }} ">
                            <x-boton-mas>
                                {{ __('Historial') }}
                            </x-boton-mas>
                        </a>
                    </div>
                </div>
                <div class=" flex items-left mt-2">
                    <span class='text-1xl font-bold mb-3 text-purple-800'>Tipo de consulta:</span>
                    @if ($consulta->tipo_consulta == 'Otro')
                        <span
                            class="text-center border-blue-500 border-2 ms-1 mb-2 p-1 w-full md:w-1/2 lg:w-1/3 rounded-md">{{ $consulta->detalles_consulta }}</span>
                    @else
                        <span
                            class="text-center border-blue-500 border-2 ms-1 mb-2 p-1 w-full md:w-1/2 lg:w-1/3 rounded-md">{{ $consulta->tipo_consulta }}</span>
                    @endif
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
                    @if ((auth()->user()->tipo_usuario == 'Administrador' or auth()->user()->tipo_usuario == 'Medico especialista') ||
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
            </div>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>

    <script>
        let creandoTriaje = false;
        let creandoColposcopia = false;
        let creandoDiagnostico = false;
        let creandoNota = false;



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
        if(mostrarDiagnostico){
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

        document.getElementById('mostrarNota').addEventListener('click', function() {
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
    </script>
</x-app-layout>
