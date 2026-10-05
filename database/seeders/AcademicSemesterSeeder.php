<?php

namespace Database\Seeders;

use App\Models\AcademicSemester;
use Illuminate\Database\Seeder;

class AcademicSemesterSeeder extends Seeder
{
    public function run(): void
    {
        $semesters = [
            [
                'name' => 'Fall 2023',
                'code' => '2023-FALL',
                'start_date' => '2023-09-01',
                'end_date' => '2024-01-15',
                'is_active' => false,
            ],
            [
                'name' => 'Spring 2024',
                'code' => '2024-SPRING',
                'start_date' => '2024-02-01',
                'end_date' => '2024-06-15',
                'is_active' => false,
            ],
            [
                'name' => 'Fall 2024',
                'code' => '2024-FALL',
                'start_date' => '2024-09-01',
                'end_date' => '2025-01-15',
                'is_active' => false,
            ],
            [
                'name' => 'Spring 2025',
                'code' => '2025-SPRING',
                'start_date' => '2025-02-01',
                'end_date' => '2025-06-15',
                'is_active' => false,
            ],
            [
                'name' => 'Fall 2025',
                'code' => '2025-FALL',
                'start_date' => '2025-09-01',
                'end_date' => '2026-01-15',
                'is_active' => false,
            ],
            [
                'name' => 'Spring 2026',
                'code' => '2026-SPRING',
                'start_date' => '2026-02-01',
                'end_date' => '2026-06-15',
                'is_active' => true,
            ],
        ];

        foreach ($semesters as $semester) {
            AcademicSemester::create($semester);
        }
    }
}