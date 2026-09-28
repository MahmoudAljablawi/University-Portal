
@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    Edit Course
                </h1>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    Update the academic information for {{ $course->name }}.
                </p>
            </div>

            <a
                href="{{ route('courses.show', $course) }}"
                class="text-sm font-medium text-[var(--color-primary)] hover:underline"
            >
                View Course
            </a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-lg border border-[var(--color-danger)]/30 bg-[var(--color-surface-muted)] p-4">
                <ul class="list-disc space-y-1 ps-5 text-sm text-[var(--color-danger)]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

            <form
                action="{{ route('courses.update', $course) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium"
                    >
                        Course Name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $course->name) }}"
                        required
                        maxlength="255"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Code --}}
                <div>
                    <label
                        for="code"
                        class="mb-2 block text-sm font-medium"
                    >
                        Course Code
                    </label>

                    <input
                        id="code"
                        name="code"
                        type="text"
                        value="{{ old('code', $course->code) }}"
                        required
                        maxlength="50"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm uppercase outline-none transition focus:border-[var(--color-primary)]"
                    >

                    @error('code')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Semester level --}}
                <div>
                    <label
                        for="semester_level"
                        class="mb-2 block text-sm font-medium"
                    >
                        Semester Level
                    </label>

                    <input
                        id="semester_level"
                        name="semester_level"
                        type="text"
                        value="{{ old('semester_level', $course->semester_level) }}"
                        required
                        maxlength="50"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm uppercase outline-none transition focus:border-[var(--color-primary)]"
                    >

                    @error('semester_level')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Department --}}
                <div>
                    <label
                        for="department_id"
                        class="mb-2 block text-sm font-medium"
                    >
                        Department
                    </label>

                    <select
                        id="department_id"
                        name="department_id"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >
                        <option value="">Select Department</option>

                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                @selected(old('department_id', $course->department_id) == $department->id)
                            >
                                {{ $department->name }} ({{ $department->code }})
                            </option>
                        @endforeach
                    </select>

                    @error('department_id')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Credits --}}
                <div>
                    <label
                        for="credits"
                        class="mb-2 block text-sm font-medium"
                    >
                        Credits
                    </label>

                    <input
                        id="credits"
                        name="credits"
                        type="number"
                        value="{{ old('credits', $course->credits) }}"
                        required
                        min="1"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >

                    @error('credits')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label
                        for="description"
                        class="mb-2 block text-sm font-medium"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    >{{ old('description', $course->description) }}</textarea>

                    @error('description')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                    <a
                        href="{{ route('courses.show', $course) }}"
                        class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Update Course
                    </button>

                </div>
            </form>

        </div>
    </div>
@endsection
