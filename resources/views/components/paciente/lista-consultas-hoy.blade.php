@if (!empty($consultas))
    <div id="divPadre">
        <div>
            <div class="titulo-listado flex flex-col items-center">
                <h1 class='text-4xl font-bold mb-6 text-purple-800'>Consultas del dia</h1>
            </div>
            <div>
                <input type="text" id="searchInput"
                    class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                    placeholder="Buscar por nombre, tipo o estado ...">
            </div>
            <div>
                <ul class="overflow-x-auto">
                    @php
                        $i = 1;
                    @endphp
                    <div style="width: 900px">
                        <li class="flex items-center bg-purple-400 p-3">
                            <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                            <span class="w-2/6 text-sm lg:text-base">Nombre</span>
                            <span class="w-1/6 text-sm lg:text-base">Tipo de consulta</span>
                            <span class="w-1/6 text-sm lg:text-base">Detalle</span>
                            <span class="w-2/6 text-sm lg:text-base">Opciones</span>
                        </li>
                        @foreach ($consultas as $consulta)
                            {{-- @php
                            // Verificar si la consulta fue realizada hoy
                            $esConsultaHoy = $consulta->created_at->isToday();
                            $esConsultaHoy ? $i++ : '';
                        @endphp --}}
                            {{-- <li class="flex items-center border-b py-2 {{ $esConsultaHoy ? 'bg-emerald-500 mb-6 mt-6' : ($i % 2 == 0 ? '' : 'bg-amber-100') }}"
                            style="padding: 1%"> --}}
                            @if ($consulta->estado == 'Sin confirmar' or $consulta->estado == 'Confirmada')
                                <li class="flex items-center border-b py-2 {{ $i % 2 != 0 ? 'bg-purple-200' : 'bg-purple-50' }}"
                                    style="padding: 1%">
                                    <span class="text-sm lg:text-base"
                                        style="margin-right: 2%">{{ $consulta->id }}</span>
                                    <span
                                        class="w-2/6 text-sm lg:text-base">{{ optional($consulta->paciente)->nombre }} {{ optional($consulta->paciente)->apellido_P }} {{ optional($consulta->paciente)->apellido_M }}</span>
                                    @if ($consulta->tipo_consulta == 'Otro')
                                        <span
                                            class="w-1/6 text-sm lg:text-base">{{ $consulta->detalles_consulta }}</span>
                                    @else
                                        <span class="w-1/6 text-sm lg:text-base">{{ $consulta->tipo_consulta }}</span>
                                    @endif
                                    <span class="w-1/6 text-sm lg:text-base">{{ $consulta->estado }}</span>
                                    <span class="w-2/6 text-sm lg:text-base">
                                        <a
                                            href="{{ route('consultas.show', ['id' => $consulta->id, 'lugar' => 'hoy']) }} ">
                                            <x-boton-editar>
                                                Ver
                                            </x-boton-editar>
                                        </a>
                                        @if ($consulta->estado != 'Confirmada')
                                            <x-boton-editar class="mostrarFormulario" data-boton="{{ $i }}">
                                                Reprogramar
                                            </x-boton-editar>
                                        @endif
                                        {{-- @if ($esConsultaHoy and $consulta->estado == 'próxima') --}}
                                        {{-- @if ($consulta->estado != 'Confirmada' && $consulta->fecha == now()->toDateString())
                                            <form style="display:inline;" method="POST"
                                                action="{{ route('consultas.updateHoy', ['id' => $consulta->id, 'estado' => 'confirmar']) }}">
                                                @csrf
                                                @method('PUT')
                                                <x-boton-actualizar>
                                                    Confirmar
                                                </x-boton-actualizar>
                                            </form>
                                        @endif --}}
                                        @if ($consulta->estado == 'Confirmada')
                                            <form style="display:inline;"
                                                onsubmit="return confirm('¿Estás seguro que deseas cancelar esta consulta?');"
                                                method="POST"
                                                action="{{ route('consultas.updateHoy', ['id' => $consulta->id, 'estado' => 'cancelar']) }}">
                                                @csrf
                                                @method('PUT')
                                                <x-boton-eliminar>
                                                    Cancelar
                                                </x-boton-eliminar>
                                            </form>
                                        @endif
                                    </span>
                                </li>

                                <div id="myModal{{ $i }}" class="modal">
                                    <div class="modal-content w-full md:w-1/2">
                                        <div>
                                            <span class="close"><x-boton-cancelar
                                                    class="cerrarModal{{ $i }}">&times;</x-boton-cancelar></span>
                                            <form
                                                action="{{ route('consultas.updateHoy', ['id' => $consulta->id, 'estado' => 'reprogramar']) }}"
                                                method="POST" style="margin: 1%;" id="formularioConsulta">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <x-label for="fecha" class="mt-1"
                                                        value="{{ __('Fecha') }}" />
                                                    <x-input id="fecha" class="block mt-1 w-full" type="date"
                                                        name="fecha" value="" autocomplete="fecha" />
                                                </div>
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
                                                    <x-input id="otro_tipo_consulta" class="block mt-1 w-full"
                                                        type="text" name="otro_tipo_consulta" value=""
                                                        autocomplete="new-otro-tipo-consulta" />
                                                </div>
                                                <x-button class="mt-1 ">
                                                    {{ __('Aceptar') }}
                                                </x-button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endif
                        @endforeach

                    </div>
                </ul>
            </div>
        </div>
    </div>

@endif

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


    // Cerrar el modal al enviar el formulario
    // document.getElementById('formularioConsulta').addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     document.getElementById('myModal').style.display = 'none';
    //     // Aquí puedes agregar lógica adicional para procesar el formulario si es necesario
    // });

    function comprobar_tipo(c) {
        var tipoconsulta = document.querySelector('.tipo_consulta' + c);
        var otroTipoDiv = document.getElementById('otro_tipo' + c);

        if (tipoconsulta.value.toLowerCase() === 'otro') {
            otroTipoDiv.style.display = 'inline';
        } else {
            otroTipoDiv.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('searchInput').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                if (li.querySelector('span')) { // Ignora el encabezado de la tabla
                    let nombre = li.querySelector('span:nth-child(2)').textContent.toLowerCase();
                    let tipo = li.querySelector('span:nth-child(3)').textContent.toLowerCase();
                    let estado = li.querySelector('span:nth-child(4)').textContent.toLowerCase();
                    li.style.display = (nombre.includes(searchTerm) || tipo.includes(
                        searchTerm) || estado.includes(searchTerm)) ? '' : 'none';
                }
            });
        });

    });
</script>
