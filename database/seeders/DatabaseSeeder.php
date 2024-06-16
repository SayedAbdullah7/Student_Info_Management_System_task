<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();
        if (\App\Models\User::count() < 1) {
            \App\Models\User::factory()->create([
                'name' => 'Test User',
                'email' => 'user@gmail.com',
            ]);
        }


        $this->call(LevelSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(EnrollmentSeeder::class);
        $this->call(GradeItemSeeder::class);
        $this->call(GradeSeeder::class);
    }
}
