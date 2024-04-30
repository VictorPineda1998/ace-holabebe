<x-app-layout>

    {{-- <x-header></x-header> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-rose-200 overflow-hidden shadow-xl sm:rounded-lg" style="padding: 1%">

                <x-boton-mas id="mostrarRegistro">
                    {{ __('Registrar paciente') }}
                </x-boton-mas>

                <div id="formRegistrar" style="display: none">
                    <x-registrar-paciente :user="$user"/>
                </div>
                @if (isset($pacientes))
                    <x-lista-pacientes :pacientes="$pacientes" />
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/funciones-propias.js') }}"></script>

    <script>
        let creando = false;
        document.getElementById('mostrarRegistro').addEventListener('click', function() {
            if (!creando) {
                
                document.getElementById('formRegistrar').style.display = 'inline';
                deslizar('mostrarRegistro');
                creando = true;
            } else {
                deslizar('inicio');

                setTimeout(function() {
                    document.getElementById('formRegistrar').style.display = 'none';
                }, 300);
                creando = false;
            }
            document.getElementById('cancelar').addEventListener('click', function() {
                deslizar('inicio');
                setTimeout(function() {
                    document.getElementById('formRegistrar').style.display = 'none';
                }, 300);
                creando = false;
                // window.location.hash = '';
            });

            // Obtener la referencia a los elementos del formulario
            const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
            const edadInput = document.getElementById('edad');

            // Verificar si los elementos existen antes de agregar el event listener
            if (fechaNacimientoInput && edadInput) {
                // Agregar un event listener al campo de fecha de nacimiento
                fechaNacimientoInput.addEventListener('change', function() {
                    // Obtener la fecha de nacimiento del input
                    const fechaNacimiento = new Date(fechaNacimientoInput.value);

                    

                    // Validar que la fecha de nacimiento no sea en el futuro
                    const hoy = new Date();
                    if (fechaNacimiento > hoy) {
                        alert("Por favor, seleccione una fecha de nacimiento válida.");
                        fechaNacimientoInput.value = ''; // Puedes restablecer el valor si lo deseas
                        return;
                    }

                    // Calcular la edad
                    const edad = hoy.getFullYear() - fechaNacimiento.getFullYear();

                    // Actualizar el valor del campo de edad
                    edadInput.value = edad;
                });
            }

            const telefonoInput = document.getElementById('telefono');

            // Verificar si el elemento existe antes de agregar el event listener
            if (telefonoInput) {
                // Agregar un event listener al campo de teléfono
                telefonoInput.addEventListener('change', function() {
                    // Obtener el número de teléfono del input
                    const telefono = telefonoInput.value;

                    // Verificar si la longitud del número de teléfono es igual a 10
                    if (telefono.length !== 10) {
                        alert("Por favor, coloque un número de teléfono de 10 dígitos");
                        return;
                    }
                });
            }

        });
    </script>
</x-app-layout>
