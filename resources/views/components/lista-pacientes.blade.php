<div>
    <div class="titulo-listado flex flex-col items-center">
        <h1 class='text-3xl font-bold mb-6 text-pink-400'>Pacientes registrados</h1>
    </div>
    <div>
        <div>
            <ul class="overflow-x-auto">
                <div class="w-full lg:w-[950px]">
                    <div class="flex flex-col lg:flex-row">                        
                        <div class="flex flex-col lg:flex-row w-full lg:w-5/9">
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
                    <ul class="hidden lg:flex items-center bg-pink-500 p-3 rounded-t-lg">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                        <span class="w-3/12 text-sm lg:text-base">Nombre(s)</span>
                        <span class="w-2/12 text-sm lg:text-base">Apellido Paterno</span>
                        <span class="w-2/12 text-sm lg:text-base">Apellido Materno</span>
                        <span class="w-2/12 text-sm lg:text-base">Telefono</span>
                        <span class="w-2/12 text-sm lg:text-base">Edad</span>
                        <span class="w-1/12 text-sm lg:text-base">Opciones</span>
                    </ul>
                    @foreach ($pacientes as $paciente)
                        @php
                            // Calcular la edad a partir de la fecha de nacimiento
                            $fechaNacimiento = \Carbon\Carbon::parse($paciente->fecha_nacimiento);
                            $edad = $fechaNacimiento->diff(\Carbon\Carbon::now())->y;
                        @endphp
                        <li class="rounded-lg flex flex-col lg:flex-row items-start lg:items-center border-b py-2 {{ $loop->odd ? 'bg-pink-300' : 'bg-pink-200' }} p-4 lg:p-2 mb-4 lg:mb-0 lg:rounded-none">
                            <div class="flex w-full lg:w-auto mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">ID: </span>
                                <span class="text-center ms-1 lg:text-base lg:mr-2">{{ $paciente->id }}</span>
                            </div>
                            <div class="flex w-full lg:w-3/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Nombre(s): </span>
                                <span class="text-center ms-1 lg:text-base">{{ $paciente->nombre }}</span>
                            </div>
                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Apellido Paterno: </span>
                                <span class="text-center ms-1 lg:text-base">{{ $paciente->apellido_P }}</span>
                            </div>
                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Apellido Materno: </span>
                                <span class="text-center ms-1 lg:text-base"> {{ $paciente->apellido_M }}</span>
                            </div>
                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Telefono: </span>
                                <span class="text-center ms-1 lg:text-base">{{ $paciente->telefono }}</span>
                            </div>
                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Edad: </span>
                                <span class="text-center ms-1 lg:text-base">{{ $edad }} años</span>
                            </div>
                            <div class="flex w-full lg:w-1/12">
                                <a href="{{ route('pacientes.show', $paciente->id) }} ">
                                    <x-boton-editar class="boton-editar" style="margin: 0; display: inline;">
                                        Ver
                                    </x-boton-editar>
                                </a>
                            </div>
                        </li>
                    @endforeach
                    <div class="mt-2">                        
                        {{ $pacientes->appends(request()->query())->links() }}
                    </div>
                </div>
            </ul>
        </div>
    </div>
</div>
