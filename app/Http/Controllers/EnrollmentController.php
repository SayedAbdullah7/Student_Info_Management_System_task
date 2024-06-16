<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index($courseId)
    {
        $enrollments = Enrollment::select('id', 'student_id', 'course_id')
            ->with(['student:id,full_name,code,email,created_at', 'grades:id,enrollment_id,grade_item_id,grade', 'grades.gradeItem:id,name,max_degree'])
            ->withSum('grades', 'grade')
            ->where('course_id', $courseId)
            ->orderByDesc('id')
            ->paginate(10);

        return EnrollmentResource::collection($enrollments);

    }
    // Enroll a student in a course
    public function enrollStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => [
                'required',
                'exists:courses,id',
                // Custom rule to check if the student is already enrolled in the course
                static function ($attribute, $value, $fail) use ($request) {
                    $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                        ->where('course_id', $value)
                        ->exists();

                    if ($existingEnrollment) {
                        $fail('The student is already enrolled in this course');
                    }
                },
            ],
        ]);

        $enrollment = Enrollment::create($request->all());

        return response()->json($enrollment, 201);
    }

    // Remove a student from a course
    public function removeStudent($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return response()->json(null, 204);
    }
}
