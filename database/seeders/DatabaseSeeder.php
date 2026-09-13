<?php

namespace Database\Seeders;

use App\Models\AcademicSemester;
use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. إنشاء المستخدمين (أدمن، أستاذ، طالب)
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@university.edu',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $instructor = User::create([
            'name' => 'Dr. John Doe',
            'email' => 'instructor@university.edu',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'is_active' => true,
        ]);

        $student = User::create([
            'name' => 'Alex Smith',
            'email' => 'student@university.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);

        // 2. إنشاء الكلية
        $college = College::create([
            'name' => 'كلية الهندسة المعلوماتية',
            'code' => 'ITE',
        ]);

        // 3. إنشاء القسم
        $department = Department::create([
            'name' => 'هندسة البرمجيات والذكاء الاصطناعي',
            'code' => 'SE-AI',
            'college_id' => $college->id,
        ]);

        // 4. إنشاء الفصل الأكاديمي
        $semester = AcademicSemester::create([
            'name' => 'الفصل الدراسي الأول 2026/2027',
            'code' => 'SEM-2026-1',
            'start_date' => '2026-10-01',
            'end_date' => '2027-02-01',
            'is_active' => true,
        ]);

        // 5. إنشاء مقرر دراسي
        $course = Course::create([
            'name' => 'هندسة البرمجيات ',
            'code' => 'SE401',
            'department_id' => $department->id,
            'credits' => 3,
            'semester_level' => 4,
            'description' => 'مقرر  في تصميم الأنظمة .',
        ]);
    }
}