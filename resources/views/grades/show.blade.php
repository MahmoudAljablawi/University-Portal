@extends('layouts.app')

@section('title', __('Grade Details'))

@section('content')

@php
$userRole = auth()->user()->role;
$isStudent = $userRole === 'student';


$isInstructorOwner =
    $userRole === 'instructor' &&
    $grade->enrollment?->section?->instructor_id === auth()->id();

$statusClasses = match ($grade->status) {
    'draft' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
    'submitted' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
    'reviewed' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
    'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
    'published' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
    default => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
};

/*
|--------------------------------------------------------------------------
| Workflow permissions
|--------------------------------------------------------------------------
*/

$canEdit =
    in_array($userRole, ['admin', 'instructor']) &&
    in_array($grade->status, ['draft', 'rejected']) &&
    ($userRole === 'admin' || $isInstructorOwner);

$canSubmit =
    $userRole === 'instructor' &&
    $isInstructorOwner &&
    in_array($grade->status, ['draft', 'rejected']);

$canReview =
    $userRole === 'employee' &&
    $grade->status === 'submitted';

$canApprove =
    $userRole === 'admin' &&
    $grade->status === 'reviewed';

$canPublish =
    $userRole === 'admin' &&
    $grade->status === 'approved';

$canDelete =
    in_array($userRole, ['admin', 'instructor']) &&
    $grade->status === 'draft' &&
    ($userRole === 'admin' || $isInstructorOwner);


@endphp

<div class="mx-auto max-w-4xl space-y-6">


{{-- Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            {{ __('Grade Details') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ $isStudent
                ? 'View your published grade.'
                : 'View the recorded grade and workflow information.'
            }}
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">

        {{-- Edit --}}
        @if ($canEdit)
            <a
                href="{{ route('grades.edit', $grade) }}"
                class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
            >
                {{ __('Edit Grade') }}
            </a>
        @endif

    </div>

</div>


{{-- Enrollment Information --}}
<div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
        {{ __('Enrollment Information') }}
    </h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">

        {{-- Student --}}
        @if (! $isStudent)

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Student') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->enrollment?->student?->name ?? '—' }}
                </p>
            </div>

        @endif


        {{-- Course --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Course') }}
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
                {{ __('Section') }}
            </p>

            <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                {{ $grade->enrollment?->section?->section_number ?? '—' }}
            </p>

        </div>


        {{-- Semester --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Semester') }}
            </p>

            <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                {{ $grade->enrollment?->section?->semester?->name ?? '—' }}
            </p>

        </div>

    </div>

</div>


{{-- Grade Information --}}
<div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                {{ __('Grade Information') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Practical and theoretical assessment results.') }}
            </p>
        </div>

        {{-- Status --}}
        <span class="inline-flex w-fit rounded-full px-3 py-1.5 text-sm font-semibold {{ $statusClasses }}">
            {{ __(ucfirst($grade->status)) }}
        </span>

    </div>


    <div class="mt-6 grid gap-6 sm:grid-cols-3">

        {{-- Practical --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Practical Grade') }}
            </p>

            <p class="mt-1 text-lg font-semibold text-[var(--color-foreground)]">
                {{ $grade->practical_grade !== null
                    ? number_format($grade->practical_grade, 2)
                    : '—'
                }}
            </p>

            <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                {{ __('Weight: 30%') }}
            </p>

        </div>


        {{-- Theoretical --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Theoretical Grade') }}
            </p>

            <p class="mt-1 text-lg font-semibold text-[var(--color-foreground)]">
                {{ $grade->theoretical_grade !== null
                    ? number_format($grade->theoretical_grade, 2)
                    : '—'
                }}
            </p>

            <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                {{ __('Weight: 70%') }}
            </p>

        </div>


        {{-- Total --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Total Grade') }}
            </p>

            <p class="mt-1 text-2xl font-bold text-[var(--color-primary)]">
                {{ $grade->total_grade !== null
                    ? number_format($grade->total_grade, 2)
                    : '—'
                }}
            </p>

            <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                {{ __('Automatically calculated') }}
            </p>

        </div>

    </div>

</div>


{{-- Rejection Information --}}
@if ($grade->status === 'rejected' && $grade->rejection_reason)

    <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900/50 dark:bg-red-900/20">

        <h2 class="text-sm font-semibold text-red-800 dark:text-red-300">
            {{ __('Grade Rejected') }}
        </h2>

        <p class="mt-2 text-sm text-red-700 dark:text-red-400">
            {{ $grade->rejection_reason }}
        </p>

    </div>

@endif


{{-- Workflow Information --}}
@if (! $isStudent)

    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
            {{ __('Workflow Information') }}
        </h2>

        <div class="mt-6 grid gap-6 sm:grid-cols-2">

            {{-- Reviewed By --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Reviewed By') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->reviewer?->name ?? '—' }}
                </p>

                @if ($grade->reviewed_at)
                    <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                        {{ $grade->reviewed_at->format('Y-m-d H:i') }}
                    </p>
                @endif

            </div>


            {{-- Approved By --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Approved By') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->approver?->name ?? '—' }}
                </p>

                @if ($grade->approved_at)
                    <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                        {{ $grade->approved_at->format('Y-m-d H:i') }}
                    </p>
                @endif

            </div>


            {{-- Published At --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Published At') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->published_at?->format('Y-m-d H:i') ?? '—' }}
                </p>

            </div>

        </div>

    </div>

@endif


{{-- Workflow Actions --}}
@if (! $isStudent && ($canSubmit || $canReview || $canApprove || $canPublish))

    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
            {{ __('Workflow Actions') }}
        </h2>

        <div class="mt-4 flex flex-wrap items-center gap-3">

            {{-- Submit --}}
            @if ($canSubmit)

                <form
                    method="POST"
                    action="{{ route('grades.submit', $grade) }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        {{ __('Submit for Review') }}
                    </button>
                </form>

            @endif


            {{-- Review --}}
            @if ($canReview)

                <form
                    method="POST"
                    action="{{ route('grades.review', $grade) }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >
                        {{ __('Mark as Reviewed') }}
                    </button>
                </form>


                <a
                    href="{{ route('grades.reject.form', $grade) }}"
                    class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                >
                    {{ __('Reject Grade') }}
                </a>

            @endif


            {{-- Approve --}}
            @if ($canApprove)

                <form
                    method="POST"
                    action="{{ route('grades.approve', $grade) }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700"
                    >
                        {{ __('Approve Grade') }}
                    </button>
                </form>

            @endif


            {{-- Publish --}}
            @if ($canPublish)

                <form
                    method="POST"
                    action="{{ route('grades.publish', $grade) }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        {{ __('Publish to Student') }}
                    </button>
                </form>

            @endif

        </div>

    </div>

@endif


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
