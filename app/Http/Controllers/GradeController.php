<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Grade;

class GradeController extends Controller
{
    // Add or update a grade for a specific enrollment and grade item
    public function addOrUpdateGrade(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'grade_item_id' => 'required|exists:grade_items,id',
            'grade' => 'required|numeric|min:0',
        ]);

        $grade = Grade::updateOrCreate(
            ['enrollment_id' => $request->input('enrollment_id'), 'grade_item_id' => $request->input('grade_item_id')],
            ['grade' => $request->input('grade')]
        );

        return response()->json($grade, 200);
    }

    // Retrieve grades for a specific enrollment and grade item
    public function getGrade($enrollment_id, $grade_item_id)
    {
        $grade = Grade::where('enrollment_id', $enrollment_id)
            ->where('grade_item_id', $grade_item_id)
            ->firstOrFail();

        return response()->json($grade);
    }
}
