<x-app-layout>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/es.js'></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-div-fondo>
                <div class="container mx-auto p-4">
                    <h1 class="text-2xl font-bold mb-4">Calendario de Consultas</h1>
                <div>
                    <x-paciente.lista-calendario-pacientes :consultas="$consultas" :pacientes="$pacientes ?? null" />
                </div>
                    
                    <div id="divPadreDescripcion">
                        <div id="divDescripcion" class="font-medium" style="display: none">
                            <p> Descripcion de color:</p>
                            <div class="flex mb-2 mt-2">
                                <div class="w-10 rounded-md me-2" style="background-color: red">&nbsp;</div>
                                <p> Día lleno con un maximo de 15 consultas.</p>
                            </div>
                        </div>
                    </div>
                    <div id='calendar'></div>
                </div>
            </x-div-fondo>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const consultas = @json($consultas);
            const hayRojo = consultas.some(consulta => consulta.color === 'red');

            if (hayRojo) {
                document.getElementById('divDescripcion').style.display = 'inline';
            }
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
               
                initialView: 'timeGridDay',
                locale: 'es',
                events: consultas,
                contentHeight: 'auto',
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // Prevent the browser from navigating

                    if (info.event.url) {
                        window.location.href = info.event
                            .url; // Redirige a la URL especificada en el evento
                    }
                },

                /* views: {
                    timeGridWeek: {
                        // Configuración para vista de semana
                        // dayHeaderFormat: {
                        //     weekday: 'short'
                        // },
                        // slotLabelFormat: {
                        //     hour: 'numeric',
                        //     minute: '2-digit',
                        //     meridiem: false
                        // }
                    },
                    timeGridDay: {
                        // Configuración para vista de día
                        dayHeaderFormat: {
                            weekday: 'long'
                        },
                        // slotLabelFormat: {
                        //     hour: 'numeric',
                        //     minute: '2-digit',
                        //     meridiem: false
                        // }
                    }
                }, */

                windowResize: function(view) {
                    // Redimensionar automáticamente
                    if (window.innerWidth < 768) {
                        calendar.changeView('timeGridDay'); // Vista de día en pantallas pequeñas
                    } else {
                        calendar.changeView('timeGridWeek'); // Vista de semana en pantallas grandes
                    }
                }
                
            });

            // Cambiar vista inicialmente según el tamaño de la pantalla
            if (window.innerWidth < 768) {
                calendar.changeView('timeGridDay');
            } else {
                calendar.changeView('timeGridWeek');
            }
            calendar.render();            

        });
    </script>
    <style>
        /* Mejorar el contraste del calendario con el fondo */
        #calendar {
            background-color: rgba(195, 253, 250, 0.75);
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            padding: 10px;
            height: 100vh;
            font-size: large;
        }

        #divPadreDescripcion {
            background-color: rgba(195, 253, 250, 0.75);
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            padding: 10px;
        }

        /* Ocultar las horas de la parte inferior */
        .fc-timegrid-axis-cushion,
        .fc-timegrid-slot-label,
        .fc-timegrid-slot {
            display: none !important;
        }
    </style>
</x-app-layout>
