<x-app-layout>
    @if (isset($triaje))
{{$triaje->observaciones->estado_conciencia}}{{ $lugar }}
@endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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

                <div class="flex items-center justify-end mt-4">
                    {{-- <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro que deseas eliminar este paciente?');"
                            style="display: inline;" id="boton-eliminar">
                            @csrf
                            @method('DELETE') --}}
                    <div class="items-left mt-8 mb-2 me-3">
                        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Toma de primeros datos:</h1>
                    </div>
                    <x-boton-mas id="mostrarPrimerosDatos" class="ps-5 pe-6">Mostrar</x-boton-mas>


                    {{-- </form> --}}
                </div>
                <div id="formPrimerosDatos" style="display: none">
                    {{-- <x-paciente.toma-signos-vitales /> --}}
                    
                        <x-paciente.triaje :consulta="$consulta" :triaje="$triaje ?? null"/>
                    
                    <div class="flex items-center justify-end mt-4">
                        <x-boton-cancelar id="ocultarPrimerosDatos">Ocultar</x-boton-cancelar>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>

    <script>
        let creando = false;
        document.getElementById('mostrarPrimerosDatos').addEventListener('click', function() {
            if (!creando) {

                document.getElementById('formPrimerosDatos').style.display = 'inline';
                deslizar('mostrarPrimerosDatos');
                creando = true;
            } else {
                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById('formPrimerosDatos').style.display = 'none';
                }, 300);
                creando = false;
            }
            document.getElementById('ocultarPrimerosDatos').addEventListener('click', function() {
                deslizar('inicio');
                setTimeout(function() {
                    document.getElementById('formPrimerosDatos').style.display = 'none';
                }, 300);
                creando = false;
                // window.location.hash = '';
            });
        });
    </script>
</x-app-layout>
