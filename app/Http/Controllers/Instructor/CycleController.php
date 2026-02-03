<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FinalProject;
use App\Models\Group;
use App\Models\User;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CycleController extends Controller
{
    use General;

    public function index()
    {
        $instructorCourseIds = Course::where('user_id', Auth::id())
            ->pluck('id')
            ->toArray();

        $cycles = Group::whereHas('courses', function ($query) use ($instructorCourseIds) {
            $query->whereIn('course_id', $instructorCourseIds);
        })->with(['students', 'courses'])->latest()->get();

        $cyclesWithStats = $cycles->map(function ($cycle) use ($instructorCourseIds) {
            return [
                'cycle' => $cycle,
                'total_students' => $cycle->students()->count(),
                'related_courses' => $cycle->courses()
                    ->whereIn('course_id', $instructorCourseIds)
                    ->count()
            ];
        });

        $data['title'] = 'Instructor - Mis Ciclos Escolares';
        $data['cyclesWithStats'] = $cyclesWithStats;

        return view('instructor.cycles.index', $data);
    }

    public function coursesByCycle($cycleUuid)
    {
        $cycle = Group::where('uuid', $cycleUuid)->firstOrFail();
        
        $instructorCourseIds = Course::where('user_id', Auth::id())
            ->pluck('id')
            ->toArray();

        $courses = $cycle->courses()
            ->whereIn('course_id', $instructorCourseIds)
            ->with(['user', 'orderItems'])
            ->get();

        $coursesWithFinalProject = $courses->map(function ($course) use ($cycle) {
            $finalProject = FinalProject::where('group_id', $cycle->id)
                ->where('course_id', $course->id)
                ->first();

            $studentCount = $course->enrollments()
                ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))
                ->where('owner_user_id', Auth::id())
                ->where('group_id', $cycle->id)
                ->count();

            return [
                'course' => $course,
                'final_project' => $finalProject,
                'has_final_project' => !is_null($finalProject),
                'is_registered' => $finalProject && $finalProject->isRegistered(),
                'student_count' => $studentCount
            ];
        });

        $data['title'] = 'Cursos del Ciclo Escolar';
        $data['cycle'] = $cycle;
        $data['coursesWithFinalProject'] = $coursesWithFinalProject;

        return view('instructor.cycles.courses-by-cycle', $data);
    }

    public function studentsByCourse($cycleUuid, $courseId)
    {
        $cycle = Group::where('uuid', $cycleUuid)->firstOrFail();
        $course = Course::findOrFail($courseId);

        if ($course->user_id != Auth::id()) {
            abort(403);
        }

        if (!$cycle->courses()->where('course_id', $courseId)->exists()) {
            abort(404);
        }

        $students = $course->enrollments()
            ->where('owner_user_id', Auth::id())
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))
            ->where('group_id', $cycle->id)
            ->with(['user', 'order'])
            ->get();

        $studentsData = $students->map(function ($enrollment) {
            return [
                'student' => $enrollment->user,
                'enrollment' => $enrollment,
                'progress' => studentCourseProgress($enrollment->course_id, $enrollment->id),
                'order_id' => $enrollment->order->id ?? null,
                'purchase_date' => $enrollment->order->created_at ?? null
            ];
        })->values();

        $data['title'] = 'Alumnos Inscritos';
        $data['cycle'] = $cycle;
        $data['course'] = $course;
        $data['studentsData'] = $studentsData;

        return view('instructor.cycles.students-by-course', $data);
    }

    public function registerFinalProject($cycleUuid, $courseId)
    {
        $cycle = Group::where('uuid', $cycleUuid)->firstOrFail();
        $course = Course::findOrFail($courseId);

        if ($course->user_id != Auth::id()) {
            abort(403);
        }

        if (!$cycle->courses()->where('course_id', $courseId)->exists()) {
            abort(404);
        }

        $existingProject = FinalProject::where('group_id', $cycle->id)
            ->where('course_id', $course->id)
            ->first();

        $data['title'] = 'Registrar Trabajo Final';
        $data['cycle'] = $cycle;
        $data['course'] = $course;
        $data['existingProject'] = $existingProject;

        return view('instructor.cycles.register-final-project', $data);
    }

    public function storeFinalProject(Request $request, $cycleUuid, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $cycle = Group::where('uuid', $cycleUuid)->firstOrFail();
        $course = Course::findOrFail($courseId);

        if ($course->user_id != Auth::id()) {
            abort(403);
        }

        if (!$cycle->courses()->where('course_id', $courseId)->exists()) {
            abort(404);
        }

        $existingProject = FinalProject::where('group_id', $cycle->id)
            ->where('course_id', $course->id)
            ->first();

        try {
            DB::beginTransaction();

            if ($existingProject) {
                if ($existingProject->isRegistered()) {
                    return redirect()->back()->with('error', 'El trabajo final ya está registrado y no puede ser modificado.');
                }

                $existingProject->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'is_registered' => true,
                    'registered_at' => now()
                ]);
                $finalProject = $existingProject;
            } else {
                $finalProject = FinalProject::create([
                    'group_id' => $cycle->id,
                    'course_id' => $course->id,
                    'user_id' => Auth::id(),
                    'title' => $request->title,
                    'description' => $request->description,
                    'is_registered' => true,
                    'registered_at' => now()
                ]);
            }

            DB::commit();

            $this->showToastrMessage('success', 'Trabajo final registrado exitosamente');
            return redirect()->route('instructor.cycles.coursesByCycle', $cycle->uuid);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->showToastrMessage('error', 'Error al registrar el trabajo final');
            return redirect()->back()->withInput();
        }
    }
}