
@extends('layouts.app')

@section('title', 'Add Grade')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            Add Grade
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Record grades for a student enrollment.
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
                    Student Enrollment
                </label>

                <select
                    id="enrollment_id"
                    name="enrollment_id"
                    required
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >
                    <option value="">Select enrollment</option>

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
                        value="{{ old('midterm_grade') }}"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('midterm_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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
                        value="{{ old('final_grade') }}"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('final_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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
                        value="{{ old('total_grade') }}"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('total_grade')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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
                        value="{{ old('letter_grade') }}"
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
                    @checked(old('is_published'))
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
                    href="{{ route('grades.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    Save Grade
                </button>

            </div>
        </form>
    </div>

</div>
@endsection

