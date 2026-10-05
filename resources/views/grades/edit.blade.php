@extends('layouts.app')

@section('title', __('Edit Grade'))

@section('content')

<div class="mx-auto max-w-4xl space-y-6">


{{-- Header --}}
<div>
    <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
        {{ __('Edit Grade') }}
    </h1>

    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
        {{ __('Update the recorded grade.') }}
    </p>
</div>

{{-- Enrollment Information --}}
<div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
        {{ __('Student Enrollment') }}
    </h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Student') }}
            </p>

            <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                {{ $grade->enrollment?->student?->name ?? '—' }}
            </p>
        </div>

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

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                {{ __('Section') }}
            </p>

            <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                {{ $grade->enrollment?->section?->section_number ?? '—' }}
            </p>
        </div>

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

    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                {{ __('Grade Information') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Update the practical and theoretical grades.') }}
            </p>
        </div>

        {{-- Current Status --}}
        <span
            class="rounded-full px-3 py-1 text-xs font-semibold
            @switch($grade->status)
                @case('draft')
                    bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300
                    @break
                @case('submitted')
                    bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                    @break
                @case('reviewed')
                    bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300
                    @break
                @case('approved')
                    bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                    @break
                @case('rejected')
                    bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300
                    @break
                @case('published')
                    bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300
                    @break
                @default
                    bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300
            @endswitch
            "
        >
            {{ __(ucfirst($grade->status)) }}
        </span>
    </div>

    {{-- Rejection Reason --}}
    @if ($grade->status === 'rejected' && $grade->rejection_reason)
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-900/20">
            <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                {{ __('Rejection Reason') }}
            </p>

            <p class="mt-1 text-sm text-red-700 dark:text-red-400">
                {{ $grade->rejection_reason }}
            </p>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('grades.update', $grade) }}"
        class="mt-6 space-y-6"
    >
        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">

            {{-- Practical --}}
            <div>
                <label
                    for="practical_grade"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('Practical Grade') }}
                    <span class="text-xs text-[var(--color-foreground-muted)]">
                        (30%)
                    </span>
                </label>

                <input
                    id="practical_grade"
                    name="practical_grade"
                    type="number"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('practical_grade', $grade->practical_grade) }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('practical_grade')
                    <p class="mt-1 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Theoretical --}}
            <div>
                <label
                    for="theoretical_grade"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('Theoretical Grade') }}
                    <span class="text-xs text-[var(--color-foreground-muted)]">
                        (70%)
                    </span>
                </label>

                <input
                    id="theoretical_grade"
                    name="theoretical_grade"
                    type="number"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('theoretical_grade', $grade->theoretical_grade) }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('theoretical_grade')
                    <p class="mt-1 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        {{-- Total Grade --}}
        <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4">

            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-[var(--color-foreground)]">
                        {{ __('Current Total Grade') }}
                    </p>

                    <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                        {{ __('Calculated automatically from practical and theoretical grades.') }}
                    </p>
                </div>

                <span class="text-xl font-bold text-[var(--color-foreground)]">
                    {{ $grade->total_grade !== null ? number_format($grade->total_grade, 2) : '—' }}
                </span>
            </div>

        </div>

        {{-- Workflow Information --}}
        <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4">
            <p class="text-sm font-medium text-[var(--color-foreground)]">
                {{ __('Grade Workflow') }}
            </p>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Grades can be edited while they are in') }}
                <span class="font-medium text-[var(--color-foreground)]">
                    {{ __('Draft') }}
                </span>
                or
                <span class="font-medium text-[var(--color-foreground)]">
                    {{ __('Rejected') }}
                </span>
                status.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

            <a
                href="{{ route('grades.show', $grade) }}"
                class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
            >
                {{ __('Cancel') }}
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
            >
                {{ __('Update Grade') }}
            </button>

        </div>

    </form>

</div>


</div>
@endsection
