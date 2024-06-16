<?php

namespace Database\Seeders;

use App\Models\GradeItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        Schema::create('grades', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('enrollment_id')->constrained('enrollments');
//            $table->foreignId('grade_item_id')->constrained('grade_items');
//            $table->integer('grade');
//            $table->timestamps();
//        });

        if (\App\Models\Grade::count() > 0) {
            return;
        }
        $gradeItems = GradeItem::inRandomOrder()->get();
        $enrollments = \App\Models\Enrollment::all();
        foreach ($enrollments as $enrollment) {
            foreach ($gradeItems as $gradeItem) {
                \App\Models\Grade::factory()->create([
                    'enrollment_id' => $enrollment->id,
                    'grade_item_id' => $gradeItem->id,
                    'grade' => random_int(0, $gradeItem->max_degree),
                ]);
            }
        }

    }
}
