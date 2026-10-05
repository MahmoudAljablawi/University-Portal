<?php

namespace Tests\Feature;

use App\Models\AcademicRequest;
use App\Models\AcademicSemester;
use App\Models\College;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataScopeTest extends TestCase
{
    use RefreshDatabase;

    private College $collegeA;

    private College $collegeB;

    private User $employeeA;

    private User $instructorA;

    private User $instructorB;

    private User $studentA;

    private User $studentB;

    private CourseSection $sectionA;

    private CourseSection $sectionA2;

    private CourseSection $sectionB;

    private Enrollment $enrollmentA;

    private Enrollment $enrollmentA2;

    private Grade $publishedGradeA;

    private Grade $draftGradeA;

    private Grade $publishedGradeB;

    private AcademicRequest $requestA;

    private AcademicRequest $requestB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collegeA = College::create(['name' => 'College A', 'code' => 'COL-A']);
        $this->collegeB = College::create(['name' => 'College B', 'code' => 'COL-B']);

        $departmentA = Department::create([
            'name' => 'Department A',
            'code' => 'DEP-A',
            'college_id' => $this->collegeA->id,
        ]);
        $departmentB = Department::create([
            'name' => 'Department B',
            'code' => 'DEP-B',
            'college_id' => $this->collegeB->id,
        ]);

        $semester = AcademicSemester::create([
            'name' => 'Fall 2026',
            'code' => 'F26',
            'start_date' => '2026-09-01',
            'end_date' => '2027-01-31',
            'is_active' => true,
        ]);

        $this->employeeA = User::factory()->create([
            'name' => 'Employee A',
            'email' => 'employee-a@example.test',
            'role' => 'employee',
            'college_id' => $this->collegeA->id,
        ]);
        $this->instructorA = User::factory()->create([
            'name' => 'Instructor A',
            'email' => 'instructor-a@example.test',
            'role' => 'instructor',
        ]);
        $this->instructorB = User::factory()->create([
            'name' => 'Instructor B',
            'email' => 'instructor-b@example.test',
            'role' => 'instructor',
        ]);
        $this->studentA = User::factory()->create([
            'name' => 'Student A',
            'email' => 'student-a@example.test',
            'role' => 'student',
        ]);
        $this->studentB = User::factory()->create([
            'name' => 'Student B',
            'email' => 'student-b@example.test',
            'role' => 'student',
        ]);

        $courseA = Course::create([
            'name' => 'Course A',
            'code' => 'CRS-A',
            'credits' => 3,
            'semester_level' => 1,
            'department_id' => $departmentA->id,
        ]);
        $courseB = Course::create([
            'name' => 'Course B',
            'code' => 'CRS-B',
            'credits' => 3,
            'semester_level' => 1,
            'department_id' => $departmentB->id,
        ]);

        $this->sectionA = CourseSection::create([
            'course_id' => $courseA->id,
            'semester_id' => $semester->id,
            'instructor_id' => $this->instructorA->id,
            'section_number' => '1',
            'capacity' => 30,
        ]);
        $this->sectionA2 = CourseSection::create([
            'course_id' => $courseA->id,
            'semester_id' => $semester->id,
            'instructor_id' => $this->instructorA->id,
            'section_number' => '2',
            'capacity' => 30,
        ]);
        $this->sectionB = CourseSection::create([
            'course_id' => $courseB->id,
            'semester_id' => $semester->id,
            'instructor_id' => $this->instructorB->id,
            'section_number' => '1',
            'capacity' => 30,
        ]);

        $this->enrollmentA = Enrollment::create([
            'student_id' => $this->studentA->id,
            'section_id' => $this->sectionA->id,
            'status' => 'enrolled',
        ]);
        $this->enrollmentA2 = Enrollment::create([
            'student_id' => $this->studentA->id,
            'section_id' => $this->sectionA2->id,
            'status' => 'enrolled',
        ]);
        $enrollmentB = Enrollment::create([
            'student_id' => $this->studentB->id,
            'section_id' => $this->sectionB->id,
            'status' => 'enrolled',
        ]);

        $this->publishedGradeA = $this->makeGrade($this->enrollmentA, 'published');
        $this->draftGradeA = $this->makeGrade($this->enrollmentA2, 'draft');
        $this->publishedGradeB = $this->makeGrade($enrollmentB, 'published');

        $this->requestA = AcademicRequest::create([
            'student_id' => $this->studentA->id,
            'request_type' => 'grade_inquiry',
            'reason' => 'Request from college A student',
        ]);
        $this->requestB = AcademicRequest::create([
            'student_id' => $this->studentB->id,
            'request_type' => 'grade_inquiry',
            'reason' => 'Request from college B student',
        ]);
    }

    public function test_employee_is_limited_to_college_data_and_actions(): void
    {
        $this->actingAs($this->employeeA);

        $this->getJson('/course-sections')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['id' => $this->sectionA->id])
            ->assertJsonFragment(['id' => $this->sectionA2->id]);

        $this->getJson("/course-sections/{$this->sectionB->id}")
            ->assertNotFound();

        $this->getJson('/grades')
            ->assertOk()
            ->assertJsonCount(2, 'data');

        $this->postJson("/grades/{$this->publishedGradeB->id}/review")
            ->assertNotFound();

        $this->getJson('/academic-requests')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $this->requestA->id);
    }

    public function test_instructor_sees_only_assigned_sections_and_their_roster(): void
    {
        $this->actingAs($this->instructorA);

        $this->getJson('/course-sections')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['id' => $this->sectionA->id])
            ->assertJsonFragment(['id' => $this->sectionA2->id]);

        $this->getJson("/course-sections/{$this->sectionB->id}")
            ->assertNotFound();

        $this->getJson('/enrollments')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['id' => $this->enrollmentA->id])
            ->assertJsonFragment(['id' => $this->enrollmentA2->id]);
    }

    public function test_student_sees_only_own_enrollments_and_published_grades(): void
    {
        $this->actingAs($this->studentA);

        $this->getJson('/enrollments')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['id' => $this->enrollmentA->id])
            ->assertJsonFragment(['id' => $this->enrollmentA2->id]);

        $this->getJson('/grades')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $this->publishedGradeA->id);

        $this->getJson("/grades/{$this->draftGradeA->id}")
            ->assertNotFound();

        $this->getJson("/grades/{$this->publishedGradeB->id}")
            ->assertNotFound();

        $this->getJson('/academic-requests')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $this->requestA->id);
    }

    public function test_admin_keeps_global_access(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->getJson('/course-sections')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_employee_without_a_college_fails_closed(): void
    {
        $unassignedEmployee = User::factory()->create([
            'name' => 'Unassigned Employee',
            'email' => 'unassigned-employee@example.test',
            'role' => 'employee',
            'college_id' => null,
        ]);

        $this->actingAs($unassignedEmployee)
            ->getJson('/course-sections')
            ->assertOk()
            ->assertJsonCount(0, 'data');

        $this->getJson("/course-sections/{$this->sectionA->id}")
            ->assertNotFound();
    }

    public function test_student_can_browse_section_metadata_without_other_students(): void
    {
        $this->actingAs($this->studentA)
            ->getJson("/course-sections/{$this->sectionB->id}")
            ->assertOk()
            ->assertJsonPath('enrollments', []);
    }

    private function makeGrade(Enrollment $enrollment, string $status): Grade
    {
        return Grade::create([
            'enrollment_id' => $enrollment->id,
            'practical_grade' => 80,
            'theoretical_grade' => 85,
            'status' => $status,
        ]);
    }
}
