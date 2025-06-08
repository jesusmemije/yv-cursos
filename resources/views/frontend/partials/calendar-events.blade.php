@php
    use Carbon\Carbon;
    Carbon::setLocale('es');

    $start = Carbon::create($calendarYear, $calendarMonth)->startOfMonth();
    $end = $start->copy()->endOfMonth();
    $todayStr = Carbon::today('America/Mexico_City')->format('Y-m-d');
@endphp

<div id="calendario" class="font-inter" data-month="{{ $calendarMonth }}" data-year="{{ $calendarYear }}">

    <!-- Cabecera del calendario (Siguiente/Anterior Mes)-->
    <div class="head">
        <div class="espiral"></div>
        <div class="p-2">
            <strong class="mes"><button class="btn-outline-primary" id="prevMonth">←</button> {{ $start->translatedFormat('F') }}</strong>
            <strong class="float-end">{{ $start->year }} <button class="btn-outline-primary" id="nextMonth">→</button></strong>
        </div>
    </div>

    <!-- Body del calendario (días, días con eventos, día actual) -->
    <div class="calendario-wrapper">
        <div class="dias">
            <span>Dom</span>
            <span>Lun</span>
            <span>Mar</span>
            <span>Mié</span>
            <span>Jue</span>
            <span>Vie</span>
            <span>Sáb</span>
        </div>

        @php
            $current = $start->copy();
            $weekday = $current->dayOfWeek;
        @endphp

        <table cellpadding='5'>
            <tr>
                {{-- Celdas vacías antes del primer día del mes --}}
                @for ($i = 0; $i < $weekday; $i++)
                    <td></td>
                @endfor

                @while ($current <= $end)
                    @php
                        $dateStr = $current->format('Y-m-d');
                    @endphp

                    <td class="cursor-pointer
                        {{ $current->format('Y-m-d') === $todayStr ? 'bg-info text-white' : '' }} 
                        {{ $current->dayOfWeek === 0 ? 'domingo' : '' }}
                        {{ isset($calendarEvents[$dateStr]) ? 'bg-warning' : '' }}" 
                        data-date="{{ $dateStr }}">
                        {{ $current->day }}
                    </td>

                    @if ($current->dayOfWeek == 6) {{-- Fin de semana: cerrar fila --}}
                        </tr>
                        @if ($current != $end)
                            <tr>
                        @endif
                    @endif

                    @php $current->addDay(); @endphp
                @endwhile

                {{-- Celdas vacías al final si no termina en sábado --}}
                @for ($i = $current->dayOfWeek; $i < 7 && $i > 0; $i++)
                    <td></td>
                @endfor
            </tr>
        </table>
    </div>

    <!-- Listado de próximos eventos al lado del calendario -->
    <div class="eventos">
        @forelse ($nextEvents as $event)
            <a href="{{ route('event-details', $event->slug) }}" class="text-inherit">
                <div class="evento position-relative">
                    <img src="{{ asset('frontend/assets/img/home/campana.png') }}" class="right-top-campana w-4rem">
                    <div class="titulo sf-fw-600">{{ strtoupper($event->start->format('j \D\e F')) }} /
                        {{ strtoupper($event->category->name) }}
                    </div>
                    <div class="mt-2">{{ $event->title }}</div>
                </div>
            </a>
        @empty
            <div class="evento position-relative">
                <img src="{{ asset('frontend/assets/img/home/campana.png') }}" class="right-top-campana w-4rem">
                <div class="titulo sf-fw-600">¡LO SENTIMOS!</div>
                <div class="mt-2">No se encontraron próximos eventos</div>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal con el listado de eventos por día -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eventos del día</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                Cargando...
            </div>
        </div>
    </div>
</div>