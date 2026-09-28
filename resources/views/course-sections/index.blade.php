@extends('layouts.app')

@section('title', 'Course Sections')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold">
                Course Sections
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Manage course sections, instructors, semesters, and capacities.
            </p>
        </div>

        @if (auth()->user()->role === 'admin')
        <a
            href="{{ route('course-sections.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
            + Add Course Section
        </a>
        @endif
    </div>

    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">
                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            #
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Course
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Section
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Semester
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Instructor
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Capacity
                        </th>

                        <th class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse ($sections as $section)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $section->id }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium">
                                {{ $section->course?->name ?? '—' }}
                            </div>

                            @if ($section->course?->code)
                            <div class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                                {{ $section->course->code }}
                            </div>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $section->section_number }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium">
                                {{ $section->semester?->name ?? '—' }}
                            </div>

                            @if ($section->semester?->code)
                            <div class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                                {{ $section->semester->code }}
                            </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $section->instructor?->name ?? '—' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $section->capacity }}
                        </td>

                        <x-table-actions
                            :model="$section"
                            :itemName="$section->course ? ($section->course->code . ' - Section ' . $section->section_number) : ('Section #' . $section->id)"
                            showRoute="course-sections.show"
                            editRoute="course-sections.edit"
                            destroyRoute="course-sections.destroy"
                            :showEdit="auth()->user()->role === 'admin'"
                            :showDelete="auth()->user()->role === 'admin'"
                            deleteConfirm="Are you sure you want to delete this course section?" />
                    </tr>
                    @empty
                    <tr>
                        <td
                            colspan="7"
                            class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]">
                            No course sections found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection