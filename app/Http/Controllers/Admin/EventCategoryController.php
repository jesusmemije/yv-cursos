<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Tools\Repositories\Crud;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class EventCategoryController extends Controller
{
    use General;

    protected $model;

    public function __construct(EventCategory $category)
    {
        $this->model = new Crud($category);
    }

    public function index()
    {
        if (!Auth::user()->can('manage_event')) {
            abort('403');
        }

        $data['title'] = 'Manage Event Categories';
        $data['eventCategories'] = $this->model->getOrderById('DESC', 25);
        return view('admin.event.category-index', $data);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('manage_event')) {
            abort('403');
        }

        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        if (EventCategory::where('slug', $slug)->count() > 0) {
            $slug = Str::slug($request->name) . '-' . rand(100000, 999999);
        }

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
        ];

        $this->model->create($data); // create new event category
        $this->showToastrMessage('success', __('Category created successfully.'));
        return redirect()->back();
    }

    public function update(Request $request, $uuid)
    {
        if (!Auth::user()->can('manage_event')) {
            abort('403');
        }

        $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];

        $this->model->updateByUuid($data, $uuid); // update event category
        $this->showToastrMessage('success', __('Category updated successfully.'));
        return redirect()->back();
    }

    public function delete($uuid)
    {
        if (!Auth::user()->can('manage_event')) {
            abort('403');
        }

        $this->model->deleteByUuid($uuid); // delete event category
        $this->showToastrMessage('error', __('Category has been deleted.'));
        return redirect()->back();
    }
}
