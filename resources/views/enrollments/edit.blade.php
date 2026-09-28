@extends('layouts.app')

@section('title', 'Edit Enrollment')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        <div>
            <h1 class="text-2xl font-semibold">
                Edit Enrollment
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Update the enrollment information and status.
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
                action="{{ route('enrollments.update', $enrollment) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Student (Read-only) --}}
                <div>
                    <label
                        for="student_id"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Student
                    </label>

                    {{-- عرض معلومات الطالب بدون إمكانية التعديل --}}
                    <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] px-4 py-3">
                        <p class="font-medium text-[var(--color-foreground)]">
                            {{ $enrollment->student->name }}
                        </p>
                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ $enrollment->student->email }}
                        </p>
                    </div>

                    {{-- Hidden input لضمان عدم تغيير القيمة --}}
                    <input type="hidden" name="student_id" value="{{ $enrollment->student_id }}">

                    <p class="mt-2 text-xs text-[var(--color-foreground-muted)]">
                        ℹ️ Student cannot be changed once enrolled. Contact admin to change.
                    </p>
                </div>

                {{-- Section --}}
                <div>
                    <label
                        for="section_id"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Course Section
                    </label>

                    <select
                        id="section_id"
                        name="section_id"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >
                        <option value="">Select Course Section</option>

                        @foreach ($sections as $section)
                            <option
                                value="{{ $section->id }}"
                                @selected(old('section_id', $enrollment->section_id) == $section->id)
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

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >
                        <option
                            value="enrolled"
                            @selected(old('status', $enrollment->status) === 'enrolled')
                        >
                            Enrolled
                        </option>

                        <option
                            value="completed"
                            @selected(old('status', $enrollment->status) === 'completed')
                        >
                            Completed
                        </option>

                        <option
                            value="dropped"
                            @selected(old('status', $enrollment->status) === 'dropped')
                        >
                            Dropped
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                    <a
                        href="{{ route('enrollments.show', $enrollment) }}"
                        class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Update Enrollment
                    </button>

                </div>

            </form>

        </div>
    </div>
@endsection