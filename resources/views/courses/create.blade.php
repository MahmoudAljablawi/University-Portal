@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-semibold">
            Create Course
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Add a new course to the university academic system.
        </p>
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
            action="{{ route('courses.store') }}"
            method="POST"
            class="space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium">
                    Course Name
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    maxlength="255"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    placeholder="Enter course name">

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
                    class="mb-2 block text-sm font-medium">
                    Course Code
                </label>

                <input
                    id="code"
                    name="code"
                    type="text"
                    value="{{ old('code') }}"
                    required
                    maxlength="50"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm uppercase outline-none transition focus:border-[var(--color-primary)]"
                    placeholder="e.g. CS101">

                @error('code')
                <p class="mt-1 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

        
            {{-- Semester Level --}}
            <div>
                <label
                    for="semester_level"
                    class="mb-2 block text-sm font-medium">
                    Semester Level
                </label>

                <input
                    id="semester_level"
                    name="semester_level"
                    type="number"
                    value="{{ old('semester_level') }}"
                    required
                    min="1"
                    max="20"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    placeholder="e.g. 1">

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
                    class="mb-2 block text-sm font-medium">
                    Department
                </label>

                <select
                    id="department_id"
                    name="department_id"
                    required
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]">
                    <option value="">Select Department</option>

                    @foreach ($departments as $department)
                    <option
                        value="{{ $department->id }}"
                        @selected(old('department_id')==$department->id)
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
                    class="mb-2 block text-sm font-medium">
                    Credits
                </label>

                <input
                    id="credits"
                    name="credits"
                    type="number"
                    value="{{ old('credits') }}"
                    required
                    min="1"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    placeholder="e.g. 3">

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
                    class="mb-2 block text-sm font-medium">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)]"
                    placeholder="Enter course description">{{ old('description') }}</textarea>

                @error('description')
                <p class="mt-1 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                <a
                    href="{{ route('courses.index') }}"
                    class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
                    Create Course
                </button>

            </div>
        </form>

    </div>
</div>
@endsection