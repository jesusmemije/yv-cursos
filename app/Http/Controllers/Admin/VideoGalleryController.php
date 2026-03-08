<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course_lecture;
use App\Models\VideoGallery;
use App\Traits\General;
use App\Traits\ImageSaveTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VideoGalleryController extends Controller
{
    use General, ImageSaveTrait;

    public function index()
    {
        $this->authorizeManageCourse();

        $videos = VideoGallery::latest()->paginate(25);

        $data['title'] = 'Galeria de videos';
        $data['videos'] = $videos;

        return view('admin.course.video-gallery.index', $data);
    }

    public function create()
    {
        $this->authorizeManageCourse();

        $data['title'] = 'Agregar video';
        return view('admin.course.video-gallery.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorizeManageCourse();

        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:video_galleries,title'],
            'video_file' => ['required', 'file', 'mimes:mp4,mov,avi,mkv,webm,wmv'],
            'file_duration' => ['nullable', 'numeric', 'min:0'],
        ]);

        $fileDetails = $this->uploadFileWithDetails('video', $request->video_file);
        if (!$fileDetails['is_uploaded']) {
            $this->showToastrMessage('error', __('No se pudo subir el archivo de video.'));
            return redirect()->back()->withInput();
        }

        $seconds = $this->normalizeDuration($request->file_duration);

        $video = new VideoGallery();
        $video->title = trim($request->title);
        $video->file_path = $fileDetails['path'];
        $video->file_duration_second = $seconds;
        $video->file_duration = $this->formatDuration($seconds);
        $video->save();

        $this->showToastrMessage('success', __('Video creado correctamente.'));
        return redirect()->route('admin.video-gallery.index');
    }

    public function edit($uuid)
    {
        $this->authorizeManageCourse();

        $data['title'] = 'Editar video';
        $data['video'] = VideoGallery::where('uuid', $uuid)->firstOrFail();

        return view('admin.course.video-gallery.edit', $data);
    }

    public function update(Request $request, $uuid)
    {
        $this->authorizeManageCourse();

        $video = VideoGallery::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('video_galleries', 'title')->ignore($video->id)],
        ]);

        $video->title = trim($request->title);
        $video->save();

        $this->showToastrMessage('success', __('Video actualizado correctamente.'));
        return redirect()->route('admin.video-gallery.index');
    }

    public function delete($uuid)
    {
        $this->authorizeManageCourse();

        $video = VideoGallery::where('uuid', $uuid)->firstOrFail();

        $inUse = Course_lecture::query()
            ->where('type', 'video')
            ->where(function ($query) use ($video) {
                $query->where('video_gallery_id', $video->id)
                    ->orWhere('file_path', $video->file_path);
            })
            ->exists();

        if ($inUse) {
            $this->showToastrMessage('error', __('El video esta en uso en uno o mas cursos.'));
            return redirect()->back();
        }

        $this->deleteFile($video->file_path);
        $video->delete();

        $this->showToastrMessage('success', __('Video eliminado correctamente.'));
        return redirect()->back();
    }

    private function authorizeManageCourse()
    {
        if (!auth()->user()->can('manage_course')) {
            abort(403);
        }
    }

    private function normalizeDuration($duration): ?int
    {
        if ($duration === null || $duration === '') {
            return null;
        }

        $seconds = (int) round((float) $duration);
        return $seconds > 0 ? $seconds : null;
    }

    private function formatDuration($seconds): ?string
    {
        if (!$seconds) {
            return null;
        }

        return $seconds >= 3600 ? gmdate('H:i:s', $seconds) : gmdate('i:s', $seconds);
    }
}
