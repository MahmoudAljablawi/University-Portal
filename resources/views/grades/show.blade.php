
@extends('layouts.app')

@section('title', 'Grade Details')

@section('content')

@php
    $userRole = auth()->user()->role;
    $isStudent = $userRole === 'student';
    $canManageGrades = in_array($userRole, ['admin', 'instructor']);
@endphp

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                Grade Details
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ $isStudent
                    ? 'View your published grade.'
                    : 'View the recorded grade and enrollment information.'
                }}
            </p>
        </div>


        @if ($canManageGrades)
            <a
                href="{{ route('grades.edit', $grade) }}"
                class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
            >
                Edit Grade
            </a>
        @endif

    </div>


    {{-- Enrollment Information --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
            Enrollment Information
        </h2>


        <div class="mt-6 grid gap-6 sm:grid-cols-2">

            {{-- Student --}}
            @if (! $isStudent)

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                        Student
                    </p>

                    <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                        {{ $grade->enrollment?->student?->name ?? '—' }}
                    </p>
                </div>

            @endif


            {{-- Course --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Course
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->enrollment?->section?->course?->name ?? '—' }}
                </p>

                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $grade->enrollment?->section?->course?->code ?? '—' }}
                </p>

            </div>


            {{-- Section --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Section
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->enrollment?->section?->section_number ?? '—' }}
                </p>

            </div>


            {{-- Semester --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Semester
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->enrollment?->section?->semester?->name ?? '—' }}
                </p>

            </div>

        </div>

    </div>


    {{-- Grade Information --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
            Grade Information
        </h2>


        <div class="mt-6 grid gap-6 sm:grid-cols-2">

            {{-- Midterm --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Midterm Grade
                </p>

                <p class="mt-1 text-lg font-semibold text-[var(--color-foreground)]">
                    {{ $grade->midterm_grade ?? '—' }}
                </p>

            </div>


            {{-- Final --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Final Grade
                </p>

                <p class="mt-1 text-lg font-semibold text-[var(--color-foreground)]">
                    {{ $grade->final_grade ?? '—' }}
                </p>

            </div>


            {{-- Total --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Total Grade
                </p>

                <p class="mt-1 text-2xl font-bold text-[var(--color-primary)]">
                    {{ $grade->total_grade ?? '—' }}
                </p>

            </div>


            {{-- Letter --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Letter Grade
                </p>

                <div class="mt-2">

                    @if ($grade->letter_grade)

                        <span class="inline-flex rounded-full bg-[var(--color-sidebar-active)] px-3 py-1.5 text-sm font-semibold text-[var(--color-primary)]">
                            {{ $grade->letter_grade }}
                        </span>

                    @else

                        <span class="text-sm text-[var(--color-foreground-muted)]">
                            —
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- Publication Status --}}
        @if (! $isStudent)

            <div class="mt-6 border-t border-[var(--color-border)] pt-6">

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Publication Status
                </p>

                <div class="mt-2">

                    @if ($grade->is_published)

                        <span class="inline-flex rounded-full bg-[var(--color-success)]/10 px-3 py-1.5 text-sm font-semibold text-[var(--color-success)]">
                            Published
                        </span>

                    @else

                        <span class="inline-flex rounded-full bg-[var(--color-warning)]/10 px-3 py-1.5 text-sm font-semibold text-[var(--color-warning)]">
                            Not Published
                        </span>

                    @endif

                </div>

            </div>

        @endif

    </div>


    {{-- Back --}}
    <div>

        <a
            href="{{ route('grades.index') }}"
            class="inline-flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
        >
            ← Back to Grades
        </a>

    </div>

</div>

@endsection
