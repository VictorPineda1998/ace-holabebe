<x-authentication-card>
    <x-slot name="logo">
        {{-- <x-authentication-card-logo /> --}}
    </x-slot>

    {{-- <x-validation-errors class="mb-4" /> --}}

    <form method="POST" action="{{ route('pacientes.store', $user->id) }}" id="formRegistrar">
        @csrf

        <div class="mt-4">
            <x-label for="nombre" value="{{ __('Nombre(s)') }}" />
            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required
                autofocus autocomplete="nombre" />
        </div>
        <div class="mt-4">
            <x-label for="apellidoP" value="{{ __('Apellido Paterno') }}" />
            <x-input id="apellidoP" class="block mt-1 w-full" type="text" name="apellidoP" :value="old('apellidoP')" required
                autofocus autocomplete="apellidoP" />
        </div>
        <div class="mt-4">
            <x-label for="apellidoM" value="{{ __('Apellido Materno') }}" />
            <x-input id="apellidoM" class="block mt-1 w-full" type="text" name="apellidoM" :value="old('apellidoM')" required
                autofocus autocomplete="apellidoM" />
        </div>

        <div class="mt-4">
            <x-label for="telefono" value="{{ __('Telefono') }}"/>
            <x-input id="telefono" class="block mt-1 w-full" type="number" name="telefono" required autocomplete="telefono"/>
        </div>

        <div class="mt-4">
            <x-label for="fecha_nacimiento" value="{{ __('Fecha de nacimiento') }}" />
            <x-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento"
                required autocomplete="fecha_nacimiento" />
        </div>
        
        {{-- <div class="mt-4"> --}}
            {{-- <x-label for="edad" value="{{ __('Edad') }}" style="display: none"/> --}}
            {{-- <x-input id="edad"  type="number" name="edad"  style="display: none"/>
        </div> --}}
        

        
        <div class="mt-4">
            <x-label for="lugar_procedencia" value="{{ __('Lugar de procedencia') }}" />
            <x-input id="lugar_procedencia" class="block mt-1 w-full" type="text" name="lugar_procedencia"
                required autocomplete="new-lugar_procedencia" />
        </div>



        <div class="flex items-center justify-end mt-4">

            <x-boton-cancelar id="cancelar" class="ms-4">
                {{ __('Cancelar') }}
            </x-boton-cancelar>
            

            <x-button class="ms-4">
                {{ __('Registrar') }}
            </x-button>
        </div>
    </form>
</x-authentication-card>



