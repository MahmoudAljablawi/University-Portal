<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    public function run(): void
    {
        $colleges = [
            [
                'name' => 'College of Information Technology',
                'code' => 'IT',
            ],
            [
                'name' => 'College of Engineering',
                'code' => 'ENG',
            ],
            [
                'name' => 'College of Science',
                'code' => 'SCI',
            ],
            [
                'name' => 'College of Business Administration',
                'code' => 'BUS',
            ],
            [
                'name' => 'College of Arts and Humanities',
                'code' => 'ART',
            ],
        ];

        foreach ($colleges as $college) {
            College::create($college);
        }
    }
}