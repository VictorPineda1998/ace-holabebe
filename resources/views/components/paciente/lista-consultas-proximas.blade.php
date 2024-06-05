@foreach ($consultas as $consulta)
    @if (
        ($consulta->estado == 'Sin confirmar' || $consulta->estado == 'Confirmada') &&
            $consulta->fecha >= now()->toDateString())
        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Consulta proxima:</h1>
    @elseif($consulta->estado == 'Sin confirmar' or $consulta->estado == 'Confirmada')
        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Consulta pendiente:</h1>
    @endif
    @if ($consulta->estado == 'Sin confirmar' or $consulta->estado == 'Confirmada')
        <div id="divPadre">
            <ul class="overflow-x-auto">
                <div class="w-full lg:w-[900px]">
                    <li class="hidden lg:flex items-center bg-purple-300 p-3 rounded-t-lg">
                        <span class="text-sm lg:text-base" style="margin-right: 2%">ID</span>
                        <span class="w-1/5 text-sm lg:text-base">Fecha</span>
                        <span class="w-1/5 text-sm lg:text-base">Tipo de consulta</span>
                        <span class="w-1/5 text-sm lg:text-base">Detalle</span>
                        <span class="w-2/5 text-sm lg:text-base">Opciones</span>
                    </li>
                    <li
                        class=" bg-purple-300 rounded-lg flex flex-col lg:flex-row items-start lg:items-center lg:bg-purple-100 border-b py-2  p-4 lg:p-2 mb-4 lg:mb-0 lg:rounded-none">
                        <div class="flex w-full lg:w-auto mb-2 lg:mb-0" style="margin-right: 2%">
                            <span class="font-bold lg:hidden">ID: </span>
                            <span class="text-center ms-1 lg:text-base"
                                >{{ $consulta->id }}</span>
                        </div>
                        <div class="flex w-full lg:w-1/5 mb-2 lg:mb-0">
                            <span class="font-bold lg:hidden">Fecha: </span>
                            <span class="text-center ms-1 lg:text-base">{{ $consulta->fecha }}</span>
                        </div>
                        <div class="flex w-full lg:w-1/5 mb-2 lg:mb-0">
                            <span class="font-bold lg:hidden">Tipo de consulta: </span>
                            @if ($consulta->tipo_consulta == 'Otro')
                                <span class="text-center ms-1 lg:text-base">{{ $consulta->detalles_consulta }}</span>
                            @else
                                <span class="text-center ms-1 lg:text-base">{{ $consulta->tipo_consulta }}</span>
                            @endif
                        </div>
                        <div class="flex w-full lg:w-1/5 mb-2 lg:mb-0">
                            <span class="font-bold lg:hidden">Detalle: </span>
                            <span class="text-center ms-1 lg:text-base">{{ $consulta->estado }}</span>
                        </div>
                        <div class="flex w-full lg:w-1/5 mb-2 lg:mb-0">
                            <span class="font-bold lg:hidden">Opciones: </span>
                            <span class="text-center ms-1 lg:text-base lg:flex">
                                @if ($consulta->fecha == now()->toDateString())
                                    <a
                                        href="{{ route('consultas.show', ['id' => $consulta->id, 'lugar' => 'paciente']) }} ">
                                        <x-boton-editar class="me-2">
                                            Ver
                                        </x-boton-editar>
                                    </a>
                                @endif
                                @if ($consulta->estado != 'Confirmada')
                                    <x-boton-editar id="mostrarFormulario">
                                        Reprogramar
                                    </x-boton-editar>
                                @endif
                                @if (
                                    (($consulta->estado == 'Confirmada' || $consulta->estado == 'Sin confirmar') &&
                                        $consulta->fecha != now()->toDateString()) ||
                                        $consulta->estado == 'Confirmada')
                                    <form style="display:inline;" id="cancelarConsulta" method="POST"
                                        action="{{ route('consultas.update', ['id' => $consulta->id, 'estado' => 'cancelar', 'p_id' => $paciente->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <x-boton-eliminar
                                            onclick="event.preventDefault(); openConfirmModal(() => document.getElementById('cancelarConsulta').submit(), '¿Estás seguro que deseas cancelar esta consulta?', '{{ $paciente->nombre }} {{ $paciente->apellido_P }} {{ $paciente->apellido_M }}');">
                                            Cancelar
                                        </x-boton-eliminar>
                                    </form>
                                @endif
                            </span>
                        </div>
                    </li>
                </div>
            </ul>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content w-full md:w-1/2">
                <div>
                    <span class="close" id="cerrarModal"><x-boton-cancelar>&times;</x-boton-cancelar></span>
                    <form
                        action="{{ route('consultas.update', ['id' => $consulta->id, 'estado' => 'reprogramar', 'p_id' => $paciente->id]) }}"
                        method="POST" id="formularioConsulta">
                        @csrf
                        @method('PUT')

                        <x-label for="tipo_consulta" value="{{ __('Tipo de consulta:') }}"
                            style="margin: 0; display: inline;" />
                        <select id="tipo_consulta" name="tipo_consulta"
                            class="mt-1 w-full rounded-md bg-white py-2 pl-3 pr-10 text-gray-500 focus:ring-2 focus:ring-indigo-600"
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
                            <x-label for="otro_tipo_consulta" value="{{ __('Detalles:') }}" class="mt-1" />
                            <x-input id="otro_tipo_consulta" class="block mt-1 w-full" type="text"
                                name="otro_tipo_consulta" value="" autocomplete="new-otro-tipo-consulta" />
                        </div>
                        <div>
                            <x-label for="fecha" class="mt-1" value="{{ __('Fecha') }}" />
                            <x-input id="fecha" class="block mt-1 w-full" type="date" name="fecha"
                                value="" autocomplete="fecha" />
                        </div>
                        <div class="flex mt-2 justify-end">
                            <x-button>
                                {{ __('Aceptar') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

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
    document.getElementById('mostrarFormulario').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'block';
    });

    document.getElementById('cerrarModal').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'none';
    });

    // Cerrar el modal al hacer clic fuera de él
    window.addEventListener('click', function(event) {
        var modal = document.getElementById('myModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

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
