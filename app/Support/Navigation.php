<?php
namespace App\Support;

class Navigation
{
    public static function items(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.dashboard',
                'route' => 'dashboard',
                'url' => 'dashboard',
                'roles' => [
                    'admin',
                    'teacher',
                    'employee',
                    'student',
                ],
                'icon' => 'dashboard',
            ],

            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            |
            | Admin manages users.
            | Students, teachers and employees are users differentiated by role.
            |
            */

            [
                'label' => 'navigation.users',
                'route' => 'users.*',
                'url' => 'users.index',
                'roles' => [
                    'admin',
                ],
                'icon' => 'users',
            ],

            /*
            |--------------------------------------------------------------------------
            | Colleges
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.colleges',
                'route' => 'colleges.*',
                'url' => 'colleges.index',
                'roles' => [
                    'admin',
                ],
                'icon' => 'colleges',
            ],

            /*
            |--------------------------------------------------------------------------
            | Departments
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.departments',
                'route' => 'departments.*',
                'url' => 'departments.index',
                'roles' => [
                    'admin',
                ],
                'icon' => 'departments',
            ],

            /*
            |--------------------------------------------------------------------------
            | Courses
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.courses',
                'route' => 'courses.*',
                'url' => 'courses.index',
                'roles' => [
                    'admin',
                    'teacher',
                    'student',
                ],
                'icon' => 'courses',
            ],

            /*
            |--------------------------------------------------------------------------
            | Course Sections
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.course_sections',
                'route' => 'course-sections.*',
                'url' => 'course-sections.index',
                'roles' => [
                    'admin',
                    'teacher',
                    'student',
                ],
                'icon' => 'course-sections',
            ],

            /*
            |--------------------------------------------------------------------------
            | Grades
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.grades',
                'route' => 'grades.*',
                'url' => 'grades.index',
                'roles' => [
                    'admin',
                    'teacher',
                    'employee',
                    'student',
                ],
                'icon' => 'grades',
            ],

            /*
            |--------------------------------------------------------------------------
            | Academic Requests
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.academic_requests',
                'route' => 'academic-requests.*',
                'url' => 'academic-requests.index',
                'roles' => [
                    'admin',
                    'student',
                    'employee',
                ],
                'icon' => 'academic-requests',
            ],

            /*
            |--------------------------------------------------------------------------
            | Audit Logs
            |--------------------------------------------------------------------------
            */

            [
                'label' => 'navigation.audit_logs',
                'route' => 'audit-logs.*',
                'url' => 'audit-logs.index',
                'roles' => [
                    'admin',
                ],
                'icon' => 'audit-logs',
            ],

        ];
    }
}

