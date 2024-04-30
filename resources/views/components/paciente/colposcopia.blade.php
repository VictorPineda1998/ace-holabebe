<div id="imageContainer"></div>
<form id="formColposcopia" method="POST"
    action="{{ $colposcopia ? route('colposcopia.update', $consulta->colposcopia_id) : route('colposcopia.store', $consulta->id) }}">
    @csrf
    @if ($colposcopia)
        @method('PUT')
        <div class="flex items-center justify-start mt-3 mb-3">
            <x-boton-mas id="imprimir">convertir a pdf</x-boton-mas>
        </div>
    @endif
    <div class="div_colposcopia">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                <tr>
                    <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Antecedentes heredofamiliares</th>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">Cancer:</td>
                    <td class="border-indigo-600 border-2 {{-- bg-red-400 --}} px-4 py-2">
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="cancer" value="Si" />
                            <span>No</span>
                            <input type="radio" name="cancer" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Diabetes:</td>
                    <td class="border-indigo-600 border-2 {{-- bg-green-300 --}} px-4 py-2">
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="diabetes_heredica" value="Si" />
                            <span>No</span>
                            <input type="radio" name="diabetes_heredica" value="No" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Antecedentes patologicos personales
                    </th>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">H A S:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="has" value="Si" />
                            <span>No</span>
                            <input type="radio" name="has" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Cardiopatia:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="cardiopatia" value="Si" />
                            <span>No</span>
                            <input type="radio" name="cardiopatia" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Tabaquismo:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="tabaquismo" value="Si" />
                            <span>No</span>
                            <input type="radio" name="tabaquismo" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Hipertension:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="hipertension" value="Si" />
                            <span>No</span>
                            <input type="radio" name="hipertension" value="No" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">Alcoholismo:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="alcoholismo" value="Si" />
                            <span>No</span>
                            <input type="radio" name="alcoholismo" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Diabetes:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="diabetes" value="Si" />
                            <span>No</span>
                            <input type="radio" name="diabetes" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Alergicos:
                        <div class="flex items-center justify-between">
                            <x-input id="alergicos" class="block w-full" type="text" name="alergicos" required
                                value="{{ $colposcopia ? $colposcopia->app->alergicos : '' }}" autofocus
                                autocomplete="alergicos" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Otros:
                        <div class="flex items-center justify-between">
                            <x-input id="otros" class="block w-full" type="text" name="otros" required
                                value="{{ $colposcopia ? $colposcopia->app->otros : '' }}" autofocus
                                autocomplete="otros" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Antecedentes gineco-obstetricos</th>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">Menarca:
                        <div class="flex items-center justify-between">
                            <x-input id="menarca" class="block w-3/4" type="number" name="menarca" required
                                value="{{ $colposcopia ? $colposcopia->ago->menarca : '' }}" autofocus
                                autocomplete="menarca" />Años
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Ritmo:
                        <div class="flex items-center justify-between">
                            <x-input id="ritmo" class="block w-full" type="text" name="ritmo" required
                                value="{{ $colposcopia ? $colposcopia->ago->ritmo : '' }}" autofocus
                                autocomplete="ritmo" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">IVSA:
                        <div class="flex items-center justify-between">
                            <x-input id="ivsa" class="block w-3/4" type="number" name="ivsa" required
                                value="{{ $colposcopia ? $colposcopia->ago->ivsa : '' }}" autofocus
                                autocomplete="ivsa" /> Años
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Parejas sexuales:
                        <div class="flex items-center justify-between">
                            <x-input id="pSexuales" class="block w-full" type="text" name="pSexuales" required
                                value="{{ $colposcopia ? $colposcopia->ago->pSexuales : '' }}" autofocus
                                autocomplete="pSexules" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">Gestas:
                        <div class="flex items-center justify-between">
                            <x-input id="gestas" class="block w-full" type="number" name="gestas" required
                                value="{{ $colposcopia ? $colposcopia->ago->gestas : '' }}" autofocus
                                autocomplete="gestas" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Partos:
                        <div class="flex items-center justify-between">
                            <x-input id="partos" class="block w-full" type="number" name="partos" required
                                value="{{ $colposcopia ? $colposcopia->ago->partos : '' }}" autofocus
                                autocomplete="partos" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Cesareas:
                        <div class="flex items-center justify-between">
                            <x-input id="cesareas" class="block w-full" type="number" name="cesareas" required
                                value="{{ $colposcopia ? $colposcopia->ago->cesareas : '' }}" autofocus
                                autocomplete="cesareas" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Abortos:
                        <div class="flex items-center justify-between">
                            <x-input id="abortos" class="block w-full" type="number" name="abortos" required
                                value="{{ $colposcopia ? $colposcopia->ago->abortos : '' }}" autofocus
                                autocomplete="abortos" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">PF:
                        <div class="flex items-center justify-between">
                            <x-input id="pf" class="block w-full" type="text" name="pf" required
                                value="{{ $colposcopia ? $colposcopia->ago->pf : '' }}" autofocus
                                autocomplete="pf" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">FUR:
                        <div class="flex items-center justify-between">
                            <x-input id="fur" class="block w-full" type="text" name="fur" required
                                value="{{ $colposcopia ? $colposcopia->ago->fur : '' }}" autofocus
                                autocomplete="fur" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Citologia previa:
                        <div class="flex items-center justify-between">
                            <x-input id="citologia" class="block w-full" type="text" name="citologia" required
                                value="{{ $colposcopia ? $colposcopia->ago->citologia : '' }}" autofocus
                                autocomplete="citologia" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Otros antecedentes:
                        <div class="flex items-center justify-between">
                            <x-input id="otros_antecendes" class="block w-full" type="text"
                                name="otros_antecendes" required
                                value="{{ $colposcopia ? $colposcopia->ago->otros_antecendes : '' }}" autofocus
                                autocomplete="otros_antecendes" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-indigo-600 border-2 px-4 py-2">Capt-hibridos/PCR:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="capt" value="Si" />
                            <span>No</span>
                            <input type="radio" name="capt" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">TX: Cervicales previos:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="tx" value="Si" />
                            <span>No</span>
                            <input type="radio" name="tx" value="No" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Resultados:
                        <div class="flex items-center justify-between">
                            <x-input id="resultados" class="block w-full" type="text" name="resultados" required
                                value="{{ $colposcopia ? $colposcopia->ago->resultados : '' }}" autofocus
                                autocomplete="resultados" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Cuales:
                        <div class="flex items-center justify-between">
                            <x-input id="cuales" class="block w-full" type="text" name="cuales" required
                                value="{{ $colposcopia ? $colposcopia->ago->cuales : '' }}" autofocus
                                autocomplete="cuales" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-r-2 border-b-2 border-indigo-600">Fecha de toma:
                        <div class="flex items-center justify-between">
                            <x-input id="fecha_de_toma" class="block w-full" type="date" name="fecha_de_toma"
                                required value="{{ $colposcopia ? $colposcopia->ago->fecha_de_toma : '' }}" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2 border-b-2 border-indigo-600">Fecha de interpretacion:
                        <div class="flex items-center justify-between">
                            <x-input id="fecha_de_interpretacion" class="block w-full" type="date"
                                name="fecha_de_interpretacion" required
                                value="{{ $colposcopia ? $colposcopia->ago->fecha_de_interpretacion : '' }}" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2 border-b-2 border-indigo-600">Fecha de envio:
                        <div class="flex items-center justify-between">
                            <x-input id="fecha_de_envio" class="block w-full" type="date" name="fecha_de_envio"
                                required value="{{ $colposcopia ? $colposcopia->ago->fecha_de_envio : '' }}" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-r-2 border-b-2 border-indigo-600">Diagnostico citologico:
                        <div class="flex items-center justify-between">
                            <x-input id="diagnostico_citologico" class="block w-full" type="text"
                                name="diagnostico_citologico" required
                                value="{{ $colposcopia ? $colposcopia->ago2->diagnostico_citologico : '' }}" autofocus
                                autocomplete="diagnostico_citologico" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2 border-b-2 border-indigo-600">Sintomatologia:
                        <div class="flex items-center justify-between">
                            <x-input id="sintomatologia" class="block w-full" type="text" name="sintomatologia"
                                required value="{{ $colposcopia ? $colposcopia->ago2->sintomatologia : '' }}"
                                autofocus autocomplete="sintomatologia" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-b-2 border-r-2 border-indigo-600">
                        <div class="grid xl:grid-cols-3">
                            <div>
                                <canvas id="canvas" width="250%" height="250%"
                                    style="border:1px solid #000; border-radius: 15%;
                                        background-image: url('{{ asset('img-empresa/colposcopia.jpg') }}');
                                        background-size: cover; background-position: center;"
                                    class="div_img"></canvas>
                            </div>
                            <div id="img_botones">
                                <div id="contenedor-controls" class="flex flex-col items-start ">
                                    <div class="flex mb-3">
                                        <div class="flex items-center ">
                                            <label for="color-picker">Color de línea:</label>
                                        </div>
                                        <div class="flex items-center ms-3">
                                            <input type="color" id="color-picker" value="#FFFFFF">
                                        </div>
                                    </div>
                                    <div>
                                        <x-boton-editar id="borrar-ultimo">Borrar ultimo</x-boton-editar>
                                        <x-boton-editar id="borrar-todos">Limpiar imagen</x-boton-editar>
                                    </div>
                                </div>
                                <div>
                                    <label for="color-picker">Doble clic sobre la imagen para añadir texto.</label>
                                </div>
                                <div id="div_input" class="mt-3 flex flex-col" style="display: none;">
                                    <label for="text-input">Texto:</label>
                                    <input type="text" id="text-input" name="text-input" class="rounded-md" />
                                </div>
                            </div>
                            <div>
                                <x-label for="comentarios" value="{{ __('Comentarios:') }}" class="" />
                                <textarea id="comentarios" name="comentarios" class="rounded-md w-full" rows="5">{{ $colposcopia ? $colposcopia->ago2->comentarios : '' }}</textarea>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Indice colposcopico REID:
                        <div class="flex items-center justify-between">
                            <x-input id="indice_colposcopico_REID" class="block w-full" type="text"
                                name="indice_colposcopico_REID" required
                                value="{{ $colposcopia ? $colposcopia->ago2->indice_colposcopico_REID : '' }}"
                                autofocus autocomplete="indice_colposcopico_REID" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Color:
                        <div class="flex items-center justify-between">
                            <x-input id="color" class="block w-full" type="text" name="color" required
                                value="{{ $colposcopia ? $colposcopia->ago2->color : '' }}" autofocus
                                autocomplete="color" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Margen:
                        <div class="flex items-center justify-between">
                            <x-input id="margen" class="block w-full" type="text" name="margen" required
                                value="{{ $colposcopia ? $colposcopia->ago2->margen : '' }}" autofocus
                                autocomplete="margen" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Tincion con yodo:
                        <div class="flex items-center justify-between">
                            <x-input id="tincion_con_yodo" class="block w-full" type="text"
                                name="tincion_con_yodo" required
                                value="{{ $colposcopia ? $colposcopia->ago2->tincion_con_yodo : '' }}" autofocus
                                autocomplete="tincion_con_yodo" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Vasos:
                        <div class="flex items-center justify-between">
                            <x-input id="vasos" class="block w-full" type="text" name="vasos" required
                                value="{{ $colposcopia ? $colposcopia->ago2->vasos : '' }}" autofocus
                                autocomplete="vasos" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Biopsia:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="biopsia" value="Si" />
                            <span>No</span>
                            <input type="radio" name="biopsia" value="No" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Radio:
                        <div class="flex items-center justify-between">
                            <x-input id="radio" class="block w-full" type="text" name="radio" required
                                value="{{ $colposcopia ? $colposcopia->ago2->radio : '' }}" autofocus
                                autocomplete="radio" />
                        </div>
                    </td>
                    <td class="border-indigo-600 border-2 px-4 py-2">Cepillado endocervical:
                        <div class="flex items-center justify-between">
                            <span>Si</span>
                            <input type="radio" name="cepillado_endocervical" value="Si" />
                            <span>No</span>
                            <input type="radio" name="cepillado_endocervical" value="No" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">DX colposcopico:
                        <div class="flex items-center justify-between">
                            <x-input id="dx" class="block w-full" type="text" name="dx" required
                                value="{{ $colposcopia ? $colposcopia->ago2->dx : '' }}" autofocus
                                autocomplete="dx" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Grado:
                        <div class="flex items-center justify-between">
                            <x-input id="grado" class="block w-full" type="text" name="grado" required
                                value="{{ $colposcopia ? $colposcopia->ago2->grado : '' }}" autofocus
                                autocomplete="grado" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Otros DX:
                        <div class="flex items-center justify-between">
                            <x-input id="otros_dx" class="block w-full" type="text" name="otros_dx" required
                                value="{{ $colposcopia ? $colposcopia->ago2->otros_dx : '' }}" autofocus
                                autocomplete="otros_dx" />
                        </div>
                    </td>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Observaciones:
                        <div class="flex items-center justify-between">
                            <x-input id="observaciones" class="block w-full" type="text" name="observaciones"
                                required value="{{ $colposcopia ? $colposcopia->ago2->observaciones : '' }} "
                                autofocus autocomplete="observaciones" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                <tr>
                    <td class="px-3 py-2 border-l-2 border-r-2  border-b-2 border-indigo-600">Proxima cita:
                        <div class="flex items-center justify-between">
                            <x-input id="proxima_cita" class="block w-full" type="text" name="proxima_cita"
                                value="{{ $colposcopia ? $colposcopia->ago2->proxima_cita : '' }}" autofocus
                                autocomplete="proxima_cita" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-end mt-4">
        @if ($colposcopia)
            <div class="flex items-center justify-end mt-4" id="divEditar">
                <x-boton-mas id="btnEditar">{{ 'Editar' }}</x-boton-mas>
            </div>
            <div id="divCancelar" style="display: none; margin: 2%">
                <x-boton-mas id="btnCancelar">{{ 'Cancelar' }}</x-boton-mas>
            </div>
        @endif

        <div id="div_button">
            <x-boton-mas id="guardarForm">{{ $colposcopia ? 'Guardar cambios' : 'Guardar' }}</x-boton-mas>
        </div>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<script src="{{ asset('js/generarPDF.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var colposcopia = @json($colposcopia);
        let triaje = @json($triaje);

        let editando = false;

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        let trazos = []; // Almacena todos los trazos
        let trazoActual = []; // Almacena los puntos del trazo actual

        let color = document.getElementById('color-picker').value;

        const divInput = document.getElementById('div_input');

        const textInput = document.getElementById('text-input');

        let holdTimer;
        let delay = 200;
        let dobleCick = false;

        // Lista de todos los IDs de tus inputs
        var inputIds = [
            'alergicos', 'otros', 'menarca', 'ritmo', 'ivsa', 'pSexuales', 'gestas', 'partos',
            'cesareas', 'abortos', 'pf', 'fur', 'citologia', 'otros_antecendes', 'resultados',
            'cuales', 'fecha_de_toma', 'fecha_de_interpretacion', 'fecha_de_envio',
            'diagnostico_citologico',
            'sintomatologia', 'indice_colposcopico_REID', 'color', 'margen', 'tincion_con_yodo',
            'vasos',
            'radio', 'dx', 'grado', 'otros_dx', 'observaciones','proxima_cita'
        ];

        if (colposcopia && !editando) {

            // Bucle para aplicar readonly a todos los inputs
            inputIds.forEach(function(id) {
                var input = document.getElementById(id);
                if (input) {
                    input.setAttribute('readonly', true);
                }
            });

            document.getElementById('comentarios').setAttribute('readonly', true);

            function checkRadioButton(groupName, valueToCheck) {
                var radios = document.getElementsByName(groupName);
                for (var i = 0; i < radios.length; i++) {
                    if (radios[i].value === valueToCheck) {
                        radios[i].checked = true;

                    }
                    radios[i].disabled = true;
                }
            }

            checkRadioButton('cancer', colposcopia.ahf.cancer);
            checkRadioButton('diabetes_heredica', colposcopia.ahf.diabetes_heredica);

            checkRadioButton('has', colposcopia.app.has);
            checkRadioButton('cardiopatia', colposcopia.app.cardiopatia);
            checkRadioButton('tabaquismo', colposcopia.app.tabaquismo);
            checkRadioButton('hipertension', colposcopia.app.hipertension);
            checkRadioButton('alcoholismo', colposcopia.app.alcoholismo);
            checkRadioButton('diabetes', colposcopia.app.diabetes);

            checkRadioButton('capt', colposcopia.ago.capt);
            checkRadioButton('tx', colposcopia.ago.tx);

            checkRadioButton('biopsia', colposcopia.ago2.biopsia);
            checkRadioButton('cepillado_endocervical', colposcopia.ago2.cepillado_endocervical);


            document.getElementById('img_botones').style.display = 'none';
            document.getElementById('div_button').style.display = 'none';

            trazos = JSON.parse(colposcopia.ago2.coordenadas);
            redibujarTrazos()
        }

        canvas.addEventListener('mousedown', function(e) {
            holdTimer = setTimeout(function() {
                if (!dobleCick) {
                    startDrawing(e);
                } // Llama a la función startDrawing Si solo fue un clic
            }, delay);
        });

        canvas.addEventListener('touchstart', function(e) {
            holdTimer = setTimeout(function() {
                if (!dobleCick) {
                    startDrawing(e);
                } // Llama a la función startDrawing Si solo fue un clic
            }, delay);
        });

        canvas.addEventListener('dblclick', function(e) {
            if (!colposcopia || editando) {
                dobleCick = true;
                clearTimeout(holdTimer);
                // Calcula la posición en el canvas donde el usuario hizo doble clic
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Configura y muestra el input para que el usuario pueda escribir
                divInput.style.position = 'absolute';
                // textInput.style.left = `${e.clientX}px`;
                // textInput.style.top = `${e.clientY}px`;
                divInput.style.display = 'block';

                textInput.value = '';
                textInput.focus(); // enfoca el input para empezar a escribir inmediatamente

                // Maneja el evento de "enter" para dibujar el texto en el canvas
                textInput.onkeypress = function(event) {
                    if (event.key === "Enter") {
                        trazos.pop();
                        drawText(textInput.value, x, y);
                        divInput.style.display = 'none';
                        dobleCick = false;
                    }
                };
            }
        });

        function drawText(text, x, y) {
            ctx.font = '13px Arial';
            ctx.textBaseline = 'top';
            ctx.fillText(text, x, y);
            trazoActual = {
                puntos: [{
                    x,
                    y
                }],
                tipo: 'texto',
                text: text
            };
            trazos.push(trazoActual);
        }

        document.getElementById('color-picker').addEventListener('input', function() {
            color = this.value;
        });

        function getCoordinates(event) {
            const rect = canvas.getBoundingClientRect();
            let x, y;

            if (event.touches) {
                x = event.touches[0].clientX - rect.left;
                y = event.touches[0].clientY - rect.top;
            } else {
                x = event.clientX - rect.left;
                y = event.clientY - rect.top;
            }

            return {
                x,
                y
            };
        }

        function startDrawing(e) {
            if (!colposcopia || editando) {
                const {
                    x,
                    y
                } = getCoordinates(e);
                drawing = true;
                trazoActual = {
                    puntos: [{
                        x,
                        y
                    }],
                    color: color
                };
                ctx.beginPath();
                ctx.moveTo(x, y);
                canvas.addEventListener('mousemove', draw);

                canvas.addEventListener('touchmove', draw);
            }
        }

        function draw(e) {
            if (drawing && (!colposcopia || editando)) {
                const {
                    x,
                    y
                } = getCoordinates(e);
                let punto_new = {
                    x: x,
                    y: y
                };
                trazoActual.puntos.push(punto_new);
                ctx.lineTo(x, y);
                ctx.strokeStyle = color;
                ctx.lineWidth = 3;
                ctx.stroke();
                canvas.addEventListener('mouseup', endDrawing);
                canvas.addEventListener('mouseout', endDrawing);


                canvas.addEventListener('touchend', endDrawing);
            }
        }

        function endDrawing() {
            if (drawing && (!colposcopia || editando)) {
                trazos.push(trazoActual);
                ctx.closePath();
                drawing = false;

                clearTimeout(holdTimer);
            }
        }

        document.getElementById('borrar-ultimo').addEventListener('click', function() {
            if (trazos.length > 0) {
                trazos.pop(); // Elimina el último trazo
                redibujarTrazos();
            }
        });

        function redibujarTrazos() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpia el canvas
            trazos.forEach(trazo => {
                if (trazo.tipo === 'texto') {
                    ctx.font = '13px Arial';
                    ctx.textBaseline = 'top'; // Asegurarse de usar fillStyle para el texto
                    ctx.fillText(trazo.text, trazo.puntos[0].x, trazo.puntos[0].y);
                } else {
                    ctx.beginPath();
                    ctx.moveTo(trazo.puntos[0].x, trazo.puntos[0].y);
                    trazo.puntos.forEach((punto, index) => {
                        if (index > 0) {
                            ctx.lineTo(punto.x, punto.y);
                        }
                    });
                    ctx.strokeStyle = trazo.color; // Usa el color almacenado con el trazo
                    ctx.lineWidth = 4;
                    ctx.stroke();
                    ctx.closePath();
                }
            });
        }

        document.getElementById('borrar-todos').addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpia el canvas
            trazos = []; // Vacía el arreglo de trazos
        });

        document.getElementById('guardarForm').addEventListener('click', function(event) {
            // Previene el comportamiento por defecto del botón, que es enviar el formulario
            event.preventDefault();

            // Genera la imagen y actualiza el contenedor de imagen
            // html2canvas(document.querySelector(".div_img")).then(canvas => {
            //     const imgData = canvas.toDataURL('image/png');

            //     const img = document.createElement('input');
            //     img.type = 'hidden';
            //     img.name = 'imagen'; // Nombre del campo en el formulario Laravel
            //     img.value = imgData;

            //     // Agrega la imagen al formulario
            //     document.getElementById('formColposcopia').appendChild(img);
            // });


            const coordenadas = document.createElement('input');
            coordenadas.type = 'hidden';
            coordenadas.name = 'coordenadas'; // Nombre del campo en el formulario Laravel

            coordenadas.value = JSON.stringify(trazos);

            // Agrega la el input con las coordenadas de los trazoa al formulario
            document.getElementById('formColposcopia').appendChild(coordenadas);

            // Envía el formulario
            document.getElementById('formColposcopia').submit();

        });

        document.getElementById('btnEditar').addEventListener('click', function() {
            document.getElementById('divEditar').style.display = 'none';
            document.getElementById('div_button').style.display = 'inline';

            inputIds.forEach(function(id) {
                var input = document.getElementById(id);
                if (input) {
                    input.removeAttribute('readonly');
                }
            });
            // Seleccionar todos los inputs de tipo radio que están deshabilitados
            var radiosDeshabilitados = document.querySelectorAll('input[type="radio"][disabled]');

            // Iterar sobre cada radio deshabilitado y habilitarlo
            radiosDeshabilitados.forEach(function(radio) {
                radio.removeAttribute('disabled');
            });
            document.getElementById('comentarios').removeAttribute('readonly');
            document.getElementById('img_botones').style.display = 'inline';
            document.getElementById('div_button').style.display = 'inline';
            document.getElementById('divCancelar').style.display = 'inline';
            document.getElementById('imprimir').style.display = 'none';
            editando = true;
        });

        document.getElementById('btnCancelar').addEventListener('click', function() {
            location.reload();
        });

        document.getElementById('imprimir').addEventListener('click', function() {
            html2canvas(document.querySelector(".div_img")).then(canvas => {
                const imgData2 = canvas.toDataURL('image/png');

                // Crear un elemento <img> para mostrar la imagen
                const img = document.createElement('img');
                img.src = imgData2;
                // img.style.width = '20%';

                // // Agregar el <img> al contenedor
                // document.getElementById('imageContainer').innerHTML =
                // ''; // Limpiar el contenedor
                // document.getElementById('imageContainer').appendChild(img);
                let paciente = @json($consulta->paciente);
                let imgData3 = "{{ asset('img-empresa/fondo-colposcopia.jpg') }}";
                console.log(triaje);
                generarPDF(colposcopia, imgData2, imgData3, paciente, triaje);
            });

        });
    });
</script>
