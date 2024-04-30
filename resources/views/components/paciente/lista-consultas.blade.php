<div>
    <div>
        <div>
            <input type="text" id="searchInput"
                class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                placeholder="Buscar por fecha o tipo ...">
        </div>
        <div>
            <ul class="overflow-x-auto">
                @php
                    $i = 1;
                @endphp
                <div style="width: 900px">
                    <li class="flex items-center bg-amber-300 p-3">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                        <span class="w-1/4 text-sm lg:text-base">Fecha</span>
                        <span class="w-1/4 text-sm lg:text-base">Tipo de consulta</span>
                        <span class="w-1/4 text-sm lg:text-base">Detalle</span>
                        <span class="w-1/4 text-sm lg:text-base">Opciones</span>
                    </li>
                    @foreach ($consultas as $consulta)
                        @if ($consulta->estado == 'Finalizada' or $consulta->estado == 'Cancelada')
                        <li class="flex items-center border-b py-2 {{$i % 2 != 0 ? 'bg-amber-100' : 'bg-white'}}" style="padding: 1%">
                                <span class="text-sm lg:text-base" style="margin-right: 2%">{{ $consulta->id }}</span>
                                <span class="w-1/4 text-sm lg:text-base">{{ $consulta->fecha}}</span>
                                @if ($consulta->tipo_consulta == 'Otro')
                                    <span class="w-1/4 text-sm lg:text-base">{{ $consulta->detalles_consulta }}</span>
                                @else
                                    <span class="w-1/4 text-sm lg:text-base">{{ $consulta->tipo_consulta }}</span>
                                @endif
                                @if ($consulta->estado == 'Cancelada')
                                    <span class="w-1/4 text-sm lg:text-base">{{ $consulta->estado }}</span>
                                @else
                                    <span class="w-1/4 text-sm lg:text-base"></span>
                                @endif
                                <span class="w-1/4 text-sm lg:text-base">
                                    <a href="{{ route('consultas.show', ['id' => $consulta->id, 'lugar' => 'paciente']) }} ">
                                    <x-boton-editar>
                                        Ver
                                    </x-boton-editar>
                                    </a>
                                </span>

                            </li>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('searchInput').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                if (li.querySelector('span')) { // Ignora el encabezado de la tabla
                    let fecha = li.querySelector('span:nth-child(2)').textContent.toLowerCase();
                    let tipo = li.querySelector('span:nth-child(3)').textContent.toLowerCase();
                    let estado = li.querySelector('span:nth-child(4)').textContent.toLowerCase();
                    li.style.display = (fecha.includes(searchTerm) || tipo.includes(
                        searchTerm) || estado.includes(searchTerm)) ? '' : 'none';
                }
            });
        });

    });
</script>
