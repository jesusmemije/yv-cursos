@if(count($events))
    <ul class="list-group">
        @foreach($events as $event)
            <a href="{{ route('event-details', $event->slug) }}" class="list-group-item-action mb-2">
                <strong>{{ $event->title }}</strong><br>
                {{ \Carbon\Carbon::parse($event->start)->format('H:i') }} horas
            </a>
        @endforeach
    </ul>
@else
    <p>No hay eventos para este día.</p>
@endif