<form id="paciente-form" method="POST" action="{{ route('pacientes.update', $paciente->id) }}">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-7 gap-6">
        <div>
            <x-label for="nombre" value="{{ __('Nombre') }}" />
            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required
                value="{{ $paciente->nombre }}" autofocus autocomplete="nombre"  readonly />
        </div>
        <div>
            <x-label for="apellidoP" value="{{ __('Apellido Paterno') }}" />
            <x-input id="apellidoP" class="block mt-1 w-full" type="text" name="apellidoP" :value="old('apellidoP')" required
                value="{{ $paciente->apellido_P }}" autofocus autocomplete="apellidoP" readonly />
        </div>
        <div>
            <x-label for="apellidoM" value="{{ __('Apellido Materno') }}" />
            <x-input id="apellidoM" class="block mt-1 w-full" type="text" name="apellidoM" :value="old('apellidoM')" required
                value="{{ $paciente->apellido_M }}" autofocus autocomplete="apellidoM" readonly />
        </div>

        <div>
            <x-label for="telefono" value="{{ __('Telefono') }}" />
            <x-input id="telefono" class="block mt-1 w-full" type="number" name="telefono"
                value="{{ $paciente->telefono }}" readonly />
        </div>

        <div>
            <x-label for="fecha_nacimiento" value="{{ __('Fecha de nacimiento') }}" />
            <x-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento"
                value="{{ $paciente->fecha_nacimiento }}" required autocomplete="fecha_nacimiento" readonly />
        </div>

        <div>
            <x-label for="edad" value="{{ __('Edad') }}" />
            <x-input id="edad" class="block mt-1 w-full" type="number" name="edad"
                value="{{ $paciente->edad }}" required autocomplete="edad" readonly />
        </div>

        <div>
            <x-label for="lugar_procedencia" value="{{ __('Lugar de procedencia') }}" />
            <x-input id="lugar_procedencia" class="block mt-1 w-full" type="text" name="lugar_procedencia"
                value="{{ $paciente->lugar_procedencia }}" required autocomplete="new-lugar_procedencia" readonly />
        </div>
    </div>
    <div class="flex items-center justify-end mt-4">
        <div class=" flex items-end" id="editar-btn">
            <div class="flex items-center">
                <h1 class='text-1xl font-bold mb-2 text-purple-800'>Editar los datos generales del paciente:</h1>
            </div>
            <div class="flex items-center ms-3">
                    <x-boton-editar>
                        &nbsp;&nbsp;Editar&nbsp;&nbsp;
                    </x-boton-editar>
            </div>
        </div>
        <x-boton-cancelar id="cancelar" class="ms-4" style="display: none;">
            {{ __('Cancelar') }}
        </x-boton-cancelar>

        <x-boton-actualizar class="ms-4" style="display: none;">
            {{ __('Guardar') }}
        </x-boton-actualizar>
    </div>
</form>
<script>
    document.getElementById('editar-btn').addEventListener('click', function() {
        // Habilitar la edición de los campos
        document.querySelectorAll('#paciente-form input:not([name="edad"])').forEach(function(input) {
            input.removeAttribute('readonly');
        });


        // Mostrar el botón de guardar y ocultar el botón de editar
        document.getElementById('botonActualizar').style.display = 'inline';
        document.getElementById('cancelar').style.display = 'inline';
        this.style.display = 'none';
    });
    document.getElementById('cancelar').addEventListener('click', function() {
        location.reload();
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
    }
</script>
