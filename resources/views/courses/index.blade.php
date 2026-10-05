@extends('layouts.app')

@section('title', __('Courses'))

@section('content')
@php
$user = auth()->user();
$isAdmin = $user?->role === 'admin';
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ __('Courses') }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Manage university courses and their academic information.') }}
            </p>
        </div>

        @if ($isAdmin)
        <a
            href="{{ route('courses.create') }}"
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

            {{ __('Add Course') }}
        </a>
        @endif
    </div>

    {{-- Search & Filters --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] p-4 shadow-sm">

        <form
            method="GET"
            action="{{ route('courses.index') }}"
            class="flex flex-col gap-4 lg:flex-row lg:items-end">

            {{-- Search --}}
            <div class="flex-1">
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
                        placeholder="{{ __('Search by course name or code...') }}"
                        class="w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] py-2.5 ps-10 pe-4
                           text-sm outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20">
                </div>
            </div>

            {{-- Department Filter --}}
            <div class="w-full lg:w-64">
                <label
                    for="department_id"
                    class="mb-2 block text-sm font-medium">
                    {{ __('Department') }}
                </label>

                <select
                    id="department_id"
                    name="department_id"
                    class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">{{ __('All Departments') }}</option>

                    @foreach ($departments as $department)
                    <option
                        value="{{ $department->id }}"
                        @selected((string) request('department_id')===(string) $department->id)>
                        {{ $department->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2">
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

                @if (request()->filled('search') || request()->filled('department_id'))
                <a
                    href="{{ route('courses.index') }}"
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
                {{ $courses->firstItem() ?? 0 }}
            </span>
            {{ __('to') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $courses->lastItem() ?? 0 }}
            </span>
            {{ __('of') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $courses->total() }}
            </span>
            {{ __('courses') }}
        </p>
    </div>

    {{-- Courses Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] shadow-sm">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            #
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Code') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Course Name') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Department') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Credits') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-end text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($courses as $course)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $course->id }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                            {{ $course->code }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $course->name }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $course->department?->name ?? '—' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $course->credits }}
                        </td>

                        <x-table-actions
                            :model="$course"
                            :itemName="$course->name"
                            showRoute="courses.show"
                            editRoute="courses.edit"
                            destroyRoute="courses.destroy"
                            :showEdit="$isAdmin"
                            :showDelete="$isAdmin"
                            deleteConfirm="Are you sure you want to delete this course?" />

                    </tr>

                    @empty
                    <tr>
                        <td
                            colspan="6"
                            class="px-6 py-12 text-center">

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
                                    {{ __('No courses found.') }}
                                </p>

                                @if ($isAdmin)
                                <p class="mt-1 text-sm
                                               text-[var(--color-foreground-muted)]">
                                    {{ __('Create your first course to get started.') }}
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
        @if ($courses->hasPages())
        <div
            class="border-t border-[var(--color-border)]
                   px-4 py-4 sm:px-6">

            <div
                class="flex flex-col gap-4 sm:flex-row
                       sm:items-center sm:justify-between">

                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Page') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $courses->currentPage() }}
                    </span>
                    {{ __('of') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $courses->lastPage() }}
                    </span>
                </p>

                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($courses->onFirstPage())
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
                        href="{{ $courses->previousPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        {{ __('Previous') }}
                    </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($courses->getUrlRange(
                    max(1, $courses->currentPage() - 2),
                    min($courses->lastPage(), $courses->currentPage() + 2)
                    ) as $page => $url)

                    @if ($page == $courses->currentPage())
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

                    {{-- Next --}}
                    @if ($courses->hasMorePages())
                    <a
                        href="{{ $courses->nextPageUrl() }}"
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