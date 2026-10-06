@extends('layouts.app')

@section('title', __('Course Sections'))

@section('content')
@php
$user = auth()->user();


$isAdmin = $user?->role === 'admin';
$isInstructor = $user?->role === 'instructor';
$isEmployee = $user?->role === 'employee';


@endphp

<div class="space-y-6">


    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ $isInstructor ? __('My Course Sections') : __('Course Sections') }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                @if ($isInstructor)
                {{ __('View the course sections assigned to you.') }}
                @elseif ($isEmployee)
                {{ __('View course sections within your college.') }}
                @else
                {{ __('Manage course sections, instructors, semesters, and capacities.') }}
                @endif
            </p>
        </div>

        @if ($isAdmin)
        <a
            href="{{ route('course-sections.create') }}"
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

            {{ __('Add Course Section') }}
        </a>
        @endif
    </div>

    {{-- Search & Filters --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] p-4 shadow-sm">

        <form
            method="GET"
            action="{{ route('course-sections.index') }}"
            class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-5 xl:items-end">

            {{-- Search --}}
            <div class="{{ $isAdmin ? 'xl:col-span-2' : 'xl:col-span-3' }}">

                <label
                    for="search"
                    class="mb-2 block text-sm font-medium">
                    {{ __('Search') }}
                </label>

                <div class="relative">

                    <svg
                        class="pointer-events-none absolute start-3 top-1/2 h-5 w-5
                           -translate-y-1/2 text-[var(--color-foreground-muted)]"
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
                        placeholder="{{ __('Search by section number...') }}"
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
                    {{ __('Course') }}
                </label>

                <select
                    id="course_id"
                    name="course_id"
                    class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">{{ __('All Courses') }}</option>

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
                    {{ __('Semester') }}
                </label>

                <select
                    id="semester_id"
                    name="semester_id"
                    class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">{{ __('All Semesters') }}</option>

                    @foreach ($semesters as $semester)
                    <option
                        value="{{ $semester->id }}"
                        @selected((string) request('semester_id')===(string) $semester->id)>
                        {{ $semester->name }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- Instructor Filter: Admin Only For Now --}}
            @if ($isAdmin)
            <div>
                <label
                    for="instructor_id"
                    class="mb-2 block text-sm font-medium">
                    {{ __('Instructor') }}
                </label>

                <select
                    id="instructor_id"
                    name="instructor_id"
                    class="w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] px-3 py-2.5 text-sm
                           outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">{{ __('All Instructors') }}</option>

                    @foreach ($instructors as $instructor)
                    <option
                        value="{{ $instructor->id }}"
                        @selected((string) request('instructor_id')===(string) $instructor->id)>
                        {{ $instructor->name }}
                    </option>
                    @endforeach

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

                    {{ __('Search') }}
                </button>

                @if (
                request()->filled('search') ||
                request()->filled('course_id') ||
                request()->filled('semester_id') ||
                request()->filled('instructor_id')
                )
                <a
                    href="{{ route('course-sections.index') }}"
                    class="inline-flex items-center justify-center rounded-lg
                           border border-[var(--color-border)]
                           bg-[var(--color-surface)] px-4 py-2.5 text-sm
                           font-medium transition
                           hover:bg-[var(--color-surface-muted)]">
                    {{ __('Reset') }}
                </a>
                @endif

            </div>

        </form>
    </div>

    {{-- Results Summary --}}
    <div>
        <p class="text-sm text-[var(--color-foreground-muted)]">
            {{ __('Showing') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $sections->firstItem() ?? 0 }}
            </span>
            {{ __('to') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $sections->lastItem() ?? 0 }}
            </span>
            {{ __('of') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $sections->total() }}
            </span>
            {{ __('course sections') }}
        </p>
    </div>

    {{-- Course Sections Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">

                    <tr>

                        <th class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            #
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Course') }}
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Section') }}
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Semester') }}
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Instructor') }}
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Capacity') }}
                        </th>

                        <th class="px-6 py-4 text-end text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Actions') }}
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($sections as $section)

                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        {{-- ID --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $section->id }}
                        </td>

                        {{-- Course --}}
                        <td class="px-6 py-4 text-sm">

                            <div class="font-medium">
                                {{ $section->course?->name ?? '—' }}
                            </div>

                            @if ($section->course?->code)
                            <div class="mt-1 text-xs
                                            text-[var(--color-foreground-muted)]">
                                {{ $section->course->code }}
                            </div>
                            @endif

                            {{-- Department --}}
                            @if ($section->course?->department)
                            <div class="mt-2 text-xs
                                            text-[var(--color-foreground-muted)]">
                                {{ __('Department:') }}
                                <span class="font-medium">
                                    {{ $section->course->department->name }}
                                </span>
                            </div>
                            @endif

                            {{-- College --}}
                            @if ($section->course?->department?->college)
                            <div class="mt-1 text-xs
                                            text-[var(--color-foreground-muted)]">
                                {{ __('College:') }}
                                <span class="font-medium">
                                    {{ $section->course->department->college->name }}
                                </span>
                            </div>
                            @endif

                        </td>

                        {{-- Section --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $section->section_number }}
                        </td>

                        {{-- Semester --}}
                        <td class="px-6 py-4 text-sm">

                            <div class="font-medium">
                                {{ $section->semester?->name ?? '—' }}
                            </div>

                            @if ($section->semester?->code)
                            <div class="mt-1 text-xs
                                            text-[var(--color-foreground-muted)]">
                                {{ $section->semester->code }}
                            </div>
                            @endif

                        </td>

                        {{-- Instructor --}}
                        <td class="px-6 py-4 text-sm">
                            {{ $section->instructor?->name ?? '—' }}
                        </td>

                        {{-- Capacity --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $section->capacity }}
                        </td>

                        {{-- Actions --}}
                        <x-table-actions
                            :model="$section"
                            :itemName="$section->course
                                ? ($section->course->code . ' - ' . __('Section') . ' ' . $section->section_number)
                                : (__('Section') . ' #' . $section->id)"
                            showRoute="course-sections.show"
                            editRoute="course-sections.edit"
                            destroyRoute="course-sections.destroy"
                            :showEdit="$isAdmin"
                            :showDelete="$isAdmin"
                            :deleteConfirm="__('Are you sure you want to delete this course section?')" />

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="px-6 py-12 text-center">

                            <div class="flex flex-col items-center justify-center">

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
                                        d="M9 12h6m-6 4h4m4.5-12.5L19 6.5V19a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5L19.5 5.5Z" />
                                </svg>

                                <p class="text-sm font-medium">
                                    {{ __('No course sections found.') }}
                                </p>

                                @if ($isAdmin)

                                <p class="mt-1 text-sm
                                              text-[var(--color-foreground-muted)]">
                                    {{ __('Create your first course section to get started.') }}
                                </p>

                                @elseif ($isInstructor)

                                <p class="mt-1 text-sm
                                              text-[var(--color-foreground-muted)]">
                                    {{ __('No course sections are currently assigned to you.') }}
                                </p>

                                @elseif ($isEmployee)

                                <p class="mt-1 text-sm
                                              text-[var(--color-foreground-muted)]">
                                    {{ __('No course sections were found within your college.') }}
                                </p>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if ($sections->hasPages())

        <div class="border-t border-[var(--color-border)] px-4 py-4 sm:px-6">

            <div class="flex flex-col gap-4 sm:flex-row
                        sm:items-center sm:justify-between">

                <p class="text-sm text-[var(--color-foreground-muted)]">

                    {{ __('Page') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $sections->currentPage() }}
                    </span>
                    {{ __('of') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $sections->lastPage() }}
                    </span>

                </p>

                <div class="flex items-center gap-1">

                    @if ($sections->onFirstPage())

                    <span
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm
                                   text-[var(--color-foreground-muted)]
                                   opacity-50">
                        {{ __('Previous') }}
                    </span>

                    @else

                    <a
                        href="{{ $sections->previousPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        {{ __('Previous') }}
                    </a>

                    @endif

                    @foreach (
                    $sections->getUrlRange(
                    max(1, $sections->currentPage() - 2),
                    min($sections->lastPage(), $sections->currentPage() + 2)
                    ) as $page => $url
                    )

                    @if ($page == $sections->currentPage())

                    <span
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                       rounded-lg bg-[var(--color-primary)]
                                       px-3 text-sm font-medium text-white">
                        {{ $page }}
                    </span>

                    @else

                    <a
                        href="{{ $url }}"
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                       rounded-lg border border-[var(--color-border)]
                                       px-3 text-sm transition
                                       hover:bg-[var(--color-surface-muted)]">
                        {{ $page }}
                    </a>

                    @endif

                    @endforeach

                    @if ($sections->hasMorePages())

                    <a
                        href="{{ $sections->nextPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        {{ __('Next') }}
                    </a>

                    @else

                    <span
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm
                                   text-[var(--color-foreground-muted)]
                                   opacity-50">
                        {{ __('Next') }}
                    </span>

                    @endif

                </div>

            </div>

        </div>

        @endif

    </div>


</div>
@endsection