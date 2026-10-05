<?php

namespace Database\Seeders;

use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')
            ->where('is_active', true)
            ->pluck('id')
            ->values();

        $sections = CourseSection::query()
            ->orderBy('semester_id')
            ->orderBy('id')
            ->get();

        foreach ($sections as $section) {
            $studentsPerSection = min(
                $section->capacity,
                random_int(8, 18)
            );

            $selectedStudents = $students
                ->shuffle()
                ->take($studentsPerSection);

            foreach ($selectedStudents as $studentId) {
                $status = $this->randomStatus(
                    $section->semester_id === $sections->max('semester_id')
                );

                Enrollment::create([
                    'student_id' => $studentId,
                    'section_id' => $section->id,
                    'status' => $status,
                ]);
            }
        }
    }

    private function randomStatus(bool $isCurrentSemester): string
    {
        if ($isCurrentSemester) {
            return fake()->randomElement([
                'enrolled',
                'enrolled',
                'enrolled',
                'dropped',
            ]);
        }

        return fake()->randomElement([
            'passed',
            'passed',
            'passed',
            'failed',
            'enrolled',
            'dropped',
        ]);
    }
}