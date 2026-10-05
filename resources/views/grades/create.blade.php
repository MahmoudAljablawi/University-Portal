@extends('layouts.app')

@section('title', __('Add Grade'))

@section('content')

<div class="mx-auto max-w-4xl space-y-6">


{{-- Header --}}
<div>
    <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
        {{ __('Add Grade') }}
    </h1>

    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
        {{ __('Record grades for a student enrollment.') }}
    </p>
</div>

{{-- Form --}}
<div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">
    <form
        method="POST"
        action="{{ route('grades.store') }}"
        class="space-y-6"
    >
        @csrf

        {{-- Enrollment --}}
        <div>
            <label
                for="enrollment_id"
                class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
            >
                {{ __('Student Enrollment') }}
            </label>

            <select
                id="enrollment_id"
                name="enrollment_id"
                required
                class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
            >
                <option value="">{{ __('Select enrollment') }}</option>

                @foreach ($enrollments as $enrollment)
                    <option
                        value="{{ $enrollment->id }}"
                        @selected(old('enrollment_id') == $enrollment->id)
                    >
                        {{ $enrollment->student?->name ?? 'Unknown Student' }}
                        —
                        {{ $enrollment->section?->course?->code ?? 'N/A' }}
                        {{ $enrollment->section?->course?->name ?? 'Unknown Course' }}
                        —
                        Section {{ $enrollment->section?->section_number ?? 'N/A' }}
                        —
                        {{ $enrollment->section?->semester?->name ?? 'N/A' }}
                    </option>
                @endforeach
            </select>

            @error('enrollment_id')
                <p class="mt-1 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Grades --}}
        <div class="grid gap-6 sm:grid-cols-2">

            {{-- Practical Grade --}}
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
                    value="{{ old('practical_grade') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('practical_grade')
                    <p class="mt-1 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Theoretical Grade --}}
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
                    value="{{ old('theoretical_grade') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('theoretical_grade')
                    <p class="mt-1 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        {{-- Grade Information --}}
        <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4">
            <div class="flex items-start gap-3">

                <div class="mt-0.5 text-[var(--color-primary)]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10A8 8 0 11.001 10a8 8 0 0117.999 0ZM9 8.5a1 1 0 112 0v5a1 1 0 11-2 0v-5ZM10 5a1 1 0 100 2 1 1 0 000-2Z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-medium text-[var(--color-foreground)]">
                        {{ __('Grade Calculation') }}
                    </p>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        The total grade is calculated automatically using
                        30% practical and 70% theoretical assessment.
                    </p>
                </div>

            </div>
        </div>

        {{-- Workflow Information --}}
        <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4">
            <p class="text-sm font-medium text-[var(--color-foreground)]">
                {{ __('Grade Workflow') }}
            </p>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('After saving, the grade will remain in') }}
                <span class="font-medium text-[var(--color-foreground)]">
                    {{ __('Draft') }}
                </span>
                {{ __('status. The instructor can submit it for review after completing the grade.') }}
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

            <a
                href="{{ route('grades.index') }}"
                class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
            >
                {{ __('Cancel') }}
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
            >
                {{ __('Save Grade') }}
            </button>

        </div>
    </form>
</div>


</div>
@endsection
