<form id="formDiagnostico" method="POST"
    action="{{ $consulta->diagnostico ? route('diagnostico.update', $consulta->diagnostico_id) : route('diagnostico.store', $consulta->id) }}">
    @csrf

    @if ($consulta->diagnostico)
        @method('PUT')
        <div class="flex items-center justify-start mt-3 mb-3">
            <x-boton-mas id="imprimirDiagnostico">Convertir a pdf</x-boton-mas>
        </div>
    @endif
    <div class="grid lg:grid-cols-2">
        <div {{-- class="w-1/2" --}}class="overflow-x-auto">
            <h1 class='text-1xl font-bold mb-3 text-purple-800'>Diagnostico:</h1>
            <textarea oninput="autoNewLine(this)" id="diagnostico" name="diagnostico" class="rounded-md " rows="8"
                cols="57">{{ $consulta->diagnostico ? $consulta->diagnostico->diagnostico : '' }}</textarea>
        </div>
        <div {{-- class="w-1/2" --}}class="overflow-x-auto">
            <h1 class='text-1xl font-bold mb-3 text-purple-800'>Receta medica:</h1>
            <textarea oninput="autoNewLine(this)" id="receta_medica" name="receta_medica" class="rounded-md" rows="8"
                cols="57">{{ $consulta->diagnostico ? $consulta->diagnostico->receta_medica : '' }}</textarea>
        </div>
    </div>
    <div class="flex items-center justify-end mt-4">
        @if (
            $consulta->diagnostico &&
                (auth()->user()->tipo_usuario == 'Administrador' || auth()->user()->tipo_usuario == 'Medico especialista'))
            <div class="flex items-center justify-end mt-4" id="divEditarDiagnostico">
                <x-boton-editar id="btnEditarDiagnostico">{{ 'Editar' }}</x-boton-editar>
            </div>
            <div id="divCancelarDiagnostico" style="display: none; margin: 2%">
                <x-boton-cancelar id="btnCancelarDiagnostico">{{ 'Cancelar' }}</x-boton-cancelar>
            </div>
        @endif
        <div id="div_button_diagnostico">
            <x-boton-mas type="submit"
                id="guardarDiagnostico">{{ $consulta->diagnostico ? 'Guardar cambios' : 'Guardar' }}</x-boton-mas>
        </div>
    </div>
</form>
<script src="{{ asset('js/generarDiagnosticoPDF.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    let diagnostico = @json($consulta->diagnostico);
    let editandoDiagnostico = false;

    let paciente = @json($consulta->paciente);

    let imgDiagnostico = "{{ asset('img-empresa/fondo-diagnostico.jpg') }}";

    if (diagnostico && !editandoDiagnostico) {
        document.getElementById('diagnostico').setAttribute('readonly', true);
        document.getElementById('receta_medica').setAttribute('readonly', true);
        let div_button_diagnostico = document.getElementById('div_button_diagnostico');
        if (div_button_diagnostico) {
            div_button_diagnostico.style.display = 'none';
        }
    }

    let btnEditarDiagnostico = document.getElementById('btnEditarDiagnostico');
    if (btnEditarDiagnostico) {
        btnEditarDiagnostico.addEventListener('click', function() {
            document.getElementById('divEditarDiagnostico').style.display = 'none';
            document.getElementById('div_button_diagnostico').style.display = 'inline';
            document.getElementById('divCancelarDiagnostico').style.display = 'inline';
            document.getElementById('diagnostico').removeAttribute('readonly');
            document.getElementById('receta_medica').removeAttribute('readonly');
            editandoDiagnostico = true;
        });
    }

    let btnCancelarDiagnostico = document.getElementById('btnCancelarDiagnostico');
    if (btnCancelarDiagnostico) {
        btnCancelarDiagnostico.addEventListener('click', function() {
            location.reload();
        });
    }

    let imprimirDiagnostico = document.getElementById('imprimirDiagnostico');
    if (imprimirDiagnostico) {
        imprimirDiagnostico.addEventListener('click', function() {

            generarDiagnosticoPDF(diagnostico, paciente, triaje, imgDiagnostico);
        });
    }

    function autoNewLine(textArea) {
        const maxLineLength = 65;
        let lines = textArea.value.split('\n');
        let modified = false;

        for (let i = 0; i < lines.length; i++) {
            if (lines[i].length > maxLineLength) {
                let spaceIndex = lines[i].lastIndexOf(' ', maxLineLength);
                if (spaceIndex === -1) spaceIndex = maxLineLength; // Si no hay espacio, corta en el límite máximo
                lines[i] = lines[i].substring(0, spaceIndex) + '\n' + lines[i].substring(spaceIndex).trim();
                modified = true;
            }
        }

        if (modified) {
            textArea.value = lines.join('\n');
        }
    }

    // Verifica si 'diagnostico' es null
    if (diagnostico == null) {
        let guardarDiagnostico = document.getElementById('guardarDiagnostico');

        if (guardarDiagnostico) {
            guardarDiagnostico.addEventListener('click', function(event) {
                // Previene el comportamiento por defecto del botón, que es enviar el formulario
                event.preventDefault();

                // Captura el contenido del formulario 'formDiagnostico'
                let formElement = document.getElementById('formDiagnostico');
                let formData = new FormData(formElement);
                
                diagnostico = {
                    diagnostico: formData.get('diagnostico'),
                    receta_medica: formData.get('receta_medica')
                };
                // Aquí podrías hacer procesamiento adicional como generar un PDF
                generarDiagnosticoPDF(diagnostico, paciente, triaje, imgDiagnostico);

                // Finalmente, enviar el formulario programáticamente si todo está correcto
                formElement.submit();
            });
        }
    }
</script>
