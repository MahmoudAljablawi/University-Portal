<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $colleges = College::pluck('id', 'code');

        $departments = [
            // College of Information Technology
            [
                'name' => 'Computer Science',
                'code' => 'CS',
                'college_code' => 'IT',
            ],
            [
                'name' => 'Information Systems',
                'code' => 'IS',
                'college_code' => 'IT',
            ],
            [
                'name' => 'Software Engineering',
                'code' => 'SE',
                'college_code' => 'IT',
            ],

            // College of Engineering
            [
                'name' => 'Civil Engineering',
                'code' => 'CE',
                'college_code' => 'ENG',
            ],
            [
                'name' => 'Electrical Engineering',
                'code' => 'EE',
                'college_code' => 'ENG',
            ],
            [
                'name' => 'Mechanical Engineering',
                'code' => 'ME',
                'college_code' => 'ENG',
            ],

            // College of Science
            [
                'name' => 'Mathematics',
                'code' => 'MATH',
                'college_code' => 'SCI',
            ],
            [
                'name' => 'Physics',
                'code' => 'PHY',
                'college_code' => 'SCI',
            ],
            [
                'name' => 'Chemistry',
                'code' => 'CHEM',
                'college_code' => 'SCI',
            ],

            // College of Business Administration
            [
                'name' => 'Business Administration',
                'code' => 'BA',
                'college_code' => 'BUS',
            ],
            [
                'name' => 'Accounting',
                'code' => 'ACC',
                'college_code' => 'BUS',
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'college_code' => 'BUS',
            ],

            // College of Arts and Humanities
            [
                'name' => 'English Language',
                'code' => 'ENG-L',
                'college_code' => 'ART',
            ],
            [
                'name' => 'History',
                'code' => 'HIS',
                'college_code' => 'ART',
            ],
            [
                'name' => 'Arabic Language',
                'code' => 'AR',
                'college_code' => 'ART',
            ],
        ];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department['name'],
                'code' => $department['code'],
                'college_id' => $colleges[$department['college_code']],
            ]);
        }
    }
}