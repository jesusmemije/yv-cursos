<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FinalProject;
use App\Models\FinalProjectSubmission;
use App\Models\Group;
use App\Traits\General;
use App\Traits\ImageSaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FinalProjectController extends Controller
{
    use General, ImageSaveTrait;

    /**
     * Mostrar trabajo final
     */
    public function show($enrollmentId)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);

        if ($enrollment->user_id != Auth::id()) {
            abort(403);
        }

        $groupId = $enrollment->order && $enrollment->order->carts()->first() 
            ? $enrollment->order->carts()->first()->group_id 
            : null;

        $finalProject = FinalProject::where('course_id', $enrollment->course_id);
        
        if ($groupId) {
            $finalProject = $finalProject->where('group_id', $groupId)->first();
        } else {
            $finalProject = $finalProject->latest()->first();
        }

        $progress = $this->calculateProgress($enrollment);

        if (!$finalProject || !$finalProject->isRegistered()) {
            return redirect()->back()->with('error', 'El trabajo final no está disponible para este curso.');
        }

        if ($progress < 100) {
            return redirect()->back()->with('error', 'Debes completar el 100% del curso para enviar el trabajo final.');
        }

        $submission = FinalProjectSubmission::where('final_project_id', $finalProject->id)
            ->where('user_id', Auth::id())
            ->where('enrollment_id', $enrollment->id)
            ->first();

        $data['title'] = 'Trabajo Final';
        $data['enrollment'] = $enrollment;
        $data['finalProject'] = $finalProject;
        $data['submission'] = $submission;
        $data['progress'] = $progress;

        return view('frontend.student.final-project.show', $data);
    }

    /**
     * Guardar envío de trabajo final
     */
    public function store(Request $request)
    {
        $request->validate([
            'final_project_id' => 'required|exists:final_projects,id',
            'enrollment_id' => 'required|exists:enrollments,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

        $finalProject = FinalProject::findOrFail($request->final_project_id);
        $enrollment = Enrollment::findOrFail($request->enrollment_id);

        if ($enrollment->user_id != Auth::id()) {
            abort(403);
        }

        if ($finalProject->course_id != $enrollment->course_id) {
            return redirect()->back()->with('error', 'El trabajo final no corresponde a este curso.');
        }

        $progress = $this->calculateProgress($enrollment);

        if ($progress < 100) {
            return redirect()->back()->with('error', 'Debes completar el 100% del curso para enviar el trabajo final.');
        }

        try {
            DB::beginTransaction();

            $submission = FinalProjectSubmission::where('final_project_id', $finalProject->id)
                ->where('user_id', Auth::id())
                ->where('enrollment_id', $enrollment->id)
                ->first();

            if (!$submission) {
                $submission = new FinalProjectSubmission();
                $submission->final_project_id = $finalProject->id;
                $submission->enrollment_id = $enrollment->id;
                $submission->user_id = Auth::id();
                $submission->group_id = $finalProject->group_id;
            }

            if ($request->hasFile('file')) {
                if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                    Storage::disk('public')->delete($submission->file_path);
                }

                $file = $request->file('file');
                $filePath = $file->store('final-projects', 'public');
                $submission->file_path = $filePath;
                $submission->file_name = $file->getClientOriginalName();
            }

            $submission->title = $request->title;
            $submission->description = $request->description;
            $submission->status = 'submitted';
            $submission->submitted_at = now();
            $submission->save();

            $this->sendEmailToInstructor($finalProject, $submission, $enrollment);

            DB::commit();

            $this->showToastrMessage('success', 'Trabajo final enviado exitosamente.');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting final project: ' . $e->getMessage());
            $this->showToastrMessage('error', 'Error al enviar el trabajo final: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Calcular progreso correctamente
     */
    private function calculateProgress($enrollment)
    {
        if (!$enrollment || !$enrollment->course) {
            return 0;
        }

        return studentCourseProgress($enrollment->course_id, $enrollment->id);
    }

    /**
     * Enviar correo al instructor
     */
    private function sendEmailToInstructor($finalProject, $submission, $enrollment)
    {
        try {
            $instructor = $finalProject->instructor;
            $student = $submission->student;
            $course = $finalProject->course;
            $cycle = $finalProject->group;

            $mailData = [
                'instructor_name' => $instructor->name,
                'student_name' => $student->name,
                'student_email' => $student->email,
                'course_name' => $course->title,
                'cycle_name' => $cycle->name,
                'project_title' => $submission->title,
                'project_description' => $submission->description,
                'file_path' => $submission->file_path,
                'file_name' => $submission->file_name,
                'submitted_date' => $submission->submitted_at->format('d/m/Y H:i')
            ];

            Mail::send('mail.final-project-submission', $mailData, function ($message) use ($instructor, $submission) {
                $message->to($instructor->email)
                    ->subject('Nuevo Trabajo Final Enviado');
                
                if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                    $message->attachFromStorage($submission->file_path, $submission->file_name);
                }
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Error sending final project email: ' . $e->getMessage());
            return false;
        }
    }
}