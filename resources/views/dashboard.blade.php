@extends('layouts.app')

@section('title', __('navigation.dashboard'))

@section('content')


@php
    $roleLabels = [
        'admin' => __('Administrator'),
        'instructor' => __('Instructor'),
        'employee' => __('Employee'),
        'student' => __('Student'),
    ];

    $roleLabel = $roleLabels[$user->role] ?? __(ucfirst($user->role));

    $roleConfig = [
        'admin' => [
            'label' => __('Administration'),
            'description' => __('Manage the university platform, users, courses, and academic operations.'),
            'icon' => 'shield',
        ],
        'instructor' => [
            'label' => __('Academic Staff'),
            'description' => __('Manage your sections, students, and academic grades.'),
            'icon' => 'academic',
        ],
        'employee' => [
            'label' => __('University Services'),
            'description' => __('Review academic operations and manage student requests.'),
            'icon' => 'briefcase',
        ],
        'student' => [
            'label' => __('Student Portal'),
            'description' => __('Track your courses, grades, and university requests.'),
            'icon' => 'student',
        ],
    ];

    $config = $roleConfig[$user->role] ?? [
        'label' => $roleLabel,
        'description' => '',
        'icon' => 'dashboard',
    ];
@endphp

{{-- Hero --}}
<section class="mb-8">
    <div
        class="relative overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm"
    >
        {{-- Decorative background --}}
        <div
            class="pointer-events-none absolute -end-20 -top-24 h-64 w-64 rounded-full bg-[var(--color-primary)]/5 blur-3xl"
        ></div>

        <div class="relative p-6 sm:p-8 lg:p-9">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]"
                    >
                        @if ($config['icon'] === 'shield')
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3 4.5 6v5.25c0 4.65 3.18 8.94 7.5 10.5 4.32-1.56 7.5-5.85 7.5-10.5V6L12 3Z" />
                            </svg>
                        @elseif ($config['icon'] === 'academic')
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14.25 3.75 9.75 12 5.25l8.25 4.5L12 14.25Zm0 0v5.25m-5.25-7.125v4.5c1.65 1.125 3.375 1.687 5.25 1.687s3.6-.562 5.25-1.687v-4.5" />
                            </svg>
                        @elseif ($config['icon'] === 'briefcase')
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 6.75V5.625A1.875 1.875 0 0 1 10.875 3.75h2.25A1.875 1.875 0 0 1 15 5.625V6.75m-9.75 0h13.5A2.25 2.25 0 0 1 21 9v8.25a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 17.25V9a2.25 2.25 0 0 1 2.25-2.25Zm0 5.25h13.5" />
                            </svg>
                        @else
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0-6 0M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm9 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[var(--color-primary)]">
                            {{ $config['label'] }}
                        </p>

                        <h1 class="mt-1 text-2xl font-bold tracking-tight text-[var(--color-foreground)] sm:text-3xl">
                            {{ __('Welcome, :name', ['name' => $user->name]) }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-[var(--color-foreground-muted)]">
                            {{ $config['description'] }}
                        </p>
                    </div>

                </div>

                <div class="shrink-0">
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-2 text-sm font-medium text-[var(--color-foreground)]"
                    >
                        <span class="h-2 w-2 rounded-full bg-[var(--color-success)]"></span>
                        {{ $roleLabel }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ========================================================= --}}
{{-- ADMIN --}}
{{-- ========================================================= --}}

@if ($user->role === 'admin')

    <section class="mb-8">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Overview') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Overview of the university platform and academic workflow.') }}
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <x-stat-card
                :title="__('Users')"
                :value="$stats['users'] ?? 0"
                :description="__('Registered users')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19a3 3 0 0 1-6 0m9-7a6 6 0 1 0-12 0 6 6 0 0 0 12 0Zm-3.5-6.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Courses')"
                :value="$stats['courses'] ?? 0"
                :description="__('Available courses')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Course Sections')"
                :value="$stats['sections'] ?? 0"
                :description="__('Active course sections')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Pending Requests')"
                :value="$stats['requests'] ?? 0"
                :description="__('Requests awaiting processing')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6.586a2 2 0 0 1 1.414.586l3.414 3.414A2 2 0 0 1 19 8.414V19a2 2 0 0 1-2 2Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Pending Grade Reviews')"
                :value="$stats['pending_grade_approvals'] ?? 0"
                :description="__('Grades awaiting administration approval')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Approved Grades')"
                :value="$stats['approved_grades'] ?? 0"
                :description="__('Grades awaiting publication')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Published Grades')"
                :value="$stats['published_grades'] ?? 0"
                :description="__('Grades visible to students')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.25 12.75 9 16.5l9.75-9.75" />
                </svg>
            </x-stat-card>

        </div>
    </section>

    {{-- Admin Actions --}}
    <section>

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Quick Actions') }}
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <a href="{{ route('users.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19a3 3 0 0 1-6 0m9-7a6 6 0 1 0-12 0 6 6 0 0 0 12 0Zm-3.5-6.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" />
                        </svg>
                    </div>

                    <span class="text-[var(--color-foreground-muted)] transition group-hover:text-[var(--color-primary)]">
                        →
                    </span>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Manage Users') }}
                </h3>

                <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                    {{ __('Manage university users and roles.') }}
                </p>
            </a>

            <a href="{{ route('courses.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <span class="text-[var(--color-foreground-muted)] transition group-hover:text-[var(--color-primary)]">
                        →
                    </span>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Manage Courses') }}
                </h3>

                <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                    {{ __('Manage courses and academic information.') }}
                </p>
            </a>

            <a href="{{ route('course-sections.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </div>

                    <span class="text-[var(--color-foreground-muted)] transition group-hover:text-[var(--color-primary)]">
                        →
                    </span>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Course Sections') }}
                </h3>

                <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                    {{ __('Manage course sections and assignments.') }}
                </p>
            </a>

            <a href="{{ route('grades.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>

                    <span class="text-[var(--color-foreground-muted)] transition group-hover:text-[var(--color-primary)]">
                        →
                    </span>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Grade Workflow') }}
                </h3>

                <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                    {{ __('Review, approve, and publish grades.') }}
                </p>
            </a>

        </div>
    </section>


{{-- ========================================================= --}}
{{-- INSTRUCTOR --}}
{{-- ========================================================= --}}

@elseif ($user->role === 'instructor')

    <section class="mb-8">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Teaching Overview') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Overview of your teaching sections, students, and grades.') }}
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <x-stat-card
                :title="__('My Sections')"
                :value="$stats['sections'] ?? 0"
                :description="__('Sections assigned to you')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Students')"
                :value="$stats['students'] ?? 0"
                :description="__('Students in your sections')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0-12 0M15 11.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a9 9 0 0 1-3 6.708M18 8.25a3 3 0 0 1 0 5.25M3 14.25a3 3 0 0 0 0 5.25M6 8.25a3 3 0 0 0 0 5.25" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Grades Requiring Attention')"
                :value="$stats['pending_grades'] ?? 0"
                :description="__('Draft or rejected grades')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0 3.75h.008M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Draft Grades')"
                :value="$stats['draft_grades'] ?? 0"
                :description="__('Grades not yet submitted')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.75v10.5m-5.25-5.25h10.5" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Rejected Grades')"
                :value="$stats['rejected_grades'] ?? 0"
                :description="__('Grades requiring correction')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Submitted Grades')"
                :value="$stats['submitted_grades'] ?? 0"
                :description="__('Grades awaiting employee review')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9 12.75 2.25 2.25L15.75 9M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-stat-card>

        </div>
    </section>

    <section>

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Quick Actions') }}
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">

            <a href="{{ route('course-sections.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('My Course Sections') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('View and manage your assigned sections.') }}
                </p>
            </a>

            <a href="{{ route('grades.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Manage Grades') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Enter, edit, and submit student grades.') }}
                </p>
            </a>

        </div>
    </section>


{{-- ========================================================= --}}
{{-- EMPLOYEE --}}
{{-- ========================================================= --}}

@elseif ($user->role === 'employee')

    <section class="mb-8">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Work Overview') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Review academic operations and process student requests.') }}
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <x-stat-card
                :title="__('Pending Grade Reviews')"
                :value="$stats['pending_grade_reviews'] ?? 0"
                :description="__('Grades submitted for review')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0 3.75h.008M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Academic Requests')"
                :value="$stats['requests'] ?? 0"
                :description="__('Requests awaiting processing')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6.586a2 2 0 0 1 1.414.586l3.414 3.414A2 2 0 0 1 19 8.414V19a2 2 0 0 1-2 2Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Completed Reviews')"
                :value="$stats['completed_reviews'] ?? 0"
                :description="__('Grades reviewed by employees')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-stat-card>

        </div>
    </section>

    <section>

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Quick Actions') }}
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">

            <a href="{{ route('academic-requests.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6.586a2 2 0 0 1 1.414.586l3.414 3.414A2 2 0 0 1 19 8.414V19a2 2 0 0 1-2 2Z" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Academic Requests') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Review and process student requests.') }}
                </p>
            </a>

            <a href="{{ route('grades.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Grade Reviews') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Review submitted grades and record decisions.') }}
                </p>
            </a>

        </div>
    </section>


{{-- ========================================================= --}}
{{-- STUDENT --}}
{{-- ========================================================= --}}

@elseif ($user->role === 'student')

    <section class="mb-8">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Academic Overview') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Track your courses, published grades, and university requests.') }}
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <x-stat-card
                :title="__('My Courses')"
                :value="$stats['courses'] ?? 0"
                :description="__('Currently enrolled courses')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Published Grades')"
                :value="$stats['grades'] ?? 0"
                :description="__('Grades currently visible to you')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-stat-card>

            <x-stat-card
                :title="__('Pending Requests')"
                :value="$stats['requests'] ?? 0"
                :description="__('Your requests awaiting processing')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6.586a2 2 0 0 1 1.414.586l3.414 3.414A2 2 0 0 1 19 8.414V19a2 2 0 0 1-2 2Z" />
                </svg>
            </x-stat-card>

        </div>
    </section>

    <section>

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[var(--color-foreground)]">
                {{ __('Quick Actions') }}
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <a href="{{ route('grades.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('My Grades') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('View your published academic grades.') }}
                </p>
            </a>

            <a href="{{ route('enrollments.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('My Enrollments') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('View your course enrollments.') }}
                </p>
            </a>

            <a href="{{ route('academic-requests.index') }}"
               class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6.586a2 2 0 0 1 1.414.586l3.414 3.414A2 2 0 0 1 19 8.414V19a2 2 0 0 1-2 2Z" />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-[var(--color-foreground)]">
                    {{ __('Academic Requests') }}
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Submit and track your university requests.') }}
                </p>
            </a>

        </div>
    </section>

@endif


@endsection
