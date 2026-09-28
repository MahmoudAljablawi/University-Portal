
@extends('layouts.app')

@section('title', 'Create Enrollment')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        <div>
            <h1 class="text-2xl font-semibold">
                Create Enrollment
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Register a student in a course section.
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-lg border border-[var(--color-danger)]/30 bg-[var(--color-surface-muted)] p-4">
                <ul class="list-disc space-y-1 ps-5 text-sm text-[var(--color-danger)]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

            <form
                action="{{ route('enrollments.store') }}"
                method="POST"
                class="space-y-6"
            >
                @csrf

                {{-- Student - Admin only --}}
                @if (auth()->user()->role === 'admin')
                    <div>
                        <label
                            for="student_id"
                            class="mb-2 block text-sm font-medium"
                        >
                            Student
                        </label>

                        <select
                            id="student_id"
                            name="student_id"
                            required
                            class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                        >
                            <option value="">Select Student</option>

                            @foreach ($students as $student)
                                <option
                                    value="{{ $student->id }}"
                                    @selected(old('student_id') == $student->id)
                                >
                                    {{ $student->name }} — {{ $student->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('student_id')
                            <p class="mt-1 text-sm text-[var(--color-danger)]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @else
                    <div class="rounded-lg bg-[var(--color-surface-muted)] p-4">
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            You are creating an enrollment for your own account.
                        </p>
                    </div>
                @endif

                {{-- Section --}}
                <div>
                    <label
                        for="section_id"
                        class="mb-2 block text-sm font-medium"
                    >
                        Course Section
                    </label>

                    <select
                        id="section_id"
                        name="section_id"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >
                        <option value="">Select Course Section</option>

                        @foreach ($sections as $section)
                            <option
                                value="{{ $section->id }}"
                                @selected(old('section_id') == $section->id)
                            >
                                {{ $section->course?->code }}
                                —
                                {{ $section->course?->name }}
                                | Section {{ $section->section_number }}
                                | {{ $section->semester?->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('section_id')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                    <a
                        href="{{ route('enrollments.index') }}"
                        class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Enroll
                    </button>

                </div>

            </form>

        </div>
    </div>
@endsection


