<div>
    <div class="w-full md:w-1/2 flex items-center ">
        <h1 class='text-1xl font-bold mb-3 mr-2 text-purple-800'>Buscar paciente:</h1>
        <form action="{{ route('calendario') }}" method="GET">
            <input class="mb-4 border border-gray-300 rounded-md" type="text" name="searchCalendario"
                placeholder="Solo nombre(s)" value="{{ request()->searchCalendario }}">
            <x-boton-mas type="submit">Buscar</x-boton-mas>
        </form>
    </div>
    <ul class="overflow-x-auto mt-3 mb-3">
        @php
            $i = 1;
            $hayConsulta = false;
        @endphp
        <div style="width: 1135px">
            @if ($pacientes)
                <ul class="flex items-center bg-pink-500 p-3 rounded-t-lg">
                    <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                    <span class="w-2/12 text-sm lg:text-base">Nombre(s)</span>
                    <span class="w-2/12 text-sm lg:text-base">Apellido Paterno</span>
                    <span class="w-2/12 text-sm lg:text-base">Apellido Materno</span>
                    <span class="w-2/12 text-sm lg:text-base">Telefono</span>
                    <span class="w-1/12 text-sm lg:text-base">Edad</span>
                    <span class="w-1/12 text-sm lg:text-base">Detalles</span>
                    <span class="w-2/12 text-sm lg:text-base">Opciones</span>
                </ul>
                @foreach ($pacientes as $paciente)
                    @php
                        // Calcular la edad a partir de la fecha de nacimiento
                        $fechaNacimiento = \Carbon\Carbon::parse($paciente->fecha_nacimiento);
                        $edad = $fechaNacimiento->diff(\Carbon\Carbon::now())->y;
                    @endphp
                    <li class="flex items-center border-b py-2 {{ $loop->odd ? 'bg-pink-300' : 'bg-pink-200' }}"
                        style="padding: 1%">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">{{ $paciente->id }}</span>
                        <span class="w-2/12 text-sm lg:text-base">{{ $paciente->nombre }}</span>
                        <span class="w-2/12 text-sm lg:text-base">{{ $paciente->apellido_P }}</span>
                        <span class="w-2/12 text-sm lg:text-base"> {{ $paciente->apellido_M }}</span>
                        <span class="w-2/12 text-sm lg:text-base">{{ $paciente->telefono }}</span>
                        <span class="w-1/12 text-sm lg:text-base">{{ $edad }} años</span>
                        <span class="flex w-1/12 text-sm lg:text-base">
                            @foreach ($consultas as $consulta)
                                @if ($consulta['paciente_id'] === $paciente->id)
                                    @php
                                        $fecha = \Carbon\Carbon::parse($consulta['start'])->format('d-m-Y');
                                    @endphp
                                    <div>
                                        {{ $fecha }}
                                        
                                    </div>
                                    @php
                                        $hayConsulta = true;
                                    @endphp
                                    @break                                                                        
                                @endif
                            @endforeach
                            @if (!$hayConsulta)
                            <p>Sin fecha</p>
                            @endif
                        </span>
                            <span class="flex w-2/12 text-sm lg:text-base">
                        @if (!$hayConsulta)
                            <x-boton-editar class="mostrarFormulario" data-boton="{{ $i }}">
                                Agendar
                            </x-boton-editar>
                            <a href="{{ route('pacientes.show', $paciente->id) }}">
                                <x-boton-editar class="ms-6">
                                    Ver
                                </x-boton-editar>
                            </a>
                        @else                            
                            <a href="{{ route('pacientes.show', $paciente->id) }}">
                                <x-boton-editar style="padding-left: 70%; padding-right: 70%" >
                                    Pendiente
                                </x-boton-editar>
                            </a>
                        @endif
                        @php
                            $hayConsulta = false;
                        @endphp                        
                    </span>
                </li>
                <div id="myModal{{ $i }}" class="modal">
                    <div class="modal-content w-full md:w-1/2">
                        <div>
                            <span class="close"><x-boton-cancelar
                                    class="cerrarModal{{ $i }}">&times;</x-boton-cancelar></span>
                            <form class="mt-2" action="{{ route('calendario.store', $paciente->id) }}" method="POST"
                                id="formularioConsulta">
                                @csrf
                                <x-label for="tipo_consulta" value="{{ __('Tipo de consulta:') }}"
                                    style="margin: 0;" />
                                <select id="tipo_consulta" name="tipo_consulta"
                                    class="tipo_consulta{{ $i }} mt-1 w-full rounded-md bg-white py-2 pl-3 pr-10 text-gray-500 focus:ring-2 focus:ring-indigo-600"
                                    onchange="comprobar_tipo({{ $i }})">
                                    <option disabled selected class="text-gray-400 italic">Selecciona un
                                        tipo de consulta</option>
                                    <option value="Ginecologica">Ginecologica</option>
                                    <option value="Retiro de puntos">Retiro de puntos</option>
                                    <option value="Procedimientos">Procedimientos</option>
                                    <option value="Control prenatal">Control prenatal</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <div id="otro_tipo{{ $i }}" style="display: none">
                                    <x-label for="otro_tipo_consulta" value="{{ __('Detalles:') }}"
                                        class="mt-1" />
                                    <x-input id="otro_tipo_consulta" class="block mt-1 w-full" type="text"
                                        name="otro_tipo_consulta" value=""
                                        autocomplete="new-otro-tipo-consulta" />
                                </div>
                                <div>
                                    <x-label for="fecha" class="mt-1" value="{{ __('Fecha') }}" />
                                    <x-input id="fecha" class="block mt-1 w-full" type="date" name="fecha"
                                        value="" autocomplete="fecha" />
                                </div>
                                <div class="flex mt-2 justify-end w-full">
                                    <x-button class="ms-4 mt-1">
                                        {{ __('Aceptar') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @php
                    $i++;
                @endphp
            @endforeach
            <div class="mt-2">
                {{ $pacientes->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</ul>
</div>
<style>
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    /* Fondo oscuro semi-transparente */
    z-index: 1000;
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    /* width: 85%; */
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}
</style>
<script>
    let botonId;
    document.querySelectorAll('.mostrarFormulario').forEach(function(btn) {
        btn.addEventListener('click', function() {

            botonId = this.getAttribute('data-boton');
            document.getElementById('myModal' + botonId).style.display = 'block';

            document.querySelector('.cerrarModal' + botonId).addEventListener('click', function() {
                document.getElementById('myModal' + botonId).style.display = 'none';
            });

            // Cerrar el modal al hacer clic fuera de él
            window.addEventListener('click', function(event) {
                var modal = document.getElementById('myModal' + botonId);
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    });

    function comprobar_tipo(c) {
        var tipoconsulta = document.querySelector('.tipo_consulta' + c);
        var otroTipoDiv = document.getElementById('otro_tipo' + c);

        if (tipoconsulta.value.toLowerCase() === 'otro') {
            otroTipoDiv.style.display = 'inline';
        } else {
            otroTipoDiv.style.display = 'none';
        }
    }
</script>
