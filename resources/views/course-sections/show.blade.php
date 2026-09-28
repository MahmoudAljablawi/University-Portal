
@extends('layouts.app')

@section('title', 'Course Section')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold">
                    Course Section
                </h1>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    View course section details and enrolled students.
                </p>
            </div>

            <div class="flex gap-2">

                <a
                    href="{{ route('course-sections.index') }}"
                    class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                >
                    Back
                </a>

                @if (auth()->user()->role === 'admin')
                    <a
                        href="{{ route('course-sections.edit', $crsSec) }}"
                        class="rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Edit
                    </a>
                @endif

            </div>
        </div>

        {{-- Section Information --}}
        <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

            <h2 class="mb-5 text-lg font-semibold">
                Section Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Course
                    </p>

                    <p class="mt-1 text-sm font-medium">
                        {{ $crsSec->course?->name ?? '—' }}
                    </p>

                    @if ($crsSec->course?->code)
                        <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                            {{ $crsSec->course->code }}
                        </p>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Section Number
                    </p>

                    <p class="mt-1 text-sm font-medium">
                        {{ $crsSec->section_number }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Academic Semester
                    </p>

                    <p class="mt-1 text-sm font-medium">
                        {{ $crsSec->semester?->name ?? '—' }}
                    </p>

                    @if ($crsSec->semester?->code)
                        <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                            {{ $crsSec->semester->code }}
                        </p>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Instructor
                    </p>

                    <p class="mt-1 text-sm font-medium">
                        {{ $crsSec->instructor?->name ?? '—' }}
                    </p>

                    @if ($crsSec->instructor?->email)
                        <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                            {{ $crsSec->instructor->email }}
                        </p>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Capacity
                    </p>

                    <p class="mt-1 text-sm font-medium">
                        {{ $crsSec->capacity }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        Enrolled Students
                    </p>

                    <p class="mt-1 text-sm font-medium">
                        {{ $crsSec->enrollments->count() }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Enrolled Students --}}
        <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">

            <div class="border-b border-[var(--color-border)] px-6 py-5">
                <h2 class="text-lg font-semibold">
                    Enrolled Students
                </h2>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    Students currently enrolled in this section.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-border)]">

                    <thead class="bg-[var(--color-surface-muted)]">
                        <tr>
                            <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                                #
                            </th>

                            <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                                Student
                            </th>

                            <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                                Email
                            </th>

                            <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[var(--color-border)]">

                        @forelse ($crsSec->enrollments as $enrollment)
                            <tr class="transition hover:bg-[var(--color-surface-muted)]">

                                <td class="px-6 py-4 text-sm">
                                    {{ $enrollment->id }}
                                </td>

                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $enrollment->student?->name ?? '—' }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $enrollment->student?->email ?? '—' }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $enrollment->status ?? '—' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="4"
                                    class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]"
                                >
                                    No students are enrolled in this section.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>
@endsection


