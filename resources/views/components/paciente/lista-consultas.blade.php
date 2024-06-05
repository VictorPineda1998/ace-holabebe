<div>
    <div>
        <div>
            <h1 class='text-1xl font-bold mb-3 text-purple-800'>Buscar en esta coleccion:</h1>
            <input type="text" id="searchInput" name="searchInput"
                class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                placeholder="Filtrar por fecha o tipo ...">
        </div>
        <div>
            <ul class="overflow-x-auto">
                <div class="w-full lg:w-[900px]">
                    <li class="hidden lg:flex items-center bg-amber-300 p-3 rounded-t-lg">
                        <span class="text-sm lg:text-base" style="margin-right: 2%">ID</span>
                        <span class="w-1/4 text-sm lg:text-base">Fecha</span>
                        <span class="w-1/4 text-sm lg:text-base">Tipo de consulta</span>
                        <span class="w-1/4 text-sm lg:text-base">Detalle</span>
                        <span class="w-1/4 text-sm lg:text-base">Opciones</span>
                    </li>
                    @foreach ($consultas as $consulta)
                        @if ($consulta->estado == 'Finalizada' or $consulta->estado == 'Cancelada')
                            <li
                                class="rounded-lg flex flex-col lg:flex-row items-start lg:items-center border-b py-2 {{ $loop->odd ? 'bg-amber-100' : 'bg-white' }} p-4 lg:p-2 mb-4 lg:mb-0 lg:rounded-none">
                                <div class="flex w-full lg:w-auto mb-2 lg:mb-0" style="margin-right: 2%">
                                    <span class="font-bold lg:hidden">ID: </span>
                                    <span class="text-center ms-1 lg:text-base">{{ $consulta->id }}</span>
                                </div>
                                <div class="flex w-full lg:w-1/4 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Fecha: </span>
                                    <span class="text-center ms-1 lg:text-base">{{ $consulta->fecha }}</span>
                                </div>
                                <div class="flex w-full lg:w-1/4 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Tipo de consulta: </span>
                                    @if ($consulta->tipo_consulta == 'Otro')
                                        <span
                                            class="text-center ms-1 lg:text-base">{{ $consulta->detalles_consulta }}</span>
                                    @else
                                        <span
                                            class="text-center ms-1 lg:text-base">{{ $consulta->tipo_consulta }}</span>
                                    @endif
                                </div>
                                <div class="flex w-full lg:w-1/4 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Detalle: </span>
                                    <span class="text-center ms-1 lg:text-base">{{ $consulta->estado }}</span>
                                </div>
                                <div class="flex w-full lg:w-1/4 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Opciones: </span>
                                    <span class="text-center ms-1 lg:text-base">
                                        <a
                                            href="{{ route('consultas.show', ['id' => $consulta->id, 'lugar' => 'paciente']) }}">
                                            <x-boton-editar>Ver</x-boton-editar>
                                        </a>
                                    </span>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </div>
            </ul>
            <div class="mt-3">{{ $consultas->links() }}</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('searchInput').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                let fecha = li.querySelector('div:nth-child(2) > span:last-child').textContent.toLowerCase();
                let tipo = li.querySelector('div:nth-child(3) > span:last-child').textContent.toLowerCase();
                let estado = li.querySelector('div:nth-child(4) > span:last-child').textContent.toLowerCase();
                li.style.display = (fecha.includes(searchTerm) || tipo.includes(searchTerm) || estado.includes(searchTerm)) ? '' : 'none';
            });
        });
    });
</script>
