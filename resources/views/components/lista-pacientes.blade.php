<div>
    <div class="titulo-listado flex flex-col items-center">
        <h1 class='text-3xl font-bold mb-6 text-pink-400'>Pacientes registrados</h1>
    </div>
    <div>

        <div>
            <ul class="overflow-x-auto">
                @php
                    $i = 1;
                @endphp
                <div style="width: 950px">
                    <div class="flex">
                        <div class="flex w-4/9">
                            <div class="flex items-center">
                                <h1 class='text-1xl font-bold mb-3 text-purple-800'>Buscar en esta coleccion:</h1>
                            </div>
                            <div class="flex items-center ms-0 w-full">
                                <input type="text" id="searchInput"
                                    class="mb-4 w-full border border-gray-300 rounded-md"
                                    placeholder="Buscar coincidencias">
                            </div>
                        </div>

                        <div class="flex w-5/9">
                            <div class="flex items-center ms-2">
                                <h1 class='text-1xl font-bold mb-3 text-purple-800'>Buscar en todos los registros:</h1>
                            </div>
                            <div class="flex items-center ms-1">
                                <form action="{{ route('pacientes') }}" method="GET">
                                    <input class="mb-4 border border-gray-300 rounded-md" type="text" name="search"
                                        placeholder="Solo nombre(s)" value="{{ request()->search }}">
                                    <x-boton-mas type="submit">Buscar</x-boton-mas>
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="flex items-center bg-pink-500 p-3 rounded-t-lg">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                        <span class="w-3/6 text-sm lg:text-base">Nombre</span>
                        <span class="w-1/6 text-sm lg:text-base">Telefono</span>
                        <span class="w-1/6 text-sm lg:text-base">Edad</span>
                        <span class="w-1/6 text-sm lg:text-base">Opciones</span>
                    </ul>
                    @foreach ($pacientes as $paciente)
                        <li class="flex items-center border-b py-2 {{ $i % 2 != 0 ? 'bg-pink-300' : 'bg-pink-200' }}"
                            style="padding: 1%">
                            <span class="text-sm lg:text-base" style="margin-right: 2%">{{ $paciente->id }}</span>
                            <span class="w-3/6 text-sm lg:text-base">{{ $paciente->nombre }} {{ $paciente->apellido_P }}
                                {{ $paciente->apellido_M }}</span>
                            <span class="w-1/6 text-sm lg:text-base">{{ $paciente->telefono }}</span>
                            <span class="w-1/6 text-sm lg:text-base">{{ $paciente->edad }} años</span>
                            <span class="w-1/6 text-sm lg:text-base">
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
            let searchTerm2 = quitarAcentos(searchTerm);

            document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                if (li.querySelector('span')) { // Ignora el encabezado de la tabla
                    let nombre = quitarAcentos(li.querySelector('span:nth-child(2)')
                            .textContent)
                        .toLowerCase();
                    let telefono = quitarAcentos(li.querySelector('span:nth-child(3)')
                            .textContent)
                        .toLowerCase();
                    let edad = quitarAcentos(li.querySelector('span:nth-child(4)').textContent)
                        .toLowerCase();
                    li.style.display = (nombre.includes(searchTerm2) || telefono.includes(
                        searchTerm2) || edad.includes(searchTerm2)) ? '' : 'none';
                }
            });

            function quitarAcentos(texto) {
                return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            }
        });



    });
</script>
