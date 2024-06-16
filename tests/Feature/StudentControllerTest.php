<?php

namespace Tests\Unit;

use App\Models\Level;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllStudents()
    {
        // Arrange: Create some students
        Student::factory()->count(3)->create();

        // Act: Make a GET request to retrieve all students
        $response = $this->getJson(route('students.getAll'));

        // Assert: Verify the response structure and status
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'full_name',
            ]
        ]);
    }

    public function testIndex()
    {
        // Arrange: Create some students and a level
        $level = Level::factory()->create();
        $students = Student::factory()->count(3)->create(['level_id' => $level->id]);

        // Act: Make a GET request to the index endpoint with filters
        $response = $this->getJson(route('students.index', [
            'level_id' => $level->id,
            'search' => $students[0]->full_name,
        ]));

        // Assert: Verify the response structure and status
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'full_name',
                    'level' => [
                        'id',
                        'name',
                    ]
                ]
            ],
            'links',
            'meta'
        ]);
    }

    public function testStoreStudent()
    {
        // Arrange: Create a level
        $level = Level::factory()->create();

        // Act: Make a POST request to create a new student
        $response = $this->postJson(route('students.store'), [
            'full_name' => 'John Doe',
            'code' => '12345',
            'date_of_birth' => '2000-01-01',
            'email' => 'john.doe@example.com',
            'level_id' => $level->id,
        ]);

        // Assert: Verify the response structure and status
        $response->assertStatus(201);
        $response->assertJson([
            'full_name' => 'John Doe',
            'code' => '12345',
            'date_of_birth' => '2000-01-01',
            'email' => 'john.doe@example.com',
            'level_id' => $level->id,
        ]);
        $this->assertDatabaseHas('students', [
            'full_name' => 'John Doe',
            'code' => '12345',
            'date_of_birth' => '2000-01-01',
            'email' => 'john.doe@example.com',
            'level_id' => $level->id,
        ]);
    }

    public function testShowStudent()
    {
        // Arrange: Create a student
        $student = Student::factory()->create();

        // Act: Make a GET request to retrieve the student by ID
        $response = $this->getJson(route('students.show', $student->id));

        // Assert: Verify the response structure and status
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $student->id,
            'full_name' => $student->full_name,
            'code' => $student->code,
            'date_of_birth' => $student->date_of_birth,
            'email' => $student->email,
            'level_id' => $student->level_id,
        ]);
    }

    public function testUpdateStudent()
    {
        // Arrange: Create a student and a level
        $student = Student::factory()->create();
        $level = Level::factory()->create();

        // Act: Make a PUT request to update the student
        $response = $this->putJson(route('students.update', $student->id), [
            'full_name' => 'Jane Doe',
            'code' => '54321',
            'date_of_birth' => '1999-01-01',
            'email' => 'jane.doe@example.com',
            'level_id' => $level->id,
        ]);

        // Assert: Verify the response structure and status
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $student->id,
            'full_name' => 'Jane Doe',
            'code' => '54321',
            'date_of_birth' => '1999-01-01',
            'email' => 'jane.doe@example.com',
            'level_id' => $level->id,
        ]);
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'full_name' => 'Jane Doe',
            'code' => '54321',
            'date_of_birth' => '1999-01-01',
            'email' => 'jane.doe@example.com',
            'level_id' => $level->id,
        ]);
    }

    public function testDestroyStudent()
    {
        // Arrange: Create a student
        $student = Student::factory()->create();

        // Act: Make a DELETE request to remove the student
        $response = $this->deleteJson(route('students.destroy', $student->id));

        // Assert: Verify the response structure and status
        $response->assertStatus(204);
        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }
}
