<x-app-layout>
    <x-slot name="header">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ route('pacientes') }} "
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Pacientes
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ route('pacientes.show', ['id' => $paciente->id]) }} "
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-purple-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Detalles del pacientes
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span
                        class="ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                        Archivos PDF
                    </span>
                </div>
            </li>
        </ol>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                <div class="titulo-listado flex flex-col items-center">
                    <h1 class='text-4xl font-bold mb-6 text-indigo-800'>Listado de archivos</h1>
                    <h1 class='text-2xl font-bold mb-6 text-indigo-800'>del paciente: {{ $paciente->nombre }}
                        {{ $paciente->apellido_P }} {{ $paciente->apellido_M }}</h1>
                </div>
                <x-validation-errors />
                <x-boton-editar id="agregar_archivo" class="justify-end mt-2 mb-2">
                    {{ __('Agregar archivo') }}
                </x-boton-editar>

                <div id="formArchivo" class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="display: none">
                    <form action="{{ route('archivos.store', $paciente->id) }}" method="post"
                        enctype="multipart/form-data" id="formRegistrar">

                        <x-label for="nombre"
                            value="{{ __('Nombre:   (Si gusta no colocar el nombre, se usara el nombre original del archivo)') }}"
                            class="mt-1 " />
                        @csrf
                        <x-input class="block mt-1 w-full md:w-1/2" type="text" name="nombre"
                            autocomplete="nombre" />
                        <x-label for="tipo" value="{{ __('Tipo:') }}" class="mt-1" />
                        <x-input class="block mt-1 w-full md:w-1/2" type="text" name="tipo" autocomplete="tipo"
                            required />
                        <input type="file" name="archivo" class="block mt-2 mb-2" required>
                        <div class="flex items-center justify-end mt-4 mb-8 w-full md:w-1/2">
                            <x-boton-cancelar id="cancelar" class="ms-4 me-2">
                                {{ __('Cancelar') }}
                            </x-boton-cancelar>
                            <x-button>Guardar</x-button>
                        </div>
                    </form>
                </div>
                <div>
                    <input type="text" id="searchInput"
                        class="mt-4 mb-4 p-2 w-full md:w-1/2 lg:w-1/3 border border-gray-300 rounded-md"
                        placeholder="Filtrar por nombre, tipo o fecha...">
                </div>
                <ul class="overflow-x-auto">
                    @php
                        $i = 1;
                    @endphp
                    <div class="w-full lg:w-[900px]">
                        <li class="hidden lg:flex items-center bg-blue-500 p-3 rounded-t-lg">
                            <span class="text-sm lg:text-base" style="margin-right: 1%">ID</span>
                            <span class="w-2/6 text-sm lg:text-base">Nombre</span>
                            <span class="w-1/6 text-sm lg:text-base">Tipo</span>
                            <span class="w-1/6 text-sm lg:text-base">Fecha</span>
                            <span class="w-2/6 text-sm lg:text-base">Opciones</span>
                        </li>
                        @foreach ($archivos as $archivo)
                            <li
                                class="rounded-lg flex flex-col lg:flex-row items-start lg:items-center border-b py-2 {{ $loop->odd ? 'bg-blue-100' : 'bg-white' }} p-4 lg:p-2 mb-4 lg:mb-0 lg:rounded-none">
                                <div class="flex w-full lg:w-auto mb-2 lg:mb-0" style="margin-right: 2%">
                                    <span class="font-bold lg:hidden">ID: </span>
                                    <span class="text-center ms-1 lg:text-base">{{ $archivo->id }}</span>
                                </div>
                                <div class="flex w-full lg:w-2/6 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Nombre: </span>
                                    <span class="text-center ms-1 lg:text-base">{{ $archivo->nombre }}</span>
                                </div>
                                <div class="flex w-full lg:w-1/6 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Tipo: </span>
                                    <span class="text-center ms-1 lg:text-base">{{ $archivo->tipo }}</span>
                                </div>
                                <div class="flex w-full lg:w-1/6 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Fecha: </span>
                                    <span
                                        class="text-center ms-1 lg:text-base">{{ $archivo->created_at->toDateString() }}</span>
                                </div>
                                <div class="flex w-full lg:w-2/6 mb-2 lg:mb-0">
                                    <span class="font-bold lg:hidden">Opciones: </span>
                                    <span class="flex text-center ms-1 lg:text-base">
                                        <a href="{{ $archivo->ruta }}" target="_blank">
                                            <x-boton-editar class="me-2">
                                                ver
                                            </x-boton-editar>
                                        </a>
                                        <x-boton-editar class="mostrarFormulario" data-boton="{{ $i }}">
                                            editar
                                        </x-boton-editar>
                                        <form
                                            action="{{ route('archivos.eliminar', ['id' => $archivo->id, 'paciente_id' => $archivo->paciente_id]) }}"
                                            method="POST" id="deleteArchivo">
                                            @csrf
                                            @method('DELETE')
                                            <x-boton-eliminar class="ms-2"
                                                onclick="event.preventDefault(); openConfirmModal(() => document.getElementById('deleteArchivo').submit(), '¿Estás seguro que deseas eliminar este archivo?', '{{ $archivo->nombre }}');">
                                                Eliminar
                                            </x-boton-eliminar>
                                        </form>
                                    </span>
                                </div>
                            </li>
                            <div id="myModal{{ $i }}" class="modal">
                                <div class="modal-content w-full md:w-1/2">
                                    <div>
                                        <span class="close"><x-boton-cancelar
                                                class="cerrarModal{{ $i }}">&times;</x-boton-cancelar></span>
                                        <form
                                            action="{{ route('archivos.update', ['id' => $archivo->id, 'paciente_id' => $archivo->paciente_id]) }}"
                                            method="POST" style="margin: 1%;" id="formularioConsulta"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <x-label for="nombreUpdate" value="{{ __('Nombre:') }}"
                                                class="mt-1 " />
                                            <x-input class="block mt-1 w-full " type="text" name="nombreUpdate"
                                                autocomplete="nombreUpdate" />
                                            <x-label for="tipoUpdate" value="{{ __('Tipo:') }}" class="mt-1" />
                                            <x-input class="block mt-1 w-full " type="text" name="tipoUpdate"
                                                autocomplete="tipoUpdate" />
                                            <input type="file" name="archivoUpdate" class="block mt-2 mb-2">
                                            <div class="flex mt-2 justify-end">
                                                <x-button class="mt-1 ">
                                                    {{ __('Aceptar') }}
                                                </x-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </div>
                </ul>
            </x-div-fondo>
        </div>
    </div>
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
    <script src="{{ asset('js/funciones-propias.js') }}"></script>
    <script>
        let creando = false;
        document.getElementById('agregar_archivo').addEventListener('click', function() {
            if (!creando) {
                document.getElementById('formArchivo').style.display = 'inline';
                deslizar('agregar_archivo');
                creando = true;
            } else {
                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById('formArchivo').style.display = 'none';
                }, 300);
                creando = false;
            }

            document.getElementById('cancelar').addEventListener('click', function() {

                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById('formArchivo').style.display = 'none';
                }, 300);
                creando = false;
            });
        });

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

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('searchInput').addEventListener('input', function() {
                let searchTerm = this.value.toLowerCase();
                document.querySelectorAll('ul > div > li:not(:first-child)').forEach(function(li) {
                    let fecha = li.querySelector('div:nth-child(2) > span:last-child').textContent
                        .toLowerCase();
                    let tipo = li.querySelector('div:nth-child(3) > span:last-child').textContent
                        .toLowerCase();
                    let estado = li.querySelector('div:nth-child(4) > span:last-child').textContent
                        .toLowerCase();
                    li.style.display = (fecha.includes(searchTerm) || tipo.includes(searchTerm) ||
                        estado.includes(searchTerm)) ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
