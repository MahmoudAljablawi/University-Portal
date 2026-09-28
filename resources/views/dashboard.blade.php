
@extends('layouts.app')

@section('title', __('navigation.dashboard'))

@section('content')

    @php
        $roleLabels = [
            'admin' => __('Administrator'),
            'instructor' => __('Instructor'),
            'teacher' => __('Instructor'),
            'employee' => __('Employee'),
            'student' => __('Student'),
        ];

        $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);

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
            'teacher' => [
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

        $currentRole = $roleConfig[$user->role] ?? [
            'label' => $roleLabel,
            'description' => __('Welcome to the University Portal.'),
            'icon' => 'dashboard',
        ];

        $iconPaths = [
            'users' => 'M15 19.5a3 3 0 01-6 0M4.5 19.5a7.5 7.5 0 0115 0M12 12a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z',
            'courses' => 'M4.5 5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25v13.5a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V5.25zM8.25 7.5h7.5M8.25 11.25h7.5M8.25 15h4.5',
            'sections' => 'M4.5 6.75A2.25 2.25 0 016.75 4.5h10.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V6.75zM8.25 8.25h7.5M8.25 12h7.5M8.25 15.75h4.5',
            'requests' => 'M7.5 3.75h9A2.25 2.25 0 0118.75 6v12A2.25 2.25 0 0116.5 20.25h-9A2.25 2.25 0 015.25 18V6A2.25 2.25 0 017.5 3.75zM8.25 8.25h7.5M8.25 12h7.5M8.25 15.75h4.5',
            'grades' => 'M9 12.75l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'students' => 'M15 19.5a3 3 0 01-6 0M4.5 19.5a7.5 7.5 0 0115 0M12 12a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z',
            'reviews' => 'M9 12.75l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ];
    @endphp

    {{-- Hero --}}
    <section class="relative mb-8 overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
        <div class="absolute -end-20 -top-24 h-64 w-64 rounded-full bg-[var(--color-primary)] opacity-[0.07] blur-3xl"></div>
        <div class="absolute -bottom-28 -start-20 h-56 w-56 rounded-full bg-[var(--color-primary)] opacity-[0.05] blur-3xl"></div>

        <div class="relative flex flex-col gap-6 p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-primary)] text-white shadow-lg shadow-blue-500/20">
                    @if ($currentRole['icon'] === 'shield')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M12 3l7 3v5.25c0 4.5-3 7.75-7 9.75-4-2-7-5.25-7-9.75V6l7-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M9.5 12l1.75 1.75L14.75 10" />
                        </svg>
                    @elseif ($currentRole['icon'] === 'academic')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M3 10.5L12 5l9 5.5-9 5-9-5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M7 12.75V17c2.75 2 7.25 2 10 0v-4.25M21 10.5v5" />
                        </svg>
                    @elseif ($currentRole['icon'] === 'briefcase')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M9 6V4.5A1.5 1.5 0 0110.5 3h3A1.5 1.5 0 0115 4.5V6M4.5 6h15A1.5 1.5 0 0121 7.5v10A1.5 1.5 0 0119.5 19h-15A1.5 1.5 0 013 17.5v-10A1.5 1.5 0 014.5 6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M3 11h18M10 11v1.5h4V11" />
                        </svg>
                    @elseif ($currentRole['icon'] === 'student')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M3 10.5L12 5l9 5.5-9 5-9-5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M7 12.75V17c2.75 2 7.25 2 10 0v-4.25" />
                        </svg>
                    @else
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4.5 5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25v13.5a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V5.25z" />
                        </svg>
                    @endif
                </div>

                <div>
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-[var(--color-primary)]">
                            {{ $currentRole['label'] }}
                        </span>

                        <span class="h-1 w-1 rounded-full bg-[var(--color-foreground-muted)]"></span>

                        <span class="text-xs text-[var(--color-foreground-muted)]">
                            {{ $roleLabel }}
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-[var(--color-foreground)] sm:text-3xl">
                        {{ __('Welcome back, :name', ['name' => $user->name]) }}
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[var(--color-foreground-muted)]">
                        {{ $currentRole['description'] }}
                    </p>
                </div>
            </div>

            <div class="hidden shrink-0 lg:block">
                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] px-5 py-4 text-center">
                    <p class="text-xs font-medium text-[var(--color-foreground-muted)]">
                        {{ __('Your role') }}
                    </p>

                    <p class="mt-1 text-sm font-bold text-[var(--color-foreground)]">
                        {{ $roleLabel }}
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- =========================================================
         Administrator Dashboard
    ========================================================== --}}

    @if ($user->role === 'admin')

        <div class="space-y-8">

            {{-- Statistics --}}
            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Platform Overview') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('A quick overview of the university platform.') }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    {{-- Users --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="absolute -end-8 -top-8 h-24 w-24 rounded-full bg-blue-500/10"></div>

                        <div class="relative flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Users') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold tracking-tight text-[var(--color-foreground)]">
                                    {{ $stats['users'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['users'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Registered platform users') }}
                        </p>
                    </div>

                    {{-- Courses --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="absolute -end-8 -top-8 h-24 w-24 rounded-full bg-violet-500/10"></div>

                        <div class="relative flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Courses') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold tracking-tight text-[var(--color-foreground)]">
                                    {{ $stats['courses'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['courses'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Available university courses') }}
                        </p>
                    </div>

                    {{-- Sections --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="absolute -end-8 -top-8 h-24 w-24 rounded-full bg-emerald-500/10"></div>

                        <div class="relative flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Sections') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold tracking-tight text-[var(--color-foreground)]">
                                    {{ $stats['sections'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['sections'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Active course sections') }}
                        </p>
                    </div>

                    {{-- Requests --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="absolute -end-8 -top-8 h-24 w-24 rounded-full bg-amber-500/10"></div>

                        <div class="relative flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Pending Requests') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold tracking-tight text-[var(--color-foreground)]">
                                    {{ $stats['requests'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['requests'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Requests waiting for action') }}
                        </p>
                    </div>

                </div>
            </section>


            {{-- Quick Actions --}}
            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Quick Actions') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Jump directly to the most frequently used areas.') }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    <a
                        href="{{ route('users.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['users'] }}" />
                                </svg>
                            </div>

                            <svg class="h-5 w-5 text-[var(--color-foreground-muted)] transition-transform group-hover:translate-x-0.5 rtl:rotate-180 rtl:group-hover:-translate-x-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('Manage Users') }}
                        </h3>

                        <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                            {{ __('Manage system users and their roles.') }}
                        </p>
                    </a>


                    <a
                        href="{{ route('courses.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['courses'] }}" />
                                </svg>
                            </div>

                            <svg class="h-5 w-5 text-[var(--color-foreground-muted)] transition-transform group-hover:translate-x-0.5 rtl:rotate-180 rtl:group-hover:-translate-x-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('Manage Courses') }}
                        </h3>

                        <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                            {{ __('Manage university courses.') }}
                        </p>
                    </a>


                    <a
                        href="{{ route('course-sections.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['sections'] }}" />
                                </svg>
                            </div>

                            <svg class="h-5 w-5 text-[var(--color-foreground-muted)] transition-transform group-hover:translate-x-0.5 rtl:rotate-180 rtl:group-hover:-translate-x-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('Course Sections') }}
                        </h3>

                        <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                            {{ __('Manage sections and instructors.') }}
                        </p>
                    </a>


                    <a
                        href="{{ route('academic-requests.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['requests'] }}" />
                                </svg>
                            </div>

                            <svg class="h-5 w-5 text-[var(--color-foreground-muted)] transition-transform group-hover:translate-x-0.5 rtl:rotate-180 rtl:group-hover:-translate-x-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('Academic Requests') }}
                        </h3>

                        <p class="mt-1 text-sm leading-5 text-[var(--color-foreground-muted)]">
                            {{ __('Review and manage student requests.') }}
                        </p>
                    </a>

                </div>
            </section>

        </div>


    {{-- =========================================================
         Instructor Dashboard
    ========================================================== --}}

    @elseif ($user->role === 'instructor' || $user->role === 'teacher')

        <div class="space-y-8">

            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Teaching Overview') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Your current teaching activity at a glance.') }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('My Sections') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                                    {{ $stats['sections'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['sections'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Sections assigned to you') }}
                        </p>
                    </div>


                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Students') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                                    {{ $stats['students'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['students'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Students across your sections') }}
                        </p>
                    </div>


                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Pending Grades') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                                    {{ $stats['pending_grades'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['grades'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Grades waiting to be published') }}
                        </p>
                    </div>

                </div>
            </section>

            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Teaching Actions') }}
                    </h2>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <a
                        href="{{ route('course-sections.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <h3 class="font-semibold text-[var(--color-foreground)]">
                            {{ __('My Course Sections') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('View your assigned course sections.') }}
                        </p>
                    </a>

                    <a
                        href="{{ route('grades.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <h3 class="font-semibold text-[var(--color-foreground)]">
                            {{ __('Manage Grades') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Enter and manage grades for your students.') }}
                        </p>
                    </a>
                </div>
            </section>

        </div>


    {{-- =========================================================
         Employee Dashboard
    ========================================================== --}}

    @elseif ($user->role === 'employee')

        <div class="space-y-8">

            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Operations Overview') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Monitor pending academic operations and requests.') }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                            {{ __('Pending Grade Reviews') }}
                        </p>

                        <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                            {{ $stats['pending_grade_reviews'] }}
                        </p>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Grades awaiting review') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                            {{ __('Academic Requests') }}
                        </p>

                        <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                            {{ $stats['requests'] }}
                        </p>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Requests requiring attention') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                            {{ __('Completed Reviews') }}
                        </p>

                        <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                            {{ $stats['completed_reviews'] }}
                        </p>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Reviews completed') }}
                        </p>
                    </div>

                </div>
            </section>

            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Quick Actions') }}
                    </h2>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <a
                        href="{{ route('academic-requests.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <h3 class="font-semibold text-[var(--color-foreground)]">
                            {{ __('Academic Requests') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Review and process student requests.') }}
                        </p>
                    </a>

                    <a
                        href="{{ route('grades.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <h3 class="font-semibold text-[var(--color-foreground)]">
                            {{ __('Grade Reviews') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Review available academic grades.') }}
                        </p>
                    </a>
                </div>
            </section>

        </div>


    {{-- =========================================================
         Student Dashboard
    ========================================================== --}}

    @elseif ($user->role === 'student')

        <div class="space-y-8">

            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Academic Overview') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Keep track of your academic progress and university services.') }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('My Courses') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                                    {{ $stats['courses'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['courses'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Currently enrolled courses') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Published Grades') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                                    {{ $stats['grades'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['grades'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Grades available to view') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                                    {{ __('Pending Requests') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                                    {{ $stats['requests'] }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                        d="{{ $iconPaths['requests'] }}" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('Requests awaiting processing') }}
                        </p>
                    </div>

                </div>
            </section>

            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Student Services') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Access your most important academic services.') }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    <a
                        href="{{ route('grades.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="{{ $iconPaths['grades'] }}" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('My Grades') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('View your published academic grades.') }}
                        </p>
                    </a>

                    <a
                        href="{{ route('enrollments.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="{{ $iconPaths['courses'] }}" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('My Enrollments') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('View your enrolled course sections.') }}
                        </p>
                    </a>

                    <a
                        href="{{ route('academic-requests.index') }}"
                        class="group rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[var(--color-primary)] hover:shadow-md"
                    >
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="{{ $iconPaths['requests'] }}" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold text-[var(--color-foreground)]">
                            {{ __('Academic Requests') }}
                        </h3>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Submit and track your university requests.') }}
                        </p>
                    </a>

                </div>
            </section>

        </div>

    @endif

@endsection
