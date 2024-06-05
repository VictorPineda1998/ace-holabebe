<div>
    <div class="titulo-listado flex flex-col items-center">
        <h1 class='text-4xl font-bold mb-6 text-indigo-800'>Usuarios registrados</h1>
    </div>
    <div>
        <div>
            <input type="text" id="searchInput"
                class="mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                placeholder="Buscar por ID, nombre, email o tipo de usuario...">
        </div>
        <div>
            <ul class="overflow-x-auto">
                @php
                    $i = 1;
                @endphp
                <div class="w-full lg:w-[1000px]">
                    <ul class="hidden lg:flex items-center bg-indigo-400 p-3 rounded-t-lg">
                        <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                        <span class="w-4/12 text-sm lg:text-base">Nombre</span>
                        <span class="w-4/12 text-sm lg:text-base">Email</span>
                        <span class="w-2/12 text-sm lg:text-base">Tipo de Usuario</span>
                        <span class="w-3/12 text-sm lg:text-base">Opciones</span>
                    </ul>
                    @foreach ($users as $user)
                        {{-- @if ($i % 2 == 0)
                            <li class="flex items-center border-b py-2 bg-gray-50" style="padding: 1%">
                            @else
                            <li class="flex items-center border-b py-2 bg-indigo-200" style="padding: 1%">
                        @endif --}}
                        <li 
                            class="rounded-lg flex flex-col lg:flex-row items-start lg:items-center border-b py-2 {{ $loop->odd ? 'bg-gray-50' : 'bg-indigo-200' }} p-4 lg:p-2 mb-4 lg:mb-0 lg:rounded-none">
                            <div class="flex w-full lg:w-auto mb-2 lg:mb-0" style="margin-right: 1%">
                                <span class="font-bold lg:hidden">ID: </span>
                                <span class="text-center ms-1 lg:text-base lg:mr-2">{{ $user->id }}</span>
                            </div>
                            <div class="flex w-full lg:w-4/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Nombre: </span>
                                <span class="text-center ms-1 lg:text-base">{{ $user->name }}</span>
                            </div>
                            <div class="flex w-full lg:w-4/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Email: </span>
                                <span class=" text-center ms-1 lg:text-base">{{ $user->email }}</span>
                            </div>
                            <div class="flex w-full lg:w-2/12 mb-2 lg:mb-0">
                                <span class="font-bold lg:hidden">Tipo de Usuario: </span>
                                <span class="text-center ms-1 lg:text-base">{{ $user->tipo_usuario }}</span>
                            </div>
                            <div class="flex w-full lg:w-3/12 mb-2 lg:mb-0">

                                <span class="text-center ms-1 lg:text-base">
                                    <div id="div{{ $i }}" style="margin: 0; display: inline;">
                                        <x-boton-editar class="boton-editar" data-boton="{{ $i }}"
                                            style="margin: 0; display: inline;">Editar</x-boton-editar>
                                        <form action="{{ route('usuarios.update', $user->id) }}" method="POST"
                                            onsubmit="return false;" style="margin: 1%; display: none;"
                                            class="tipo-usuario">
                                            @csrf
                                            @method('PUT')
                                            <x-label for="tipo_usuario" value="{{ __('Tipo de usuario:') }}"
                                                style="margin: 0; display: inline;" />
                                            <select id="tipo_usuario" name="tipo_usuario" required
                                                class="mt-1 w-full rounded-md bg-white py-2 pl-3 pr-10 text-gray-500 focus:ring-4 focus:ring-indigo-600"
                                                onchange="submitForm(this)">
                                                <option disabled selected class="text-gray-400 italic">Selecciona un
                                                    tipo de
                                                    usuario
                                                </option>
                                                <option value="Médico general">Médico General</option>
                                                <option value="Médico especialista">Médico Especialista</option>
                                                <option value="Enfermería consultorios">Enfermería Consultorios</option>
                                                <option value="Enfermería hospitalización">Enfermería Hospitalización
                                                </option>
                                                <option value="Contador">Contador</option>
                                                <option value="Administrador">Administrador</option>
                                            </select>
                                        </form>
                                        <x-boton-cancelar class="cancelar" data-boton="{{ $i }}"
                                            style="display: none;">Cancelar</x-boton-cancelar>

                                        <form action="{{ route('usuarios.eliminar', $user->id) }}" method="POST"
                                            id="deleteUser" style="display: inline;" class="boton-elimiar">
                                            @csrf
                                            @method('DELETE')
                                            <x-boton-eliminar
                                                onclick="event.preventDefault(); openConfirmModal(() => document.getElementById('deleteUser').submit(), '¿Estás seguro que deseas eliminar este usuario?', '{{ $user->name }}');">
                                                Eliminar
                                            </x-boton-eliminar>
                                        </form>

                                    </div>
                                </span>
                            </div>
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
        let idEditando = null;

        document.querySelectorAll('.boton-editar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (idEditando !== null) {
                    toggleEditState(idEditando, false);
                }
                idEditando = this.getAttribute('data-boton');
                toggleEditState(idEditando, true);
            });
        });

        document.querySelectorAll('.cancelar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                let botonId = this.getAttribute('data-boton');
                toggleEditState(botonId, false);
            });
        });

        function toggleEditState(botonId, isEditing) {
            let div = document.getElementById('div' + botonId);
            div.querySelector('.boton-editar').style.display = isEditing ? 'none' : 'inline';
            div.querySelector('.boton-elimiar').style.display = isEditing ? 'none' : 'inline';
            div.querySelector('.tipo-usuario').style.display = isEditing ? 'block' : 'none';
            div.querySelector('.cancelar').style.display = isEditing ? 'inline' : 'none';
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                if (li.querySelector('span')) { // Ignora el encabezado de la tabla
                    let id = li.querySelector('span:nth-child(1)').textContent.toLowerCase();
                    let name = li.querySelector('span:nth-child(2)').textContent.toLowerCase();
                    let email = li.querySelector('span:nth-child(3)').textContent.toLowerCase();
                    let tipo_usuario = li.querySelector('span:nth-child(4)').textContent
                        .toLowerCase();
                    li.style.display = (id.includes(searchTerm) || name.includes(searchTerm) ||
                        email.includes(
                            searchTerm) || tipo_usuario.includes(searchTerm)) ? '' : 'none';
                }
            });
        });

    });

    function submitForm(selectElement) {
        selectElement.closest('form').submit();
    }
</script>
