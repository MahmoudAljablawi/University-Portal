<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // Get colleges by code for assigning employees.
        $colleges = College::pluck('id', 'code');

        /*
        |--------------------------------------------------------------------------
        | Admins
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@university.test',
            'password' => $password,
            'phone' => '+963 911 000 001',
            'role' => 'admin',
            'college_id' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Academic Administrator',
            'email' => 'admin2@university.test',
            'password' => $password,
            'phone' => '+963 911 000 002',
            'role' => 'admin',
            'college_id' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        */

        $employees = [
            [
                'name' => 'Ahmad Al Hassan',
                'email' => 'employee1@university.test',
                'phone' => '+963 911 100 001',
                'college_code' => 'IT',
            ],
            [
                'name' => 'Sara Mahmoud',
                'email' => 'employee2@university.test',
                'phone' => '+963 911 100 002',
                'college_code' => 'IT',
            ],
            [
                'name' => 'Omar Khalil',
                'email' => 'employee3@university.test',
                'phone' => '+963 911 100 003',
                'college_code' => 'ENG',
            ],
            [
                'name' => 'Lina Ibrahim',
                'email' => 'employee4@university.test',
                'phone' => '+963 911 100 004',
                'college_code' => 'SCI',
            ],
            [
                'name' => 'Maya Saleh',
                'email' => 'employee5@university.test',
                'phone' => '+963 911 100 005',
                'college_code' => 'BUS',
            ],
        ];

        foreach ($employees as $employee) {
            User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'phone' => $employee['phone'],
                'password' => $password,
                'role' => 'employee',
                'college_id' => $colleges[$employee['college_code']],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Instructors
        |--------------------------------------------------------------------------
        */

        $instructors = [
            'Dr. Ahmad Al Ali',
            'Dr. Omar Hassan',
            'Dr. Sara Khaled',
            'Dr. Lina Mahmoud',
            'Dr. Youssef Ibrahim',
            'Dr. Nour Al Hassan',
            'Dr. Khaled Saleh',
            'Dr. Rana Ahmad',
            'Dr. Samer Khalil',
            'Dr. Huda Omar',
            'Dr. Tareq Mahmoud',
            'Dr. Rami Hassan',
        ];

        foreach ($instructors as $index => $name) {
            User::create([
                'name' => $name,
                'email' => 'instructor' . ($index + 1) . '@university.test',
                'password' => $password,
                'phone' => '+963 911 200 ' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'role' => 'instructor',
                'college_id' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */

        $students = [
            'Mohammad Ahmad',
            'Ali Hassan',
            'Omar Khaled',
            'Yazan Mahmoud',
            'Laith Ibrahim',
            'Khaled Saleh',
            'Hussein Omar',
            'Tareq Ahmad',
            'Samer Khalil',
            'Mahmoud Youssef',
            'Rami Hassan',
            'Anas Ali',
            'Zaid Mahmoud',
            'Fadi Khaled',
            'Nour Hassan',
            'Lina Ahmad',
            'Sara Ali',
            'Rana Mahmoud',
            'Huda Khalil',
            'Maya Hassan',
        ];

        foreach ($students as $index => $name) {
            User::create([
                'name' => $name,
                'email' => 'student' . ($index + 1) . '@university.test',
                'password' => $password,
                'phone' => '+963 911 300 ' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'role' => 'student',
                'college_id' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Inactive Student
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'Inactive Student',
            'email' => 'inactive.student@university.test',
            'password' => $password,
            'phone' => '+963 911 399 999',
            'role' => 'student',
            'college_id' => null,
            'is_active' => false,
            'email_verified_at' => now(),
        ]);
    }
}