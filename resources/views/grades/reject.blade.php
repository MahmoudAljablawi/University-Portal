
@extends('layouts.app')

@section('title', __('Reject Grade'))

@section('content')
    <div class="mx-auto max-w-3xl">

        {{-- Page Header --}}
        <x-page-header
            title="{{ __('Reject Grade') }}"
            description="Return this grade to the instructor for correction."
        />

        <div class="mt-6 space-y-6">

            {{-- Grade Information --}}
            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

                <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                    {{ __('Grade Information') }}
                </h2>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Student --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Student') }}
                        </p>

                        <p class="mt-1 font-medium text-[var(--color-foreground)]">
                            {{ $grade->enrollment?->student?->name ?? '—' }}
                        </p>
                    </div>

                    {{-- Course --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Course') }}
                        </p>

                        <p class="mt-1 font-medium text-[var(--color-foreground)]">
                            {{ $grade->enrollment?->section?->course?->name ?? '—' }}
                        </p>
                    </div>

                    {{-- Course Code --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Course Code') }}
                        </p>

                        <p class="mt-1 font-medium text-[var(--color-foreground)]">
                            {{ $grade->enrollment?->section?->course?->code ?? '—' }}
                        </p>
                    </div>

                    {{-- Semester --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Semester') }}
                        </p>

                        <p class="mt-1 font-medium text-[var(--color-foreground)]">
                            {{ $grade->enrollment?->section?->semester?->name ?? '—' }}
                        </p>
                    </div>

                    {{-- Practical --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Practical Grade') }}
                        </p>

                        <p class="mt-1 font-medium text-[var(--color-foreground)]">
                            {{ $grade->practical_grade ?? '—' }}
                        </p>
                    </div>

                    {{-- Theoretical --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Theoretical Grade') }}
                        </p>

                        <p class="mt-1 font-medium text-[var(--color-foreground)]">
                            {{ $grade->theoretical_grade ?? '—' }}
                        </p>
                    </div>

                    {{-- Total --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Total Grade') }}
                        </p>

                        <p class="mt-1 font-semibold text-[var(--color-foreground)]">
                            {{ $grade->total_grade ?? '—' }}
                        </p>
                    </div>

                    {{-- Current Status --}}
                    <div>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Current Status') }}
                        </p>

                        <div class="mt-1">
                            <x-badge type="warning">
                                {{ __(ucfirst($grade->status)) }}
                            </x-badge>
                        </div>
                    </div>

                </div>
            </div>


            {{-- Rejection Form --}}
            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        {{ __('Rejection Reason') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Provide a clear reason explaining why this grade is being returned to the instructor.') }}
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('grades.reject', $grade) }}"
                    class="space-y-6"
                >
                    @csrf

                    {{-- Rejection Reason --}}
                    <div>
                        <label
                            for="rejection_reason"
                            class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                        >
                            {{ __('Rejection Reason') }}
                        </label>

                        <textarea
                            id="rejection_reason"
                            name="rejection_reason"
                            rows="6"
                            required
                            minlength="5"
                            maxlength="2000"
                            placeholder="{{ __('Explain what needs to be corrected...') }}"
                            class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                        >{{ old('rejection_reason') }}</textarea>

                        @error('rejection_reason')
                            <p class="mt-2 text-sm text-[var(--color-danger)]">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-2 text-xs text-[var(--color-foreground-muted)]">
                            {{ __('The reason must contain between 5 and 2000 characters.') }}
                        </p>
                    </div>


                    {{-- Warning --}}
                    <div class="rounded-lg border border-[var(--color-warning)]/30 bg-[var(--color-warning)]/10 p-4">
                        <div class="flex gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-[var(--color-warning)]"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.981-1.743 2.981H4.42c-1.53 0-2.493-1.647-1.743-2.98l5.58-9.921ZM10 7a.75.75 0 0 1 .75.75v2.5a.75.75 0 0 1-1.5 0v-2.5A.75.75 0 0 1 10 7Zm0 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                    clip-rule="evenodd"
                                />
                            </svg>

                            <div>
                                <p class="text-sm font-medium text-[var(--color-foreground)]">
                                    {{ __('This action will return the grade to the instructor.') }}
                                </p>

                                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                    {{ __('The instructor will need to correct the grade and submit it again for review.') }}
                                </p>
                            </div>

                        </div>
                    </div>


                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('grades.show', $grade) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-5 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                        >
                            {{ __('Cancel') }}
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-[var(--color-danger)] px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[var(--color-danger)]/30"
                        >
                            {{ __('Reject Grade') }}
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection
