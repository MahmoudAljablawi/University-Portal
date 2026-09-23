@extends('layouts.app')

@section('title', __('navigation.dashboard'))

@section('content')

    @php
        $user = auth()->user();

        $roleLabels = [
            'admin' => 'Administrator',
            'teacher' => 'Instructor',
            'employee' => 'Employee',
            'student' => 'Student',
        ];

        $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);
    @endphp


    {{-- =========================================================
         Page Header
    ========================================================== --}}

    <div class="mb-8">

        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            {{ __('navigation.dashboard') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Welcome back,
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $user->name }}
            </span>
        </p>

    </div>


    {{-- =========================================================
         Administrator Dashboard
    ========================================================== --}}

    @if ($user->role === 'admin')

        <div class="space-y-8">

            {{-- Statistics --}}
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Users
                    </p>

                    <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                        —
                    </p>
                </div>


                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Courses
                    </p>

                    <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                        —
                    </p>
                </div>


                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Sections
                    </p>

                    <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                        —
                    </p>
                </div>


                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Requests
                    </p>

                    <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                        —
                    </p>
                </div>

            </div>


            {{-- Quick Actions --}}
            <div>

                <h2 class="mb-4 text-lg font-semibold text-[var(--color-foreground)]">
                    Quick Actions
                </h2>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    <a
                        href="{{ route('users.index') }}"
                        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition hover:border-[var(--color-primary)] hover:shadow-sm"
                    >
                        <p class="font-semibold text-[var(--color-foreground)]">
                            Manage Users
                        </p>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            Manage students, teachers and employees.
                        </p>
                    </a>


                    <a
                        href="{{ route('courses.index') }}"
                        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition hover:border-[var(--color-primary)] hover:shadow-sm"
                    >
                        <p class="font-semibold text-[var(--color-foreground)]">
                            Manage Courses
                        </p>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            Manage university courses.
                        </p>
                    </a>


                    <a
                        href="{{ route('course-sections.index') }}"
                        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition hover:border-[var(--color-primary)] hover:shadow-sm"
                    >
                        <p class="font-semibold text-[var(--color-foreground)]">
                            Course Sections
                        </p>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            Manage course sections and instructors.
                        </p>
                    </a>


                    <a
                        href="{{ route('academic-requests.index') }}"
                        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition hover:border-[var(--color-primary)] hover:shadow-sm"
                    >
                        <p class="font-semibold text-[var(--color-foreground)]">
                            Academic Requests
                        </p>

                        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                            Review student requests.
                        </p>
                    </a>

                </div>

            </div>

        </div>


    {{-- =========================================================
         Teacher Dashboard
    ========================================================== --}}

    @elseif ($user->role === 'teacher')

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    My Sections
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>


            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Students
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>


            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Pending Grades
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>

        </div>


    {{-- =========================================================
         Employee Dashboard
    ========================================================== --}}

    @elseif ($user->role === 'employee')

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Pending Grade Reviews
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>


            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Academic Requests
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>


            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Completed Reviews
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>

        </div>


    {{-- =========================================================
         Student Dashboard
    ========================================================== --}}

    @elseif ($user->role === 'student')

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    My Courses
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>


            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    My Grades
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>


            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    My Requests
                </p>

                <p class="mt-2 text-3xl font-bold text-[var(--color-foreground)]">
                    —
                </p>
            </div>

        </div>

    @endif

@endsection

