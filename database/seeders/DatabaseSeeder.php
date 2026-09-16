<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\College;
use App\Models\Department;
use App\Models\Course;
use App\Models\AcademicSemester;
use App\Models\CourseSection;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Base Users
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@portal.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+963911111111',
            'is_active' => true,
        ]);

        $instructor = User::create([
            'name' => 'Dr. John Doe',
            'email' => 'instructor@portal.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'phone' => '+963922222222',
            'is_active' => true,
        ]);

        $student = User::create([
            'name' => 'Mahmoud Aljablawi',
            'email' => 'student@portal.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+963933333333',
            'is_active' => true,
        ]);

        // 2. Create Colleges
        $college = College::create([
            'name' => 'Faculty of Informatics Engineering',
            'code' => 'CEI',
        ]);

        // 3. Create Departments
        $deptAI = Department::create([
            'name' => 'Artificial Intelligence Department',
            'code' => 'AI',
            'college_id' => $college->id,
        ]);

        $deptSE = Department::create([
            'name' => 'Software Engineering Department',
            'code' => 'SE',
            'college_id' => $college->id,
        ]);

        // 4. Create Academic Semesters
        $semester = AcademicSemester::create([
            'name' => 'Fall 2026 Semester',
            'code' => 'FALL-2026',
            'start_date' => '2026-09-01',
            'end_date' => '2027-01-15',
            'is_active' => true,
        ]);

        // 5. Create Courses
        $course1 = Course::create([
            'name' => 'Advanced Machine Learning',
            'code' => 'AI401',
            'department_id' => $deptAI->id,
            'credits' => 3,
            'semester_level' => 4, 
            'description' => 'Advanced studies in machine learning algorithms and neural networks.',
        ]);

        $course2 = Course::create([
            'name' => 'Advanced Software Engineering',
            'code' => 'SE302',
            'department_id' => $deptSE->id,
            'credits' => 3,
            'semester_level' => 3,
            'description' => 'Study of design patterns and distributed application development.',
        ]);

        // 6. Create Course Sections
        CourseSection::create([
            'course_id' => $course1->id,
            'semester_id' => $semester->id,
            'instructor_id' => $instructor->id,
            'section_number' => 1,
            'capacity' => 40,
        ]);

        CourseSection::create([
            'course_id' => $course2->id,
            'semester_id' => $semester->id,
            'instructor_id' => $instructor->id,
            'section_number' => 1,
            'capacity' => 35,
        ]);
    }
}
