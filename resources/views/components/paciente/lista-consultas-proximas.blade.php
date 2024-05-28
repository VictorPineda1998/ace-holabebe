@foreach ($consultas as $consulta)
    @if (
        ($consulta->estado == 'Sin confirmar' || $consulta->estado == 'Confirmada') &&
            $consulta->fecha >= now()->toDateString())
        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Consulta proxima:
        </h1>
    @elseif($consulta->estado == 'Sin confirmar' or $consulta->estado == 'Confirmada')
        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Consulta pendiente:
        </h1>
    @endif
    @if ($consulta->estado == 'Sin confirmar' or $consulta->estado == 'Confirmada')
        <div id="divPadre">
            <div>
                {{-- <div>
                <input type="text" id="searchInput"
                class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                placeholder="Buscar fecha o tipo ...">
                </div> --}}
                <div>
                    <ul class="overflow-x-auto">
                        {{-- @php
                        $i = 1;
                        @endphp --}}
                        <div style="width: 900px">
                            <li class="flex items-center bg-purple-300 p-3 rounded-t-lg">
                                <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                                <span class="w-1/5 text-sm lg:text-base">Fecha</span>
                                <span class="w-1/5 text-sm lg:text-base">Tipo de consulta</span>
                                <span class="w-1/5 text-sm lg:text-base">Detalle</span>
                                <span class="w-2/5 text-sm lg:text-base">Opciones</span>
                            </li>
                            {{-- @php
                            // Verificar si la consulta fue realizada hoy
                            $esConsultaHoy = $consulta->created_at->isToday();
                            $esConsultaHoy ? $i++ : '';
                            @endphp --}}
                            {{-- <li class="flex items-center border-b py-2 {{ $esConsultaHoy ? 'bg-emerald-500 mb-6 mt-6' : ($i % 2 == 0 ? '' : 'bg-amber-100') }}"
                            style="padding: 1%"> --}}

                            <li class="flex items-center border-b py-2 bg-purple-100" style="padding: 1%">
                                <span class="text-sm lg:text-base" style="margin-right: 2%">{{ $consulta->id }}</span>
                                <span class="w-1/5 text-sm lg:text-base">{{ $consulta->fecha }}</span>
                                @if ($consulta->tipo_consulta == 'Otro')
                                    <span class="w-1/5 text-sm lg:text-base">{{ $consulta->detalles_consulta }}</span>
                                @else
                                    <span class="w-1/5 text-sm lg:text-base">{{ $consulta->tipo_consulta }}</span>
                                @endif
                                <span class="w-1/5 text-sm lg:text-base">{{ $consulta->estado }}</span>
                                <span class="w-2/5 text-sm lg:text-base">
                                    {{-- @if ($consulta->estado == 'Confirmada') --}}
                                    @if ($consulta->fecha == now()->toDateString())
                                        <a
                                            href="{{ route('consultas.show', ['id' => $consulta->id, 'lugar' => 'paciente']) }} ">
                                            <x-boton-editar>
                                                Ver
                                            </x-boton-editar>
                                        </a>
                                    @endif
                                    {{-- @endif --}}
                                    @if ($consulta->estado != 'Confirmada')
                                        <x-boton-editar id="mostrarFormulario">
                                            Reprogramar
                                        </x-boton-editar>
                                    @endif
                                    {{-- @if ($consulta->estado != 'Confirmada' && $consulta->fecha == now()->toDateString())
                                        <form style="display:inline;" method="POST"
                                            action="{{ route('consultas.update', ['id' => $consulta->id, 'estado' => 'confirmar', 'p_id' => $paciente->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <x-boton-actualizar>
                                                Confirmar
                                            </x-boton-actualizar>
                                        </form>
                                    @endif --}}

                                    @if (
                                        (($consulta->estado == 'Confirmada' || $consulta->estado == 'Sin confirmar') &&
                                            $consulta->fecha != now()->toDateString()) ||
                                            $consulta->estado == 'Confirmada')
                                        <form style="display:inline;" id="cancelarConsulta" {{-- onsubmit="return confirm('¿Estás seguro que deseas cancelar esta consulta?');" --}}
                                            method="POST"
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
                            </li>
                            {{-- @php
                            $i++;
                        @endphp --}}
                        </div>
                    </ul>
                </div>
            </div>
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
        /* right: 0; */
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
        /* right: 50%; */
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

    // Cerrar el modal al enviar el formulario
    // document.getElementById('formularioConsulta').addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     document.getElementById('myModal').style.display = 'none';
    //     // Aquí puedes agregar lógica adicional para procesar el formulario si es necesario
    // });

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


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('searchInput').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                if (li.querySelector('span')) { // Ignora el encabezado de la tabla
                    let fecha = li.querySelector('span:nth-child(2)').textContent.toLowerCase();
                    let tipo = li.querySelector('span:nth-child(3)').textContent.toLowerCase();
                    li.style.display = (fecha.includes(searchTerm) || tipo.includes(
                        searchTerm)) ? '' : 'none';
                }
            });
        });

    });
</script> --}}
