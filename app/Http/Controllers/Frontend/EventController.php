<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Tag;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\HandlesCalendar;

class EventController extends Controller
{
    use General;
    use HandlesCalendar;

    public function allEvents(Request $request)
    {
        $data = $this->getCalendarData($request->get('month'), $request->get('year'));
        // Si es petición AJAX, solo devolver el calendario
        if ($request->ajax()) {
            return view(getThemePath() . '.partials.calendar-events', $data)->render();
        }

        $data['pageTitle'] = "Upcoming Events";
        $data['events'] = Event::with('category')->where('status', 1)->orderBy('start', 'asc')->paginate(10);
        $data['eventCategories'] = EventCategory::withCount('activeEvents')->active()->get();
        $data['tags'] = Tag::all();
        $data['nextEvents'] = Event::where('start', '>=', Carbon::now())
            ->active()
            ->orderBy('start', 'asc')
            ->take(3)
            ->get();
        // event_category_id = 5 ==> Corresponde a Cursos Aesthetic Training
        $data['nextCourses'] = Event::where('event_category_id', 5)
            ->where('start', '>=', Carbon::now())
            ->active()
            ->orderBy('start', 'asc')
            ->take(3)
            ->get();

        return view('frontend.event.events', $data);
    }

    public function eventDetails($slug)
    {
        $data['event'] = Event::where('slug', $slug)->active()->firstOrFail();
        $data['pageTitle'] = $data['event']->title;
        $data['relatedEvents'] = Event::where('event_category_id', $data['event']->event_category_id)
                                       ->where('id', '!=', $data['event']->id)
                                       ->active()
                                       ->take(3)
                                       ->get();
        $data['eventCategories'] = EventCategory::withCount('events')->active()->get();

        return view('frontend.event.details', $data);
    }

    public function eventsByCategory($slug)
    {
        $category = EventCategory::where('slug', $slug)->firstOrFail();
        $data['pageTitle'] = $category->name;
        $data['events'] = Event::where('event_category_id', $category->id)->active()->paginate(10);
        $data['eventCategories'] = EventCategory::withCount('events')->active()->get();
        
        return view('frontend.event.category-events', $data);
    }

    public function searchEventsByDate(Request $request)
    {
        $date = $request->get('date');
        $events = Event::whereDate('start', $date)->get();
        return view('frontend.partials.calendar-event-list', compact('events'));
    }
}
