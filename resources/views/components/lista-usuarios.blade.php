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
            <div style="display: flex; align-items: center;">
                <li>
                    {{ $user->name }} - {{ $user->email }} - {{ $user->tipo_usuario }}
                    <p id="{{ $i }}" style="margin: 0; display: inline;"></p>
                    @php
                        $i++;
                    @endphp
                    <x-boton-mas id="{{ $i }}">Editar tipo de usuario</x-boton-mas>
                    <x-boton-mas>Eliminar</x-boton-mas>
                    {{-- <form action="{{ route('usuario.eliminar', ['id' => $user->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <x-boton-mas><a href="{{ route('usuario.editar', ['id' => $user->id]) }}">Editar</a></x-boton-mas>
                    <x-button type="submit">Eliminar</x-button>
                </form> --}}
                </li>
            </div>
        @endforeach
    </ul>
</div>

<script>
    document.getElementById({{ $i }}).addEventListener('click', function() {
                document.getElementById({{ $i }}).innerHTML = `
            <select id="tipo_usuario" name="tipo_usuario" class="block mt-1 w-full" required>
    <option value="enfermero">Enfermero</option>
    <option value="administrador">Administrador</option>
    <option value="medico">Médico</option>
    <option value="contador">Contador</option>
</select>
            `
});
</script>
