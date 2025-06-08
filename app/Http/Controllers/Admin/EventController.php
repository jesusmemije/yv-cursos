<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventTag;
use App\Models\Tag;
use App\Tools\Repositories\Crud;
use App\Traits\General;
use App\Traits\ImageSaveTrait;
use Illuminate\Support\Str;
use Auth;

class EventController extends Controller
{
    use General, ImageSaveTrait;

    protected $model;
    public function __construct(Event $event)
    {
        $this->model = new Crud($event);
    }

    public function index()
    {
        if (!Auth::user()->can('manage_event')) {
            abort(403);
        }

        $data['title'] = 'Manage Events';
        $data['events'] = $this->model->getOrderById('DESC', 25);
        return view('admin.event.index', $data);
    }

    public function create()
    {
        if (!Auth::user()->can('manage_event')) {
            abort(403);
        }

        $data['title'] = 'Create Event';
        $data['eventCategories'] = EventCategory::all();
        $data['tags'] = Tag::all();
        return view('admin.event.create', $data);
    }

    public function store(EventRequest $request)
    {
        if (!Auth::user()->can('manage_event')) {
            abort(403);
        }

        $slug = $request->slug ?? Str::slug($request->title);
        if (Event::where('slug', $slug)->count() > 0) {
            $slug .= '-' . rand(100000, 999999);
        }

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'details' => $request->details,
            'event_category_id' => $request->event_category_id,
            'image' => $request->image ? $this->saveImage('event', $request->image, null, null) : null,
            'location' => $request->location,
            'start' => $request->start,
            'end' => $request->end,
            'time_zone' => $request->time_zone,
        ];

        $event = $this->model->create($data); // create new event

        if ($request->tag_ids) {
            foreach ($request->tag_ids as $tag_id) {
                $eventTag = new EventTag();
                $eventTag->event_id = $event->id;
                $eventTag->tag_id = $tag_id;
                $eventTag->save();
            }
        }

        return $this->controlRedirection($request, 'event', 'Event');
    }

    public function edit($uuid)
    {
        if (!Auth::user()->can('manage_event')) {
            abort(403);
        }

        $data['title'] = 'Edit Event';
        $data['event'] = $this->model->getRecordByUuid($uuid);
        $data['eventTags'] = EventTag::whereEventId($data['event']->id)->pluck('tag_id')->toArray();
        $data['eventCategories'] = EventCategory::all();
        $data['tags'] = Tag::all();
        return view('admin.event.edit', $data);
    }

    public function update(EventRequest $request, $uuid)
    {
        if (!Auth::user()->can('manage_event')) {
            abort(403);
        }

        $event = $this->model->getRecordByUuid($uuid);

        $slug = $request->slug ?? Str::slug($request->title);
        if (Event::where('slug', $slug)->where('uuid', '!=', $uuid)->count() > 0) {
            $slug .= '-' . rand(100000, 999999);
        }

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'details' => $request->details,
            'event_category_id' => $request->event_category_id,
            'image' => $request->hasFile('image') ? $this->saveImage('event', $request->image, null, null) : $event->image,
            'location' => $request->location,
            'start' => $request->start,
            'end' => $request->end,
            'time_zone' => $request->time_zone,
            'status' => $request->status,
        ];

        $this->model->updateByUuid($data, $uuid); // update event

        EventTag::where('event_id', $event->id)->delete();
        if ($request->tag_ids) {
            foreach ($request->tag_ids as $tag_id) {
                $eventTag = new EventTag();
                $eventTag->event_id = $event->id;
                $eventTag->tag_id = $tag_id;
                $eventTag->save();
            }
        }

        return $this->controlRedirection($request, 'event', 'Event');
    }

    public function delete($uuid)
    {
        if (!Auth::user()->can('manage_event')) {
            abort(403);
        }

        $event = $this->model->getRecordByUuid($uuid);
        EventTag::where('event_id', $event->id)->delete();
        $this->deleteFile($event->image); // delete file from server
        $this->model->deleteByUuid($uuid); // delete record

        $this->showToastrMessage('error', __('Event has been deleted'));
        return redirect()->back();
    }
}
