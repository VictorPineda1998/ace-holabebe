<div>
    <div class="titulo-listado flex flex-col items-center">
        <h1 class='text-4xl font-bold mb-6 text-pink-400'>Pacientes registrados</h1>
    </div>
    <div>
    
        <div>
            <ul class="overflow-x-auto">
                @php
                    $i = 1;
                @endphp
                <div style="width: 900px">
                    <div class="flex">
                        <div class="flex w-1/2">
                            <div class="flex items-center">
                                <h1 class='text-1xl font-bold mb-3 text-purple-800'>Buscar en esta coleccion:</h1>
                            </div>
                            <div class="flex items-center ms-0 w-full">
                                <input type="text" id="searchInput" class="mb-4 p-2 w-full border border-gray-300 rounded-md"
                                    placeholder="Buscar por nombre, telefono o edad...">
                            </div>
                        </div>
            
                        <div class="flex w-1/2">
                            <div class="flex items-center ms-3">
                                <h1 class='text-1xl font-bold mb-3 text-purple-800'>Buscar por nombre:</h1>
                            </div>
                            <div class="flex items-center ms-2">
                                <form action="{{ route('pacientes') }}" method="GET">
                                    <input class="mb-4 p-2  border border-gray-300 rounded-md"
                                        type="text" name="search" placeholder="(sin apellidos) "
                                        value="{{ request()->search }}">
                                    <x-boton-mas type="submit">Buscar</x-boton-mas>
                                </form>
                            </div>
                        </div>
                    </div>
                    <li class="flex items-center bg-pink-500 p-3">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                        <span class="w-1/4 text-sm lg:text-base">Nombre</span>
                        <span class="w-1/4 text-sm lg:text-base">Telefono</span>
                        <span class="w-1/4 text-sm lg:text-base">Edad</span>
                        <span class="w-1/4 text-sm lg:text-base">Opciones</span>
                    </li>
                    @foreach ($pacientes as $paciente)
                        <li class="flex items-center border-b py-2 {{ $i % 2 != 0 ? 'bg-pink-300' : '' }}"
                            style="padding: 1%">
                            <span class="text-sm lg:text-base" style="margin-right: 2%">{{ $paciente->id }}</span>
                            <span class="w-1/4 text-sm lg:text-base">{{ $paciente->nombre }} {{ $paciente->apellido_P }}
                                {{ $paciente->apellido_M }}</span>
                            <span class="w-1/4 text-sm lg:text-base">{{ $paciente->telefono }}</span>
                            <span class="w-1/4 text-sm lg:text-base">{{ $paciente->edad }} años</span>
                            <span class="w-1/4 text-sm lg:text-base">
                                <a href="{{ route('pacientes.show', $paciente->id) }} ">
                                    <x-boton-editar class="boton-editar" style="margin: 0; display: inline;">
                                        Ver
                                    </x-boton-editar>
                                </a>
                            </span>
                        </li>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <div class="mt-2">
                        {{-- {{ $pacientes->links() }} --}}
                        {{ $pacientes->appends(request()->query())->links() }}
                    </div>
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
                    let nombre = li.querySelector('span:nth-child(2)').textContent
                        .toLowerCase();
                    let telefonno = li.querySelector('span:nth-child(3)').textContent
                        .toLowerCase();
                    let edad = li.querySelector('span:nth-child(4)').textContent
                        .toLowerCase();
                    li.style.display = (nombre.includes(searchTerm) || telefonno.includes(
                        searchTerm) || edad.includes(searchTerm)) ? '' : 'none';
                }
            });
        });

    });
</script>
