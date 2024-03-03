<x-app-layout>

    <x-header></x-header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 1%">

                <a href="{{ route('pacientes') }}">
                    <x-boton-mas class="ms-4">
                        {{ __('Regresar') }}
                    </x-boton-mas>
                </a>

                <p id="cambio" class="border-b-2 pb-2 mb-4"></p>
                @if (isset($paciente))
                    <div class="titulo-listado flex flex-col items-center">
                        <h1 class='text-4xl font-bold mb-6 text-indigo-800'>Detalles del paciente</h1>
                    </div>
                    <x-authentication-card>
                        <x-slot name="logo">
                            {{-- <x-authentication-card-logo /> --}}
                        </x-slot>
                    
                        <form id="paciente-form" method="POST" action="{{ route('pacientes.update', $paciente->id) }}">
                            @csrf
                            @method('PUT')
                    
                            <div class="mt-4">
                                <x-label for="nombre" value="{{ __('Nombre') }}" />
                                <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required
                                    value="{{ $paciente->nombre }}" autofocus autocomplete="nombre" readonly/>
                            </div>
                    
                            <div class="mt-4">
                                <x-label for="telefono" value="{{ __('Telefono') }}"/>
                                <x-input id="telefono" class="block mt-1 w-full" type="number" name="telefono" 
                                value="{{ $paciente->telefono }}" required autocomplete="telefono" readonly/>
                            </div>
                    
                            <div class="mt-4">
                                <x-label for="fecha_nacimiento" value="{{ __('Fecha de nacimiento') }}" />
                                <x-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento"
                                value="{{ $paciente->fecha_nacimiento }}" required autocomplete="fecha_nacimiento" readonly/>
                            </div>
                            
                            <div class="mt-4">
                                <x-label for="edad" value="{{ __('Edad') }}" />
                                <x-input id="edad" class="block mt-1 w-full" type="number" name="edad" 
                                value="{{ $paciente->edad }}" required autocomplete="edad"  readonly/>
                            </div>
                    
                            <div class="mt-4">
                                <x-label for="lugar_procedencia" value="{{ __('Lugar de procedencia') }}" />
                                <x-input id="lugar_procedencia" class="block mt-1 w-full" type="text" name="lugar_procedencia"
                                value="{{ $paciente->lugar_procedencia }}" required autocomplete="new-lugar_procedencia" readonly/>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('pacientes') }}">
                                    <x-boton-cancelar id="regresar" class="ms-4">
                                        {{ __('Regresar') }}
                                    </x-boton-cancelar>
                                </a>

                                <x-boton-editar id="editar-btn" class="ms-4">
                                    {{ __('Editar') }}
                                </x-boton-editar>
                    
                                <x-boton-cancelar id="cancelar" class="ms-4" style="display: none;">
                                    {{ __('Cancelar') }}
                                </x-boton-cancelar>
                                
                                <x-button class="ms-4" id="guardar-btn" style="display: none;">
                                    {{ __('Actualizar') }}
                                </x-button>
                            </div>
                        </form>
                        <div class="flex items-center justify-end mt-4">
                            <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro que deseas eliminar este paciente?');"
                                style=" display: inline;" id="boton-elimiar">
                                @csrf
                                @method('DELETE')
                                <x-boton-eliminar>Eliminar</x-boton-eliminar>
                            </form>
                        </div>
                    
                        
                    </x-authentication-card>
                    
            </div>

            <script>
                document.getElementById('editar-btn').addEventListener('click', function() {
                    // Habilitar la edición de los campos
                    document.querySelectorAll('#paciente-form input').forEach(function(input) {
                        input.removeAttribute('readonly');
                    });

                    // Mostrar el botón de guardar y ocultar el botón de editar
                    document.getElementById('guardar-btn').style.display = 'inline';
                    document.getElementById('cancelar').style.display = 'inline';                 
                    document.getElementById('regresar').style.display = 'none';
                    this.style.display = 'none';
                });
                document.getElementById('cancelar').addEventListener('click', function() {
                    // Habilitar la edición de los campos
                    document.querySelectorAll('#paciente-form input').forEach(function(input) {
                        input.setAttribute('readonly', 'readonly');
                    });
               
                    document.getElementById('regresar').style.display = 'inline';
                    document.getElementById('editar-btn').style.display = 'inline';
                    document.getElementById('guardar-btn').style.display = 'none';
                    this.style.display = 'none';
                });
            </script>
            @endif
        </div>
    </div>
    </div>
</x-app-layout>
