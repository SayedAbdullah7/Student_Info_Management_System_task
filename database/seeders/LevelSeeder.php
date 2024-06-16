<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (Level::count() > 0) {
            return;
        }
        Level::insert([
            ['name' => 'Level 1', 'number' => 1, 'description' => 'First Level'],
            ['name' => 'Level 2', 'number' => 2, 'description' => 'Second Level'],
            ['name' => 'Level 3', 'number' => 3, 'description' => 'Third Level'],
            ['name' => 'Level 4', 'number' => 4, 'description' => 'Fourth Level'],
        ]);
    }
}
