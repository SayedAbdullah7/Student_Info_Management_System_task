<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Retrieve all students
    public function getAll()
    {
        return Student::select('id', 'full_name')->get();
    }

    public function index(Request $request)
    {
        $level_id = $request->level_id;
        $search = $request->search;

        $students = Student::with(['level:id,name'])
            ->when($level_id, static function ($query) use ($level_id) {
                $query->where('level_id', $level_id);
            })
            ->when($search, static function ($studentQuery) use ($search) {
                $studentQuery->where(static function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10);
        return StudentResource::collection($students);
    }

    // Create a new student
    public function store(StoreStudentRequest $request)
    {

        $student = Student::create($request->all());

        return response()->json($student, 201);
    }

    // Retrieve a specific student by ID
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    // Update a specific student by ID
    public function update(UpdateStudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);


        $student->update($request->all());

        return response()->json($student);
    }

    // Delete a specific student by ID
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 204);
    }
}
