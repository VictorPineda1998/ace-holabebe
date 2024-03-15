<div>
    <div class="titulo-listado flex flex-col items-center">
        <h1 class='text-4xl font-bold mb-6 text-pink-400'>Pacientes registrados</h1>
    </div>
    <div>
        <div>
            <input type="text" id="searchInput"
                class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                placeholder="Buscar nombre o ...">
        </div>
        <div>
            <ul class="overflow-x-auto">
                @php
                    $i = 1;
                @endphp
                <div style="width: 900px">
                    <li class="flex items-center bg-pink-400 p-3">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                        <span class="w-1/4 text-sm lg:text-base">Nombre</span>
                        <span class="w-1/4 text-sm lg:text-base">Telefono</span>
                        <span class="w-1/4 text-sm lg:text-base">Edad</span>
                        <span class="w-1/4 text-sm lg:text-base">Opciones</span>
                    </li>
                    @foreach ($pacientes as $paciente)
                    <li class="flex items-center border-b py-2 bg-pink-{{$i % 2 != 0 ? '200' : '100'}}" style="padding: 1%">
                        <span class="text-sm lg:text-base" style="margin-right: 2%">{{ $paciente->id }}</span>
                        <span class="w-1/4 text-sm lg:text-base">{{ $paciente->nombre }}</span>
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
                    let nombre = li.querySelector('span:nth-child(2)').textContent.toLowerCase();
                    let telefonno = li.querySelector('span:nth-child(3)').textContent.toLowerCase();
                    let edad = li.querySelector('span:nth-child(4)').textContent
                        .toLowerCase();
                    li.style.display = (nombre.includes(searchTerm) || telefonno.includes(
                        searchTerm) || edad.includes(searchTerm)) ? '' : 'none';
                }
            });
        });

    });
</script>


