<?php

namespace Database\Seeders;

use App\Models\AcademicRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcademicRequestSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')
            ->where('is_active', true)
            ->pluck('id')
            ->values();

        $requests = [
            [
                'type' => 'grade_inquiry',
                'status' => 'pending',
                'reason' => 'I would like to review the details of my grade for the course and verify the recorded assessment results.',
            ],
            [
                'type' => 'grade_inquiry',
                'status' => 'approved',
                'reason' => 'I would like to request a review of the grade recorded for one of my courses.',
            ],
            [
                'type' => 'grade_inquiry',
                'status' => 'rejected',
                'reason' => 'I believe there may be an issue with the grade recorded for this course and would like it to be reviewed.',
            ],

            [
                'type' => 'enrollment_pause',
                'status' => 'pending',
                'reason' => 'I would like to request a temporary pause in my academic enrollment due to personal circumstances.',
            ],
            [
                'type' => 'enrollment_pause',
                'status' => 'approved',
                'reason' => 'I need to temporarily suspend my enrollment for the current academic period.',
            ],
            [
                'type' => 'enrollment_pause',
                'status' => 'rejected',
                'reason' => 'I am requesting a temporary suspension of enrollment due to circumstances that prevent me from continuing this semester.',
            ],

            [
                'type' => 'objection',
                'status' => 'pending',
                'reason' => 'I would like to submit an objection regarding an academic decision and request that it be reviewed.',
            ],
            [
                'type' => 'objection',
                'status' => 'approved',
                'reason' => 'I would like the academic decision related to my case to be reconsidered.',
            ],
            [
                'type' => 'objection',
                'status' => 'rejected',
                'reason' => 'I disagree with the academic decision and would like to formally submit an objection.',
            ],
        ];

        /*
         * Create multiple requests rather than only one
         * instance of each type/status combination.
         */
        foreach (range(1, 40) as $index) {
            $request = $requests[($index - 1) % count($requests)];

            $createdAt = now()->subDays(random_int(1, 120));

            AcademicRequest::create([
                'student_id' => $students->random(),

                'request_type' => $request['type'],

                'reason' => $request['reason'],

                'status' => $request['status'],

                'qr_code_token' => in_array($request['status'], [
                    'approved',
                    'rejected',
                ])
                    ? Str::uuid()->toString()
                    : null,

                'created_at' => $createdAt,

                'updated_at' => $request['status'] === 'pending'
                    ? $createdAt
                    : $createdAt->copy()->addDays(random_int(1, 5)),
            ]);
        }
    }
}