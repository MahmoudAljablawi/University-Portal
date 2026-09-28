
@extends('layouts.app')

@section('title', 'Edit Course Section')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        <div>
            <h1 class="text-2xl font-semibold">
                Edit Course Section
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Update the course section information.
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
                action="{{ route('course-sections.update', $courseSection) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Course --}}
                <div>
                    <label
                        for="course_id"
                        class="mb-2 block text-sm font-medium"
                    >
                        Course
                    </label>

                    <select
                        id="course_id"
                        name="course_id"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >
                        <option value="">Select Course</option>

                        @foreach ($courses as $course)
                            <option
                                value="{{ $course->id }}"
                                @selected(old('course_id', $courseSection->course_id) == $course->id)
                            >
                                {{ $course->code }} — {{ $course->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('course_id')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Semester --}}
                <div>
                    <label
                        for="semester_id"
                        class="mb-2 block text-sm font-medium"
                    >
                        Academic Semester
                    </label>

                    <select
                        id="semester_id"
                        name="semester_id"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >
                        <option value="">Select Academic Semester</option>

                        @foreach ($semesters as $semester)
                            <option
                                value="{{ $semester->id }}"
                                @selected(old('semester_id', $courseSection->semester_id) == $semester->id)
                            >
                                {{ $semester->name }} ({{ $semester->code }})
                            </option>
                        @endforeach
                    </select>

                    @error('semester_id')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Instructor --}}
                <div>
                    <label
                        for="instructor_id"
                        class="mb-2 block text-sm font-medium"
                    >
                        Instructor
                    </label>

                    <select
                        id="instructor_id"
                        name="instructor_id"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >
                        <option value="">Select Instructor</option>

                        @foreach ($instructors as $instructor)
                            <option
                                value="{{ $instructor->id }}"
                                @selected(old('instructor_id', $courseSection->instructor_id) == $instructor->id)
                            >
                                {{ $instructor->name }} — {{ $instructor->email }}
                            </option>
                        @endforeach
                    </select>

                    @error('instructor_id')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Section Number --}}
                <div>
                    <label
                        for="section_number"
                        class="mb-2 block text-sm font-medium"
                    >
                        Section Number
                    </label>

                    <input
                        id="section_number"
                        name="section_number"
                        type="number"
                        value="{{ old('section_number', $courseSection->section_number) }}"
                        required
                        min="1"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >

                    @error('section_number')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Capacity --}}
                <div>
                    <label
                        for="capacity"
                        class="mb-2 block text-sm font-medium"
                    >
                        Capacity
                    </label>

                    <input
                        id="capacity"
                        name="capacity"
                        type="number"
                        value="{{ old('capacity', $courseSection->capacity) }}"
                        required
                        min="1"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >

                    @error('capacity')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                    <a
                        href="{{ route('course-sections.show', $courseSection) }}"
                        class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Update Section
                    </button>

                </div>
            </form>

        </div>
    </div>
@endsection
