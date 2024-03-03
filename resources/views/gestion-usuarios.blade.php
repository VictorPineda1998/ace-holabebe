<x-app-layout>

    <x-header></x-header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 1%">
                {{-- @if (!isset($user) and isset($users)) --}}
                <x-boton-mas id="mostrarRegistro" class="ms-4">
                    {{ __('Agregar usuario') }}
                </x-boton-mas>
                {{-- @endif --}}
                <p id="cambio" class="border-b-2 pb-2 mb-4"></p>
                @if (isset($users))
                    <x-lista-usuarios :users="$users" />
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>
    {{-- @if (isset($user) and !isset($users))
        <script>
            window.onload = function() {
                document.getElementById("cambio").innerHTML = `
                <div id="cambio2">
                    <x-editar-usuario :user="$user"/>
                </div>
            `
            deslizar('form-editar');
            };
        </script>
    @endif --}}

    @if (!$errors->isEmpty())
        <script>
            window.onload = function() {
                document.getElementById("mostrarRegistro").click();
            };
        </script>
    @endif
    <script>
        let creando = false;
        document.getElementById('mostrarRegistro').addEventListener('click', function() {
            if (!creando) {
                document.getElementById("cambio").innerHTML = `
                <div id="cambio2">
                    <x-register/>
                </div>
            `
                deslizar('mostrarRegistro');
                creando = true;
            } else {
                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById("cambio2").innerHTML = `
                        <p id="cambio"></p>
                    `;
                }, 300);
                creando = false;
            }

            document.getElementById('cancelar').addEventListener('click', function() {

                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById("cambio2").innerHTML = `
                        <p id="cambio"></p>
                    `;
                }, 300);
                creando = false;
                // window.location.hash = '';
            });
        });
    </script>
</x-app-layout>
