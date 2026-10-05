<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $employeeIds = User::where('role', 'employee')
            ->where('is_active', true)
            ->pluck('id')
            ->values();

        $adminIds = User::where('role', 'admin')
            ->where('is_active', true)
            ->pluck('id')
            ->values();

        $enrollments = Enrollment::query()
            ->with('section')
            ->whereIn('status', [
                'enrolled',
                'passed',
                'failed',
            ])
            ->get();

        foreach ($enrollments as $enrollment) {
            /*
             * Not every enrollment needs a grade.
             * Keeping some enrollments without grades allows
             * us to test the "create grade" workflow.
             */
            if (fake()->boolean(30)) {
                continue;
            }

            $status = $this->randomGradeStatus();

            $practical = fake()->randomFloat(2, 15, 30);
            $theoretical = fake()->randomFloat(2, 35, 70);

            $gradeData = [
                'enrollment_id' => $enrollment->id,
                'practical_grade' => $practical,
                'theoretical_grade' => $theoretical,
                'status' => $status,
                'rejection_reason' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
                'approved_by' => null,
                'approved_at' => null,
                'published_at' => null,
            ];

            /*
             * Reviewed / Approved / Published
             * require employee review information.
             */
            if (in_array($status, [
                'reviewed',
                'approved',
                'published',
            ])) {
                $reviewedAt = now()->subDays(random_int(5, 20));

                $gradeData['reviewed_by'] = $employeeIds->random();
                $gradeData['reviewed_at'] = $reviewedAt;
            }

            /*
             * Approved / Published
             * require administration approval information.
             */
            if (in_array($status, [
                'approved',
                'published',
            ])) {
                $approvedAt = $gradeData['reviewed_at']->copy()
                    ->addDays(random_int(1, 3));

                $gradeData['approved_by'] = $adminIds->random();
                $gradeData['approved_at'] = $approvedAt;
            }

            /*
             * Published requires publication date.
             */
            if ($status === 'published') {
                $gradeData['published_at'] = $gradeData['approved_at']
                    ->copy()
                    ->addDays(random_int(1, 2));
            }

            /*
             * Rejected grades need a rejection reason.
             * The employee who rejected the grade is stored
             * in reviewed_by because rejection is part of
             * the employee review stage.
             */
            if ($status === 'rejected') {
                $gradeData['rejection_reason'] = fake()->randomElement([
                    'The practical grade does not match the submitted assessment records.',
                    'Please review the theoretical grade and resubmit the grade.',
                    'The submitted grade contains inconsistent assessment data.',
                    'The grade requires correction before it can be reviewed again.',
                ]);

                $gradeData['reviewed_by'] = $employeeIds->random();
                $gradeData['reviewed_at'] = now()->subDays(random_int(1, 10));
            }

            Grade::create($gradeData);
        }
    }

    private function randomGradeStatus(): string
    {
        return fake()->randomElement([
            'draft',
            'draft',
            'submitted',
            'submitted',
            'reviewed',
            'reviewed',
            'approved',
            'published',
            'published',
            'rejected',
        ]);
    }
}