<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Event;
use Carbon\Carbon;

/**
 * Trait HandlesCalendar
 *
 * Provee funcionalidades para obtener eventos mensuales y próximos eventos activos.
 */
trait HandlesCalendar
{
    /**
     * Obtiene los datos del calendario para un mes y año específico.
     *
     * Agrupa los eventos por fecha y también retorna los próximos 3 eventos activos.
     *
     * @param int|null $month El mes del calendario (1-12). Si es null, se usa el mes actual.
     * @param int|null $year El año del calendario. Si es null, se usa el año actual.
     * @return array{
     *     calendarMonth: int,
     *     calendarYear: int,
     *     calendarEvents: \Illuminate\Support\Collection,
     *     nextEvents: \Illuminate\Support\Collection
     * }
     */
    public function getCalendarData($month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $calendarEvents = Event::whereMonth('start', $month)
            ->whereYear('start', $year)
            ->get()
            ->groupBy(fn($e) => Carbon::parse($e->start)->format('Y-m-d'));

        $nextEvents = Event::where('start', '>=', Carbon::now())
            ->active()
            ->orderBy('start', 'asc')
            ->take(3)
            ->get();

        return [
            'calendarMonth' => $month,
            'calendarYear' => $year,
            'calendarEvents' => $calendarEvents,
            'nextEvents' => $nextEvents,
        ];
    }
}