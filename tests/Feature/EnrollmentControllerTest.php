<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // Arrange: Create a course and some enrollments
        $course = Course::factory()->create();
        $students = Student::factory()->count(3)->create();
        foreach ($students as $student) {
            Enrollment::factory()->create([
                'student_id' => $student->id,
                'course_id' => $course->id,
            ]);
        }

        // Act: Make a GET request to the index endpoint
        $response = $this->getJson(route('enrollments.index', $course->id));

        // Assert: Verify the response structure and status
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'student_id',
                    'course_id',
                    'student' => [
                        'id',
                        'full_name',
                        'code',
                        'email',
                        'created_at'
                    ],
                    'grades' => [
                        '*' => [
                            'id',
                            'enrollment_id',
                            'grade_item_id',
                            'grade',
                            'gradeItem' => [
                                'id',
                                'name',
                                'max_degree'
                            ]
                        ]
                    ],
                    'grades_sum'
                ]
            ],
            'links',
            'meta'
        ]);
    }

    public function testEnrollStudent()
    {
        // Arrange: Create a student and a course
        $student = Student::factory()->create();
        $course = Course::factory()->create();

        // Act: Make a POST request to enroll the student in the course
        $response = $this->postJson(route('enrollments.store'), [
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        // Assert: Verify the response structure and status
        $response->assertStatus(201);
        $response->assertJson([
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);
        $this->assertDatabaseHas('enrollments', [
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }

    public function testEnrollStudentAlreadyEnrolled()
    {
        // Arrange: Create a student, a course, and an enrollment
        $student = Student::factory()->create();
        $course = Course::factory()->create();
        Enrollment::factory()->create([
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        // Act: Make a POST request to enroll the student in the same course again
        $response = $this->postJson(route('enrollments.store'), [
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        // Assert: Verify the response structure and status
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['course_id']);
    }

    public function testRemoveStudent()
    {
        // Arrange: Create a student, a course, and an enrollment
        $student = Student::factory()->create();
        $course = Course::factory()->create();
        $enrollment = Enrollment::factory()->create([
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        // Act: Make a DELETE request to remove the student from the course
        $response = $this->deleteJson(route('enrollments.destroy', $enrollment->id));

        // Assert: Verify the response structure and status
        $response->assertStatus(204);
        $this->assertDatabaseMissing('enrollments', [
            'id' => $enrollment->id,
        ]);
    }
}
