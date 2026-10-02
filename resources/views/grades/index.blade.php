@extends('layouts.app')

@section('title', 'Grades')

@section('content')
@php
$userRole = auth()->user()->role;
$isStudent = $userRole === 'student';
$canManageGrades = in_array($userRole, ['admin', 'instructor']);
@endphp

<div class="space-y-6">


    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                Grades
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ $isStudent
                ? 'View your published grades.'
                : 'Manage and review student grades.'
            }}
            </p>
        </div>

        @if ($canManageGrades)
        <a
            href="{{ route('grades.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg
                   bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium
                   text-white transition hover:bg-[var(--color-primary-hover)]">

            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4" />
            </svg>

            Add Grade
        </a>
        @endif

    </div>


    {{-- Search & Filters --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] p-4 shadow-sm">

        <form
            method="GET"
            action="{{ route('grades.index') }}"
            class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-5 xl:items-end">

            {{-- Search --}}
            <div class="xl:col-span-2">

                <label
                    for="search"
                    class="mb-2 block text-sm font-medium">
                    Search
                </label>

                <div class="relative">

                    <svg
                        class="pointer-events-none absolute start-3 top-1/2 h-5 w-5
                           -translate-y-1/2
                           text-[var(--color-foreground-muted)]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
                    </svg>

                    <input
                        id="search"
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ $isStudent
                        ? 'Search by course name or code...'
                        : 'Search by student, email, course, or code...' }}"
                        class="w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] py-2.5 ps-10 pe-4
                           text-sm outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20">
                </div>
            </div>


            {{-- Course Filter --}}
            <div>

                <label
                    for="course_id"
                    class="mb-2 block text-sm font-medium">
                    Course
                </label>

                <select
                    id="course_id"
                    name="course_id"
                    class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">
                        All Courses
                    </option>

                    @foreach ($courses as $course)
                    <option
                        value="{{ $course->id }}"
                        @selected((string) request('course_id')===(string) $course->id)>
                        {{ $course->code }} — {{ $course->name }}
                    </option>
                    @endforeach

                </select>
            </div>


            {{-- Semester Filter --}}
            <div>

                <label
                    for="semester_id"
                    class="mb-2 block text-sm font-medium">
                    Semester
                </label>

                <select
                    id="semester_id"
                    name="semester_id"
                    class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">
                        All Semesters
                    </option>

                    @foreach ($semesters as $semester)
                    <option
                        value="{{ $semester->id }}"
                        @selected((string) request('semester_id')===(string) $semester->id)>
                        {{ $semester->name }}
                        @if ($semester->code)
                        — {{ $semester->code }}
                        @endif
                    </option>
                    @endforeach

                </select>
            </div>


            {{-- Publication Status --}}
            @if ($canManageGrades)

            <div>

                <label
                    for="status"
                    class="mb-2 block text-sm font-medium">
                    Publication Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] px-3 py-2.5 text-sm
                           outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="published"
                        @selected(request('status')==='published' )>
                        Published
                    </option>

                    <option
                        value="unpublished"
                        @selected(request('status')==='unpublished' )>
                        Not Published
                    </option>

                </select>
            </div>

            @endif


            {{-- Actions --}}
            <div class="flex gap-2 xl:col-span-5 xl:justify-end">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg
                       bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium
                       text-white transition
                       hover:bg-[var(--color-primary-hover)]">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
                    </svg>

                    Search
                </button>


                @if (
                request()->filled('search') ||
                request()->filled('course_id') ||
                request()->filled('semester_id') ||
                ($canManageGrades && request()->filled('status'))
                )

                <a
                    href="{{ route('grades.index') }}"
                    class="inline-flex items-center justify-center rounded-lg
                           border border-[var(--color-border)]
                           bg-[var(--color-surface)] px-4 py-2.5 text-sm
                           font-medium transition
                           hover:bg-[var(--color-surface-muted)]">
                    Reset
                </a>

                @endif

            </div>

        </form>
    </div>


    {{-- Results Summary --}}
    <div>

        <p class="text-sm text-[var(--color-foreground-muted)]">

            Showing

            <span class="font-medium text-[var(--color-foreground)]">
                {{ $grades->firstItem() ?? 0 }}
            </span>

            to

            <span class="font-medium text-[var(--color-foreground)]">
                {{ $grades->lastItem() ?? 0 }}
            </span>

            of

            <span class="font-medium text-[var(--color-foreground)]">
                {{ $grades->total() }}
            </span>

            grades

        </p>

    </div>


    {{-- Grades Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">

                    <tr>

                        {{-- Student --}}
                        @if (! $isStudent)

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Student
                        </th>

                        @endif


                        {{-- Course --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Course
                        </th>


                        {{-- Semester --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Semester
                        </th>


                        {{-- Midterm --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Midterm
                        </th>


                        {{-- Final --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Final
                        </th>


                        {{-- Total --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Total
                        </th>


                        {{-- Letter --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Letter
                        </th>


                        {{-- Published --}}
                        @if (! $isStudent)

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Published
                        </th>

                        @endif


                        {{-- Actions --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-end text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($grades as $grade)

                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        {{-- Student --}}
                        @if (! $isStudent)

                        <td class="px-6 py-4 text-sm">

                            <div class="font-medium">
                                {{ $grade->enrollment?->student?->name ?? '—' }}
                            </div>

                            @if ($grade->enrollment?->student?->email)

                            <div
                                class="mt-1 text-xs
                                               text-[var(--color-foreground-muted)]">
                                {{ $grade->enrollment->student->email }}
                            </div>

                            @endif

                        </td>

                        @endif


                        {{-- Course --}}
                        <td class="px-6 py-4 text-sm">

                            <div class="font-medium">
                                {{ $grade->enrollment?->section?->course?->name ?? '—' }}
                            </div>

                            @if ($grade->enrollment?->section?->course?->code)

                            <div
                                class="mt-1 text-xs
                                           text-[var(--color-foreground-muted)]">
                                {{ $grade->enrollment->section->course->code }}
                            </div>

                            @endif

                        </td>


                        {{-- Semester --}}
                        <td class="px-6 py-4 text-sm">

                            <div class="font-medium">
                                {{ $grade->enrollment?->section?->semester?->name ?? '—' }}
                            </div>

                            @if ($grade->enrollment?->section?->semester?->code)

                            <div
                                class="mt-1 text-xs
                                           text-[var(--color-foreground-muted)]">
                                {{ $grade->enrollment->section->semester->code }}
                            </div>

                            @endif

                        </td>


                        {{-- Midterm --}}
                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $grade->midterm_grade ?? '—' }}
                        </td>


                        {{-- Final --}}
                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $grade->final_grade ?? '—' }}
                        </td>


                        {{-- Total --}}
                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm font-semibold">
                            {{ $grade->total_grade ?? '—' }}
                        </td>


                        {{-- Letter --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($grade->letter_grade)

                            <span
                                class="inline-flex rounded-full
                                           bg-[var(--color-sidebar-active)]
                                           px-2.5 py-1 text-xs font-semibold
                                           text-[var(--color-primary)]">
                                {{ $grade->letter_grade }}
                            </span>

                            @else

                            <span
                                class="text-sm
                                           text-[var(--color-foreground-muted)]">
                                —
                            </span>

                            @endif

                        </td>


                        {{-- Published --}}
                        @if (! $isStudent)

                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($grade->is_published)

                            <span
                                class="inline-flex rounded-full
                                               bg-[var(--color-success)]/10
                                               px-2.5 py-1 text-xs font-semibold
                                               text-[var(--color-success)]">
                                Published
                            </span>

                            @else

                            <span
                                class="inline-flex rounded-full
                                               bg-[var(--color-warning)]/10
                                               px-2.5 py-1 text-xs font-semibold
                                               text-[var(--color-warning)]">
                                Not Published
                            </span>

                            @endif

                        </td>

                        @endif


                        {{-- Actions --}}
                        <x-table-actions
                            :model="$grade"
                            itemName="Grade #{{ $grade->id }}"
                            showRoute="grades.show"
                            editRoute="grades.edit"
                            destroyRoute="grades.destroy"
                            :showEdit="$canManageGrades"
                            :showDelete="$canManageGrades"
                            deleteConfirm="Are you sure you want to delete this grade?" />

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="{{ $isStudent ? 7 : 9 }}"
                            class="px-6 py-12 text-center">

                            <div
                                class="flex flex-col items-center justify-center">

                                <svg
                                    class="mb-3 h-10 w-10
                                           text-[var(--color-foreground-muted)]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h4m4.5-12.5L19 6.5V19a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5L19 5.5Z" />
                                </svg>

                                <p class="text-sm font-medium">
                                    {{ $isStudent
                                        ? 'No published grades found.'
                                        : 'No grades found.'
                                    }}
                                </p>

                                <p
                                    class="mt-1 text-sm
                                           text-[var(--color-foreground-muted)]">
                                    Try adjusting your search or filters.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($grades->hasPages())

        <div
            class="border-t border-[var(--color-border)]
                   px-4 py-4 sm:px-6">

            <div
                class="flex flex-col gap-4 sm:flex-row
                       sm:items-center sm:justify-between">

                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Page
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $grades->currentPage() }}
                    </span>
                    of
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $grades->lastPage() }}
                    </span>
                </p>


                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($grades->onFirstPage())

                    <span
                        class="inline-flex h-9 min-w-9 items-center
                                   justify-center rounded-lg
                                   border border-[var(--color-border)]
                                   px-3 text-sm
                                   text-[var(--color-foreground-muted)]
                                   opacity-50">
                        Previous
                    </span>

                    @else

                    <a
                        href="{{ $grades->previousPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center
                                   justify-center rounded-lg
                                   border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        Previous
                    </a>

                    @endif


                    {{-- Page Numbers --}}
                    @foreach ($grades->getUrlRange(
                    max(1, $grades->currentPage() - 2),
                    min($grades->lastPage(), $grades->currentPage() + 2)
                    ) as $page => $url)

                    @if ($page == $grades->currentPage())

                    <span
                        class="inline-flex h-9 min-w-9 items-center
                                       justify-center rounded-lg
                                       bg-[var(--color-primary)]
                                       px-3 text-sm font-medium text-white">
                        {{ $page }}
                    </span>

                    @else

                    <a
                        href="{{ $url }}"
                        class="inline-flex h-9 min-w-9 items-center
                                       justify-center rounded-lg
                                       border border-[var(--color-border)]
                                       px-3 text-sm transition
                                       hover:bg-[var(--color-surface-muted)]">
                        {{ $page }}
                    </a>

                    @endif

                    @endforeach


                    {{-- Next --}}
                    @if ($grades->hasMorePages())

                    <a
                        href="{{ $grades->nextPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center
                                   justify-center rounded-lg
                                   border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        Next
                    </a>

                    @else

                    <span
                        class="inline-flex h-9 min-w-9 items-center
                                   justify-center rounded-lg
                                   border border-[var(--color-border)]
                                   px-3 text-sm
                                   text-[var(--color-foreground-muted)]
                                   opacity-50">
                        Next
                    </span>

                    @endif

                </div>

            </div>

        </div>

        @endif

    </div>


</div>
@endsection