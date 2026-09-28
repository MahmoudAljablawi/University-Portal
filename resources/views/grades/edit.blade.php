
@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            Edit Grade
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Update the recorded grade.
        </p>
    </div>

    {{-- Enrollment Information --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
            Student Enrollment
        </h2>

        <div class="mt-6 grid gap-6 sm:grid-cols-2">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Student
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->enrollment?->student?->name ?? '—' }}
                </p>
            </div>

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

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Section
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $grade->enrollment?->section?->section_number ?? '—' }}
                </p>
            </div>

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

    {{-- Form --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <form
            method="POST"
            action="{{ route('grades.update', $grade) }}"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">

                {{-- Midterm --}}
                <div>
                    <label
                        for="midterm_grade"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Midterm Grade
                    </label>

                    <input
                        id="midterm_grade"
                        name="midterm_grade"
                        type="number"
                        min="0"
                        max="100"
                        step="0.01"
                        value="{{ old('midterm_grade', $grade->midterm_grade) }}"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('midterm_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Final --}}
                <div>
                    <label
                        for="final_grade"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Final Grade
                    </label>

                    <input
                        id="final_grade"
                        name="final_grade"
                        type="number"
                        min="0"
                        max="100"
                        step="0.01"
                        value="{{ old('final_grade', $grade->final_grade) }}"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('final_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Total --}}
                <div>
                    <label
                        for="total_grade"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Total Grade
                    </label>

                    <input
                        id="total_grade"
                        name="total_grade"
                        type="number"
                        min="0"
                        max="100"
                        step="0.01"
                        value="{{ old('total_grade', $grade->total_grade) }}"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('total_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Letter --}}
                <div>
                    <label
                        for="letter_grade"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Letter Grade
                    </label>

                    <input
                        id="letter_grade"
                        name="letter_grade"
                        type="text"
                        maxlength="5"
                        value="{{ old('letter_grade', $grade->letter_grade) }}"
                        placeholder="e.g. A"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('letter_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Published --}}
            <label class="flex cursor-pointer items-center gap-3">
                <input type="hidden" name="is_published" value="0">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    @checked(old('is_published', $grade->is_published))
                    class="h-4 w-4 rounded border-[var(--color-border)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                >

                <span class="text-sm font-medium text-[var(--color-foreground)]">
                    Publish grade to student
                </span>
            </label>

            @error('is_published')
                <p class="text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
            @enderror

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                <a
                    href="{{ route('grades.show', $grade) }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    Update Grade
                </button>

            </div>

        </form>

    </div>

</div>
@endsection

