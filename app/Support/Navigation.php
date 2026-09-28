<?php

namespace App\Support;

class Navigation
{
    public static function items(): array
    {
        return [
            [
                'label' => 'navigation.dashboard',
                'route' => 'dashboard',
                'url' => 'dashboard',
                'roles' => ['admin', 'instructor', 'student'],
                'icon' => 'dashboard',
            ],

            [
                'label' => 'navigation.users',
                'route' => 'users.*',
                'url' => 'users.index',
                'roles' => ['admin'],
                'icon' => 'users',
            ],

            [
                'label' => 'navigation.colleges',
                'route' => 'colleges.*',
                'url' => 'colleges.index',
                'roles' => ['admin'],
                'icon' => 'colleges',
            ],

            [
                'label' => 'navigation.departments',
                'route' => 'departments.*',
                'url' => 'departments.index',
                'roles' => ['admin'],
                'icon' => 'departments',
            ],

            [
                'label' => 'navigation.academic_semesters',
                'route' => 'academic-semesters.*',
                'url' => 'academic-semesters.index',
                'roles' => ['admin', 'instructor', 'student'],
                'icon' => 'academic-semesters',
            ],

            [
                'label' => 'navigation.courses',
                'route' => 'courses.*',
                'url' => 'courses.index',
                'roles' => ['admin', 'instructor', 'student'],
                'icon' => 'courses',
            ],

            [
                'label' => 'navigation.course_sections',
                'route' => 'course-sections.*',
                'url' => 'course-sections.index',
                'roles' => ['admin', 'instructor', 'student'],
                'icon' => 'course-sections',
            ],

            [
                'label' => 'navigation.enrollments',
                'route' => 'enrollments.*',
                'url' => 'enrollments.index',
                'roles' => ['admin', 'instructor', 'student'],
                'icon' => 'enrollments',
            ],

            [
                'label' => 'navigation.grades',
                'route' => 'grades.*',
                'url' => 'grades.index',
                'roles' => ['admin', 'instructor', 'student'],
                'icon' => 'grades',
            ],

            [
                'label' => 'navigation.academic_requests',
                'route' => 'academic-requests.*',
                'url' => 'academic-requests.index',
                'roles' => ['admin', 'student'],
                'icon' => 'academic-requests',
            ],

            [
                'label' => 'navigation.audit_logs',
                'route' => 'audit-logs.*',
                'url' => 'audit-logs.index',
                'roles' => ['admin'],
                'icon' => 'audit-logs',
            ],
        ];
    }
}