<style>
    @keyframes parpadeo {

        0%,
        100% {
            background-color: rgba(255, 0, 0, 0.952);
        }

        50% {
            background-color: transparent;
        }
    }

    @keyframes parpadeo2 {

        0%,
        100% {
            background-color: rgba(253, 206, 50);
        }

        50% {
            background-color: transparent;
        }
    }

    @keyframes parpadeo3 {

        0%,
        100% {
            background-color: rgb(115, 243, 154);
        }

        50% {
            background-color: transparent;
        }
    }

    .parpadeo {
        animation: parpadeo 1s ease-in-out infinite;
    }

    .parpadeo2 {
        animation: parpadeo2 1.5s ease-in-out 3;
    }

    .parpadeo3 {
        animation: parpadeo3 1.5s ease-in-out 3;
    }


    @media (max-width: 600px) {
        .table {
            overflow-x: auto;
        }


        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead tr {
            /* position: absolute; */
            /* top: -9999px;
            left: -9999px; */
        }

        tr {
            margin-bottom: 0.625rem;
        }

        td {
            /* border: none; */
            border-bottom: 2px solid #3470be;

            border-left: 2px solid #3470be;

            border-right: 2px solid #3470be;
            position: relative;
            padding-left: 1%;
            text-align: left;
        }

        td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 0;
            left: 10px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            text-align: right;
            font-weight: bold;
        }

        /* Label the data */
        td:before {
            content: attr(data-label);
        }
    }
</style>

<div class="table-responsive">
    @php
        $si = false;
        $siColposcopia = false;
        if ($consulta->tipo_consulta == 'Control prenatal') {
            $si = true;
        } elseif ($consulta->tipo_consulta == 'Ginecologica') {
            $siColposcopia = true;
        }
    @endphp
    <form id="formtriage" method="POST" action="{{ $triaje ? route('triajes.update', $consulta->triaje_id) : route('triajes.store', $consulta->id) }}">
        @csrf

        @if($triaje)
            @method('PUT')
        @endif
        <h1 class='text-1xl font-bold mb-3 text-purple-800'>Signos vitales:</h1>
        <div class="mb-2 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 gap-2 ">
            <div>
                <x-label for="tension_arterial" value="{{ __('Tension arterial') }}" />
                <x-input id="tension_arterial" class="block mt-1 w-full" type="text" name="tension_arterial_toma"
                    required value="{{ $triaje ? $triaje->tomaSignosVitales->tension_arterial_toma : '' }}" autofocus
                    autocomplete="tension_arterial" />

            </div>
            <div>
                <x-label for="frecuencia_cardiaca" value="{{ __('Frecuencia cardiaca') }}" />
                <x-input id="frecuencia_cardiaca" class="block mt-1 w-full" type="text"
                    name="frecuencia_cardiaca_toma"
                    value="{{ $triaje ? $triaje->tomaSignosVitales->frecuencia_cardiaca_toma : '' }}"
                    {{-- readonly --}} />
            </div>
            <div>
                <x-label for="talla" value="{{ __('Talla') }}" />
                <x-input id="talla" class="block mt-1 w-full" type="text" name="talla"
                    value="{{ $triaje ? $triaje->tomaSignosVitales->talla : '' }}" required autocomplete="talla"
                    {{-- readonly --}} />
            </div>
            <div>
                <x-label for="peso" value="{{ __('Peso') }}" />
                <x-input id="peso" class="block mt-1 w-full" type="text" name="peso"
                    value="{{ $triaje ? $triaje->tomaSignosVitales->peso : '' }}" required autocomplete="peso"
                    {{-- readonly --}} />
            </div>
            @if ($siColposcopia or $si)
                <div>
                    <x-label for="temperatura" value="{{ __('Temperatura') }}" />
                    <x-input id="temperatura" class="block mt-1 w-full" type="text" name="temperatura_toma"
                        value="{{ $triaje ? $triaje->tomaSignosVitales->temperatura_toma : '' }}"
                        autocomplete="temperatura" {{-- readonly --}} />
                </div>
            @endif
            @if ($si)
                <div>
                    <x-label for="frecuencia_respiratoria" value="{{ __('Frecuencia respiratoria ') }}" />
                    <x-input id="frecuencia_respiratoria" class="block mt-1 w-full" type="text"
                        name="frecuencia_respiratoria_toma"
                        value="{{ $triaje ? $triaje->tomaSignosVitales->frecuencia_respiratoria_toma : '' }}"
                        autocomplete="new-frecuencia_respiratoria" {{-- readonly --}} />
                </div>
                <div>
                    <x-label for="frecuencia_cardiaca_fetal" value="{{ __('Frecuencia cardiaca fetal') }}" />
                    <x-input id="frecuencia_cardiaca_fetal" class="block mt-1 w-full" type="text"
                        name="frecuencia_cardiaca_fetal_toma"
                        value="{{ $triaje ? $triaje->tomaSignosVitales->frecuencia_cardiaca_fetal_toma : '' }}"
                        autocomplete="frecuencia_cardiaca_fetal" {{-- readonly --}} />
                </div>
            @endif
        </div>
        @if ($triaje && $si)
            <div class="flex items-center justify-end">
                <div id="cajaFcf">
                    <x-boton-mas id="fcf">Editar la FCF</x-boton-mas>
                </div>
                <div id="cajaActualizar" style="display: none">
                    <x-boton-mas id="actualizarFcf">Guardar cambios</x-boton-mas>
                </div>
            </div>
        @endif

        @if ($si)
            <h1 class='text-1xl font-bold mb-3 text-purple-800'>Triage y valoración obstétrica:</h1>
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">

                <thead>
                    <tr class="text-left">
                        <th class="border-black border-2 bg-blue-100 px-4 py-2">Variable</th>
                        <th class="border-black border-2 bg-blue-100 px-4 py-2">Rojo (Emergencia) Atención Inmediata
                        </th>
                        <th class="border-black border-2 bg-blue-100 px-4 py-2">Amarilla (Urgencia Calificada) Atención
                            de 0
                            a 15
                            minutos</th>
                        <th class="border-black border-2 bg-blue-100 px-4 py-2">Verde (Urgente No Calificada) Atención
                            de 15
                            a 30
                            minutos</th>
                    </tr>
                </thead>
                <!-- Continuación de la tabla con más filas -->
                <tbody>
                    <!-- Encabezado de sección: Observación -->
                    <tr>
                        <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Observación</th>
                    </tr>
                    <!-- Fila existente: Estado de Conciencia -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Estado de Conciencia</td>

                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Alteraciones (somnolienta, estuporosa, inconsciente)</span>
                                <input type="radio" name="estado_conciencia" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Consciente</span>
                                <input type="radio" name="estado_conciencia" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Hemorragia -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Hemorragia</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Visible o Abundante</span>
                                <input type="radio" name="hemorragia" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Moderada</span>
                                <input type="radio" name="hemorragia" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausente</span>
                                <input type="radio" name="hemorragia" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Crisis Convulsivas -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Crisis convulsivas</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes</span>
                                <input type="radio" name="crisis_convulsivas" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausentes</span>
                                <input type="radio" name="crisis_convulsivas" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Respiración -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Respiración</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Alterada (frecuencia y profundidad)</span>
                                <input type="radio" name="respiración" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Normal</span>
                                <input type="radio" name="respiración" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Color de Piel -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Color de Piel</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Cianótica/acompañada de alteraciones en la respiración</span>
                                <input type="radio" name="color_de_piel" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Pálida</span>
                                <input type="radio" name="color_de_piel" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Normal</span>
                                <input type="radio" name="color_de_piel" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Encabezado de sección: Interrogatorio -->
                    <tr>
                        <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Interrogatorio</th>
                    </tr>

                    <!-- Nueva fila: Sangrado Transvaginal -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Sangrado Transvaginal</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Abundante</span>
                                <input type="radio" name="sangrado_transvaginal" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Escaso/Moderado</span>
                                <input type="radio" name="sangrado_transvaginal" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausente</span>
                                <input type="radio" name="sangrado_transvaginal" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Crisis convulsiva -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Crisis convulsiva</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes</span>
                                <input type="radio" name="crisis_convulsiva" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Negadas</span>
                                <input type="radio" name="crisis_convulsiva" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Cefalea -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Cefalea</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presente</span>
                                <input type="radio" name="cefalea" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausente/Presente, no pulsátil</span>
                                <input type="radio" name="cefalea" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausente</span>
                                <input type="radio" name="cefalea" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Acufenos/Fosfenos -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Acufenos/Fosfenos</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes</span>
                                <input type="radio" name="acufenos_fosfenos" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausentes</span>
                                <input type="radio" name="acufenos_fosfenos" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Epigastralgia/Amaurosis -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Epigastralgia/Amaurosis</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes</span>
                                <input type="radio" name="epigastralgia_amaurosis" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausentes</span>
                                <input type="radio" name="epigastralgia_amaurosis" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Sindrome febril -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Sindrome febril</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes</span>
                                <input type="radio" name="sindrome_febril" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausentes</span>
                                <input type="radio" name="sindrome_febril" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Salida de liquido amniotico -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Salida de liquido amniotico</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>RPM - Meconio</span>
                                <input type="radio" name="salida_de_liquido_amniotico" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Liquido claro</span>
                                <input type="radio" name="salida_de_liquido_amniotico" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Negado</span>
                                <input type="radio" name="salida_de_liquido_amniotico" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Motilidad fetal -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Motilidad fetal</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>No percibe movimientos</span>
                                <input type="radio" name="motilidad_fetal" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Movimientos disminuidos</span>
                                <input type="radio" name="motilidad_fetal" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes normales</span>
                                <input type="radio" name="motilidad_fetal" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Emfermedades cronicas-->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Emfermedades cronicas</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Presentes</span>
                                <input type="radio" name="emfermedades_cronicas" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Ausentes</span>
                                <input type="radio" name="emfermedades_cronicas" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Signos vitales</th>
                    </tr>

                    <!-- Fila existente: Hipertension -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Hipertension (mmHg)</td>

                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>>= 160/110</span>
                                <input type="radio" name="hipertension" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 159/109 y> 121/81
                                </span>
                                <input type="radio" name="hipertension" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 120/80 Y> 100/60
                                </span>
                                <input type="radio" name="hipertension" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Hipotension -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Hipotension</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    <= 89/50</span>
                                        <input type="radio" name="hipotension" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 90/51 Y> 99/59
                                </span>
                                <input type="radio" name="hipotension" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2"></td>
                    </tr>

                    <!-- Nueva fila: Frecuencia Cardiaca -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Frecuencia Cardiaca (FC)</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < </span>
                                        <input type="radio" name="frecuencia_cardiaca" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2"></td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            {{-- <div class="flex items-center justify-between">
                        <span>Ausentes</span>
                        <input type="radio" name="frecuencia_cardiaca" value="ausente" />
                    </div> --}}
                        </td>
                    </tr>

                    <!-- Nueva fila: Indice de choque -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Indice de choque (FC/TAS)</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>> 0.8</span>
                                <input type="radio" name="indice_de_choque" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Entre 0.7 y 0.8</span>
                                <input type="radio" name="indice_de_choque" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 0.7</span>
                                        <input type="radio" name="indice_de_choque" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Frecuencia respiratoria -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Frecuencia respiratoria (RPM)</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 16 o> 25
                                </span>
                                <input type="radio" name="frecuencia_respiratoria" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>21 - 25</span>
                                <input type="radio" name="frecuencia_respiratoria" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>16 a 20</span>
                                <input type="radio" name="frecuencia_respiratoria" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Temperatura -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Temperatura (°C)</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 35°C o> 39°C
                                </span>
                                <input type="radio" name="temperatura" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>37.5°C a 38.9°C</span>
                                <input type="radio" name="temperatura" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>> 35 < 37.5°C</span>
                                        <input type="radio" name="temperatura" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="4" class="border-indigo-600 border-2 px-4 py-2">Bienestar fetal</th>
                    </tr>

                    <!-- Nueva fila: Frecuencia cardiaca fetal -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Frecuencia cardiaca fetal (FCF)</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>
                                    < 110 o> 170
                                </span>
                                <input type="radio" name="frecuencia_cardiaca_fetal" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>> 111 y < 120 o> 161 y < 169</span>
                                            <input type="radio" name="frecuencia_cardiaca_fetal"
                                                value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>De 120 a 160</span>
                                <input type="radio" name="frecuencia_cardiaca_fetal" value="verde" />
                            </div>
                        </td>
                    </tr>

                    <!-- Nueva fila: Contracciones uterinas -->
                    <tr>
                        <td class="border-indigo-600 border-2 px-4 py-2">Contracciones uterinas en 10 min</td>
                        <td class="border-indigo-600 border-2 bg-red-400 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>6 o mas</span>
                                <input type="radio" name="contracciones_uterinas" value="rojo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-yellow-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>De 3 a 5</span>
                                <input type="radio" name="contracciones_uterinas" value="amarillo" />
                            </div>
                        </td>
                        <td class="border-indigo-600 border-2 bg-green-300 px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span>Sin contracciones o menos de 2</span>
                                <input type="radio" name="contracciones_uterinas" value="verde" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        {{-- @elseif($siColposcopia)
            <h1 class='text-1xl font-bold mb-3 text-purple-800'>Datos de colposcopia:</h1>
            <x-paciente.colposcopia/>
        @endif --}}

        <div id="triaje" class="rounded-md pt-2 mt-1">
            <div id="divResultado" style="display: none">
                <div class="flex items-center justify-end mt-4">
                    <label>Resultado:</label>
                    <input type="text" id="resultado" name="resultado"
                        class="bg-transparent text-center ms-2 mb-2 p-2 w-full md:w-1/2 lg:w-1/3 border rounded-md">
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-boton-mas id="autovaloracion">{{ $si ? 'Valorar y guardar' : 'Guardar' }}</x-boton-mas>
            </div>
        </div>
    </form>
</div>

<script>
    var triaje = @json($triaje);

    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si triaje existe
        if (triaje) {
            // Lista de todos los IDs de tus inputs
            var inputIds = [
                'tension_arterial',
                'frecuencia_cardiaca',
                'talla',
                'peso',
                'frecuencia_respiratoria',
                'temperatura',
                'frecuencia_cardiaca_fetal'
            ];

            // Bucle para aplicar readonly a todos los inputs
            inputIds.forEach(function(id) {
                var input = document.getElementById(id);
                if (input) {
                    input.setAttribute('readonly', true);
                }
            });

            function checkRadioButton(groupName, valueToCheck) {
                var radios = document.getElementsByName(groupName);
                for (var i = 0; i < radios.length; i++) {
                    if (radios[i].value === valueToCheck) {
                        radios[i].checked = true;

                    }
                    radios[i].disabled = true;
                }
            }

            if (triaje.observaciones != null) {
                checkRadioButton('estado_conciencia', triaje.observaciones.estado_conciencia);
                checkRadioButton('hemorragia', triaje.observaciones.hemorragia);
                checkRadioButton('crisis_convulsivas', triaje.observaciones.crisis_convulsivas);
                checkRadioButton('respiración', triaje.observaciones.respiración);
                checkRadioButton('color_de_piel', triaje.observaciones.color_de_piel);

                checkRadioButton('sangrado_transvaginal', triaje.interrogatorio.sangrado_transvaginal);
                checkRadioButton('crisis_convulsiva', triaje.interrogatorio.crisis_convulsiva);
                checkRadioButton('cefalea', triaje.interrogatorio.cefalea);
                checkRadioButton('acufenos_fosfenos', triaje.interrogatorio.acufenos_fosfenos);
                checkRadioButton('epigastralgia_amaurosis', triaje.interrogatorio.epigastralgia_amaurosis);
                checkRadioButton('sindrome_febril', triaje.interrogatorio.sindrome_febril);
                checkRadioButton('salida_de_liquido_amniotico', triaje.interrogatorio
                    .salida_de_liquido_amniotico);
                checkRadioButton('motilidad_fetal', triaje.interrogatorio.motilidad_fetal);
                checkRadioButton('emfermedades_cronicas', triaje.interrogatorio.emfermedades_cronicas);

                checkRadioButton('hipertension', triaje.signosVitales.hipertension);
                checkRadioButton('hipotension', triaje.signosVitales.hipotension);
                checkRadioButton('frecuencia_cardiaca', triaje.signosVitales.frecuencia_cardiaca);
                checkRadioButton('indice_de_choque', triaje.signosVitales.indice_de_choque);
                checkRadioButton('frecuencia_respiratoria', triaje.signosVitales.frecuencia_respiratoria);
                checkRadioButton('temperatura', triaje.signosVitales.temperatura);

                checkRadioButton('frecuencia_cardiaca_fetal', triaje.bienestarFetal.frecuencia_cardiaca_fetal);
                checkRadioButton('contracciones_uterinas', triaje.bienestarFetal.contracciones_uterinas);
            }

            document.getElementById('autovaloracion').style.display = 'none';

            document.getElementById('fcf').addEventListener('click', function() {
                document.getElementById('cajaActualizar').style.display = 'inline';
                document.getElementById('cajaFcf').style.display = 'none';
                document.getElementById('frecuencia_cardiaca_fetal').removeAttribute('readonly');
            });

            document.getElementById('actualizarFcf').addEventListener('click', function() {
                document.querySelector('#formtriage').submit();
            });
        }
    });

    document.getElementById('autovaloracion').addEventListener('click', function() {
        // Obtener todos los elementos de radio en la tabla
        const radios = document.querySelectorAll('input[type="radio"]');

        document.getElementById('autovaloracion').style.display = 'none';
        // Inicializar contadores para cada color
        let countRojo = 0;
        let countAmarillo = 0;
        let countVerde = 0;

        // Iterar sobre los radios y contar cuántos están seleccionados para cada color
        radios.forEach(radio => {
            if (radio.checked) {
                const valor = radio.value;
                if (valor === "rojo") {
                    countRojo++;
                } else if (valor === "amarillo") {
                    countAmarillo++;
                } else if (valor === "verde") {
                    countVerde++;
                }
            }
            // radio.disabled = true;
        });

        switch (true) {
            case (countRojo >= 1):
                document.getElementById('divResultado').style.display = 'inline';
                document.getElementById('resultado').value = 'Emergencia! Atención Inmediata!';
                document.getElementById('triaje').classList.add('parpadeo');
                break;
            case (countAmarillo >= 3):
                document.getElementById('divResultado').style.display = 'inline';
                document.getElementById('resultado').value =
                    'Urgencia Calificada! Atención de 0 a 15 minutos';
                document.getElementById('triaje').classList.add('parpadeo2');
                document.getElementById('triaje').style.backgroundColor = 'rgb(253, 206, 50)';
                break;
            default:
                document.getElementById('divResultado').style.display = 'inline';
                document.getElementById('resultado').value =
                    'Urgente No Calificada, Atención de 15 a 30 minutos';
                document.getElementById('triaje').classList.add('parpadeo3');
                document.getElementById('triaje').style.backgroundColor = 'rgb(115, 243, 154)';
        }

        document.querySelector('#formtriage').submit();

        { //     html2canvas(document.querySelector(".table-responsive")).then(canvas => {
            //     const imgData = canvas.toDataURL('image/png');

            //     // Crear un elemento <img> para mostrar la imagen
            //     const img = document.createElement('img');
            //     img.src = imgData;
            //     img.style.width = '100%';

            //     // Agregar el <img> al contenedor
            //     document.getElementById('imageContainer').innerHTML = ''; // Limpiar el contenedor
            //     document.getElementById('imageContainer').appendChild(img);
            // });
            // Mostrar el resultado
            // console.log("Cantidad de radios Rojos seleccionados:", countRojo);
            // console.log("Cantidad de radios Amarillos seleccionados:", countAmarillo);
            // console.log("Cantidad de radios Verdes seleccionados:", countVerde);
        }
    });
</script>
