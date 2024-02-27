<x-app-layout>

    <x-header></x-header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- @if (!isset($user) and isset($users)) --}}
                <x-boton-mas id="mostrarRegistro" class="ms-4">
                    {{ __('Agregar usuario') }}
                </x-boton-mas>
                {{-- @endif --}}
                <p id="cambio"></p>
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
        document.getElementById('mostrarRegistro').addEventListener('click', function() {
            document.getElementById("cambio").innerHTML = `
                <div id="cambio2">
                    <x-register/>
                </div>
            `
            deslizar('mostrarRegistro');

            document.getElementById('cancelar').addEventListener('click', function() {

                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById("cambio2").innerHTML = `
                        <p id="cambio"></p>
                    `;
                }, 300);
                // window.location.hash = '';
            });
        });
    </script>
</x-app-layout>
