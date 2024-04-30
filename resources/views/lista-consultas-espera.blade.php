<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-rose-200 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="titulo-listado flex flex-col items-center">
                    <h1 class='text-4xl font-bold mb-6 text-green-800'>Sala de espera</h1>
                </div>
                @if (!empty($consultas))
                    <div>
                        <input type="text" id="searchInput"
                            class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                            placeholder="Buscar por nombre o tipo...">

                    </div>

                    <ul class="overflow-x-auto">
                        @php
                            $i = 1;
                        @endphp
                        <div style="width: 900px">
                            <li class="flex items-center bg-green-400 p-3">
                                <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                                <span class="w-1/3 text-sm lg:text-base">Nombre</span>
                                <span class="w-1/3 text-sm lg:text-base">Tipo de consulta</span>
                                <span class="w-1/3 text-sm lg:text-base">Opciones</span>
                            </li>
                            @foreach ($consultas as $consulta)
                                @if ($consulta->estado == 'Confirmada')
                                    <li class="flex items-center border-b py-2 {{ $i % 2 != 0 ? 'bg-green-200' : 'bg-white' }}"
                                        style="padding: 1%">
                                        <span class="text-sm lg:text-base"
                                            style="margin-right: 2%">{{ $consulta->id }}</span>
                                        <span
                                            class="w-1/3 text-sm lg:text-base">{{ optional($consulta->paciente)->nombre }} {{ optional($consulta->paciente)->apellido_P }} {{ optional($consulta->paciente)->apellido_M }}</span>
                                        @if ($consulta->tipo_consulta == 'Otro')
                                            <span
                                                class="w-1/3 text-sm lg:text-base">{{ $consulta->detalles_consulta }}</span>
                                        @else
                                            <span
                                                class="w-1/3 text-sm lg:text-base">{{ $consulta->tipo_consulta }}</span>
                                        @endif
                                        <span class="w-1/3 text-sm lg:text-base">
                                            <a
                                                href="{{ route('consultas.show', ['id' => $consulta->id, 'lugar' => 'espera']) }} ">
                                                <x-boton-editar>
                                                    Ver
                                                </x-boton-editar>
                                            </a>
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
                                    @php
                                        $i++;
                                    @endphp
                                @endif
                            @endforeach

                        </div>
                    </ul>

                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('searchInput').addEventListener('input', function() {
                let searchTerm = this.value.toLowerCase();
                document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                    if (li.querySelector('span')) { // Ignora el encabezado de la tabla
                        let nombre = li.querySelector('span:nth-child(2)').textContent.toLowerCase();
                        let tipo = li.querySelector('span:nth-child(3)').textContent.toLowerCase();
                        li.style.display = (nombre.includes(searchTerm) || tipo.includes(
                            searchTerm)) ? '' : 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
