<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CollegeSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            AcademicSemesterSeeder::class,
            CourseSeeder::class,
            CourseSectionSeeder::class,
            EnrollmentSeeder::class,
            GradeSeeder::class,
            AcademicRequestSeeder::class,
        ]);
    }
}