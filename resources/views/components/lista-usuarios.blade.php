<div>
    <h2>Listado de Usuarios</h2>
    <ul>
        Nombre - email - tipo de usuario
    </ul>
    <ul>
        @php
            $i = 1;
        @endphp
        @foreach ($users as $user)
            <li>
                {{ $user->name }} - {{ $user->email }} - {{ $user->tipo_usuario }}
                <div id="div{{ $i }}" style="margin: 0; display: inline;">
                    <x-boton-mas class="boton-editar" data-boton="{{ $i }}">Editar tipo deusuario</x-boton-mas>
                    <x-boton-mas class="cancelar" data-boton="{{ $i }}" style="display: none;">Cancelar</x-boton-mas>
                </div>
                <form action="{{ route('usuarios.eliminar', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" style="margin: 0; display: inline;">
                    @csrf
                    @method('DELETE')
                    <x-boton-mas type="submit" class="boton-mas">Eliminar</x-boton-mas>
                </form>
            </li>
            @php
                $i++;
            @endphp
        @endforeach
    </ul>
</div>

<script>
    var ultimoBotonEditarClicado = null;

    document.addEventListener('click', function(event) {
        var botonEditar = event.target.closest('.boton-editar');

        if (botonEditar) {
            var buttonNumber = botonEditar.getAttribute('data-boton');

            // Restaurar el contenido original del último botón clicado
            if (ultimoBotonEditarClicado) {
                var ultimoButtonNumber = ultimoBotonEditarClicado.getAttribute('data-boton');
                var ultimoParagraphElement = document.getElementById('div' + ultimoButtonNumber);
                ultimoParagraphElement.innerHTML = `
                    <x-boton-mas class="boton-editar" data-boton="${ultimoButtonNumber}">Editar tipo de usuario</x-boton-mas>
                    <x-boton-mas class="cancelar" data-boton="${ultimoButtonNumber}" style="display: none;">Cancelar</x-boton-mas>
                `;
            }

            // Actualizar el último botón clicado
            ultimoBotonEditarClicado = botonEditar;

            // Mostrar el contenido editable para el botón actual
            var paragraphElement = document.getElementById('div' + buttonNumber);
            paragraphElement.innerHTML = `
            <form action="{{ route('usuarios.update', $user->id) }}" method="POST" onsubmit="return false;" style="margin: 0; display: inline;">
                @csrf
                @method('PUT')
                <x-label for="tipo_usuario" value="{{ __('Tipo de usuario:') }}" style="margin: 0; display: inline;"/>
                <select id="tipo_usuario" name="tipo_usuario" required onchange="submitForm(this)"">
                    <option>Selecciona un tipo de usuario</option>
                    <option value="Médico general">Médico General</option>
                    <option value="Médico especialista">Médico Especialista</option>
                    <option value="Enfermería consultorios">Enfermería Consultorios</option>
                    <option value="Enfermería hospitalización">Enfermería Hospitalización</option>
                    <option value="Contador">Contador</option>                
                    <option value="Administrador">Administrador</option>
                </select>
            </form>
            <x-boton-mas class="cancelar" data-boton="${buttonNumber}">Cancelar</x-boton-mas>
            
            `;
        }
    });

    document.addEventListener('click', function(event) {
        var botonCancelar = event.target.closest('.cancelar');

        if (botonCancelar) {
            var buttonNumber = botonCancelar.getAttribute('data-boton');
            var paragraphElement2 = document.getElementById('div' + buttonNumber);

            if (paragraphElement2) {
                
                paragraphElement2.innerHTML = `
                    <x-boton-mas class="boton-editar" data-boton="${buttonNumber}">Editar tipo de usuario</x-boton-mas>
                    <x-boton-mas class="cancelar" data-boton="${buttonNumber}" style="display: none;">Cancelar</x-boton-mas>
                `;
                ultimoBotonEditarClicado = null;
            }
        }
    });

    function submitForm(selectElement) {
        selectElement.closest('form').submit();
    }
</script>
