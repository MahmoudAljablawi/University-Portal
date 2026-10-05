<?php

namespace Database\Seeders;

use App\Models\AcademicSemester;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::pluck('id', 'code');

        $semesters = AcademicSemester::pluck('id', 'code');

        $instructors = User::where('role', 'instructor')
            ->where('is_active', true)
            ->pluck('id')
            ->values();

        $sections = [
            // =========================
            // Fall 2025
            // =========================

            ['course' => 'CS101', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'CS201', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'CS301', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'CS302', 'semester' => '2025-FALL', 'sections' => 1],
            ['course' => 'CS303', 'semester' => '2025-FALL', 'sections' => 2],

            ['course' => 'IS201', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'IS301', 'semester' => '2025-FALL', 'sections' => 1],

            ['course' => 'SE201', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'SE301', 'semester' => '2025-FALL', 'sections' => 2],

            ['course' => 'CE101', 'semester' => '2025-FALL', 'sections' => 1],
            ['course' => 'EE101', 'semester' => '2025-FALL', 'sections' => 1],
            ['course' => 'ME201', 'semester' => '2025-FALL', 'sections' => 1],

            ['course' => 'MATH101', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'MATH201', 'semester' => '2025-FALL', 'sections' => 1],
            ['course' => 'PHY101', 'semester' => '2025-FALL', 'sections' => 2],

            ['course' => 'BA101', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'ACC101', 'semester' => '2025-FALL', 'sections' => 1],
            ['course' => 'ENG101', 'semester' => '2025-FALL', 'sections' => 2],
            ['course' => 'AR101', 'semester' => '2025-FALL', 'sections' => 1],

            // =========================
            // Spring 2026 - Active
            // =========================

            ['course' => 'CS101', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'CS201', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'CS301', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'CS303', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'CS401', 'semester' => '2026-SPRING', 'sections' => 2],

            ['course' => 'IS201', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'IS301', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'IS401', 'semester' => '2026-SPRING', 'sections' => 1],

            ['course' => 'SE201', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'SE301', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'SE302', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'SE401', 'semester' => '2026-SPRING', 'sections' => 1],

            ['course' => 'CE301', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'EE201', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'ME301', 'semester' => '2026-SPRING', 'sections' => 1],

            ['course' => 'MATH102', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'MATH201', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'PHY102', 'semester' => '2026-SPRING', 'sections' => 2],

            ['course' => 'BA201', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'ACC201', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'FIN201', 'semester' => '2026-SPRING', 'sections' => 1],

            ['course' => 'ENG201', 'semester' => '2026-SPRING', 'sections' => 2],
            ['course' => 'HIS201', 'semester' => '2026-SPRING', 'sections' => 1],
            ['course' => 'AR201', 'semester' => '2026-SPRING', 'sections' => 1],
        ];

        $instructorIndex = 0;

        foreach ($sections as $sectionData) {
            $courseId = $courses[$sectionData['course']];
            $semesterId = $semesters[$sectionData['semester']];

            for ($number = 1; $number <= $sectionData['sections']; $number++) {
                CourseSection::create([
                    'course_id' => $courseId,
                    'semester_id' => $semesterId,
                    'instructor_id' => $instructors[$instructorIndex % $instructors->count()],
                    'section_number' => 'Sec-' . $number,
                    'capacity' => $number === 1 ? 30 : 25,
                ]);

                $instructorIndex++;
            }
        }
    }
}