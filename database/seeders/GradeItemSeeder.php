<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (\App\Models\GradeItem::count() > 0) {
            return;
        }
        $gradeItems = [
            [
                'name' => 'practice exam',
                'max_degree' => 50
            ],
            [
                'name' => 'oral exam',
                'max_degree' => 20,
            ],
            [
                'name' => 'midterm exam',
                'max_degree' => 50
            ],
            [
                'name' => 'final exam',
                'max_degree' => 100
            ],
        ];

        \App\Models\GradeItem::insert($gradeItems);
    }
}
