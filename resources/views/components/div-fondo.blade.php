@if (auth()->user()->tipo_usuario == 'Administrador')
    <div class="overflow-hidden  bg-teal-500 shadow-xl sm:rounded-lg p-6">
@else
        <div class="overflow-hidden shadow-xl sm:rounded-lg p-6"
            style="background-image: url('{{ asset('img-empresa/fondo.jpg') }}'); background-size: cover;">
@endif

{{ $slot }}
</div>
