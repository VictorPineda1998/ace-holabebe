<form id="formNota" method="POST"
    action="{{ $consulta->nota ? route('nota.update', $consulta->nota_id) : route('nota.store', $consulta->id) }}">
    @csrf

    @if ($consulta->nota)
        @method('PUT')
    @endif
    <h1 class='text-1xl font-bold mb-3 text-purple-800'>Notas:</h1>
    <textarea id="contenido" name="contenido" class="rounded-md w-full" rows="8">{{ $consulta->nota ? $consulta->nota->contenido : '' }}</textarea>

    <div class="flex items-center justify-end">
        @if ($consulta->nota)
            <div class="flex items-center justify-end mt-4" id="divEditarNota">
                <x-boton-editar id="btnEditarNota">{{ 'Editar' }}</x-boton-editar>
            </div>
            <div id="divCancelarNota" style="display: none; margin: 2%">
                <x-boton-cancelar id="btnCancelarNota">{{ 'Cancelar' }}</x-boton-cancelar>
            </div>
        @endif
        <div id="div_button_nota">
            <x-boton-mas type="submit"
                id="guardarNota">{{ $consulta->nota ? 'Guardar cambios' : 'Guardar' }}</x-boton-mas>
        </div>
    </div>
</form>
<script>
    let nota = @json($consulta->nota);
    let editandoNota = false;

    if (nota && !editandoNota) {
        document.getElementById('contenido').setAttribute('readonly', true);
        let div_button_nota = document.getElementById('div_button_nota');
        if (div_button_nota) {
            div_button_nota.style.display = 'none';
        }
    }
    let btnEditarNota = document.getElementById('btnEditarNota');
    if (btnEditarNota) {
        btnEditarNota.addEventListener('click', function() {
            document.getElementById('divEditarNota').style.display = 'none';
            document.getElementById('div_button_nota').style.display = 'inline';
            document.getElementById('divCancelarNota').style.display = 'inline';
            document.getElementById('contenido').removeAttribute('readonly');
            editandoNota = true;
        });
    }

    let btnCancelarNota = document.getElementById('btnCancelarNota');
    if (btnCancelarNota) {
        btnCancelarNota.addEventListener('click', function() {
            location.reload();
        });
    }
</script>
