<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (\App\Models\Enrollment::count() > 0) {
            return;
        }
        $students = Student::all();
        Course::all()->each(fn($course) => $course->students()->attach(
            $students->random(8)->pluck('id')->toArray()
        ));

    }
}
