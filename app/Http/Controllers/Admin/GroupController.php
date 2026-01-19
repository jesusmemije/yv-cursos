<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupStepOneRequest;
use App\Models\Course;
use App\Models\Group;
use App\Traits\General;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use General;

    public function index()
    {
        $data['title'] = 'Admin - Listado de ciclos escolares';
        $data['groups'] = Group::latest()->paginate(10);
        return view('admin.group.index')->with($data);
    }

    public function view($uuid)
    {
        $group = Group::where('uuid', $uuid)->with(['courses', 'students'])->firstOrFail();
        
        $data['title'] = 'Admin - Detalles del ciclo escolar';
        $data['group'] = $group;
        $data['courses'] = $group->courses()->paginate(10);
        $data['totalStudents'] = $group->students()->count();

        return view('admin.group.view', $data);
    }

    public function createStepOne()
    {
        $data['title'] = 'Admin - Crear ciclo escolar';
        return view('admin.group.create-step-1')->with($data);
    }

    public function storeStepOne(GroupStepOneRequest $request)
    {
        $validated = $request->validated();

        try {
            $group = new Group();
            $group->name = $validated['group_name'];
            $group->start_date = $validated['start_date'];
            $group->end_date = $validated['end_date'];
            $group->enrollment_start_at = $validated['enrollment_start_at'];
            $group->enrollment_end_at = $validated['enrollment_end_at'];
            $group->status = 1;
            $group->save();

            $this->showToastrMessage('success', __('Ciclo escolar creado exitosamente'));
            
            return redirect()->route('admin.group.createStepTwo', ['uuid' => $group->uuid]);

        } catch (\Exception $e) {
            $this->showToastrMessage('error', __('Error al crear el ciclo escolar'));
            return redirect()->back()->withInput();
        }
    }

    public function createStepTwo($uuid)
    {
        $data['title'] = 'Admin - Asignar Diplomados';
        $data['group'] = Group::where('uuid', $uuid)->firstOrFail();
        
        // Solo obtener cursos que sean diplomados (category_id = 5)
        $data['courses'] = Course::where('category_id', 5)
            ->active()
            ->paginate(6);

        $data['groupCourses'] = $data['group']->courses()->get();
        $data['alreadyAddedCourseIds'] = $data['groupCourses']->pluck('id')->toArray();

        return view('admin.group.create-step-2')->with($data);
    }

    public function addCourse(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        try {
            $group = Group::findOrFail($request->group_id);
            
            // Evitar duplicados
            if (!$group->courses()->where('course_id', $request->course_id)->exists()) {
                $group->courses()->attach($request->course_id);
            }

            return response()->json(['success' => true, 'message' => 'Curso añadido']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function removeCourse(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        try {
            $group = Group::findOrFail($request->group_id);
            $group->courses()->detach($request->course_id);

            return response()->json(['success' => true, 'message' => 'Curso removido']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:groups,id',
                'status' => 'required|in:0,1'
            ]);

            $group = Group::findOrFail($request->id);
            $group->status = $request->status;
            $group->save();

            return response()->json([
                'status' => true,
                'message' => __('Estado del ciclo escolar actualizado correctamente')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('Error al actualizar el estado')
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|exists:groups,uuid'
            ]);

            $group = Group::where('uuid', $request->uuid)->firstOrFail();

            // Verificar si hay estudiantes inscritos en este ciclo escolar
            $enrolledStudentsCount = $group->students()->count();

            if ($enrolledStudentsCount > 0) {
                return response()->json([
                    'status' => false,
                    'message' => __('No se puede eliminar el ciclo escolar porque tiene ' . $enrolledStudentsCount . ' estudiante(s) inscrito(s)')
                ]);
            }

            // Eliminar todas las relaciones
            // 1. Desasociar todos los cursos del ciclo escolar
            $group->courses()->detach();

            // 2. Eliminar el ciclo escolar
            $group->delete();

            return response()->json([
                'status' => true,
                'message' => __('Ciclo escolar eliminado correctamente')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('Error al eliminar el ciclo escolar: ') . $e->getMessage()
            ]);
        }
    }
}