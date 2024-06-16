<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\GradeItem;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $courses = Course::all();
        return CourseResource::collection($courses);
    }
    public function availableCoursesForStudent($studentId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (!$studentId) {
            return CourseResource::collection([]);
        }

        $courses = Course::whereDoesntHave('enrollments', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();

        return CourseResource::collection($courses);
    }




    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $courses = Course::when($request->has('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        })
            ->paginate(10);

        return CourseResource::collection($courses);
    }



// Retrieve a specific course by ID
    public function show($id): CourseResource
    {
        $course = Course::findOrFail($id);

        return new CourseResource($course);
    }

}
