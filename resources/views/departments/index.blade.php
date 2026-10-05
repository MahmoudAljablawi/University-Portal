@extends('layouts.app')

@section('title', __('Departments'))

@section('content')
@php
$user = auth()->user();
$isAdmin = $user?->role === 'admin';
@endphp

<div class="space-y-6">


{{-- Page Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">
            {{ __('Departments') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Manage and view university departments.') }}
        </p>
    </div>

    @if ($isAdmin)
        <a
            href="{{ route('departments.create') }}"
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

            {{ __('Add Department') }}
        </a>
    @endif
</div>

{{-- Search & Filters --}}
<div
    class="rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] p-4 shadow-sm">

    <form
        method="GET"
        action="{{ route('departments.index') }}"
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
                    placeholder="{{ __('Search by department name or code...') }}"
                    class="w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] py-2.5 ps-10 pe-4
                           text-sm outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20">
            </div>
        </div>

        {{-- College Filter --}}
        <div class="w-full lg:w-64">
            <label
                for="college_id"
                class="mb-2 block text-sm font-medium">
                {{ __('College') }}
            </label>

            <select
                id="college_id"
                name="college_id"
                class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">
                <option value="">{{ __('All Colleges') }}</option>

                @foreach ($colleges as $college)
                    <option
                        value="{{ $college->id }}"
                        @selected((string) request('college_id') === (string) $college->id)>
                        {{ $college->name }}
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

            @if (request()->filled('search') || request()->filled('college_id'))
                <a
                    href="{{ route('departments.index') }}"
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
<div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-sm text-[var(--color-foreground-muted)]">
        {{ __('Showing') }}
        <span class="font-medium text-[var(--color-foreground)]">
            {{ $departments->firstItem() ?? 0 }}
        </span>
        {{ __('to') }}
        <span class="font-medium text-[var(--color-foreground)]">
            {{ $departments->lastItem() ?? 0 }}
        </span>
        {{ __('of') }}
        <span class="font-medium text-[var(--color-foreground)]">
            {{ $departments->total() }}
        </span>
        {{ __('departments') }}
    </p>
</div>

{{-- Departments Table --}}
<div
    class="overflow-hidden rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] shadow-sm">

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[var(--color-border)]">

            <thead class="bg-[var(--color-surface-muted)]">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-4 text-start text-xs font-semibold uppercase
                               tracking-wider text-[var(--color-foreground-muted)]">
                        #
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-4 text-start text-xs font-semibold uppercase
                               tracking-wider text-[var(--color-foreground-muted)]">
                        {{ __('Department') }}
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-4 text-start text-xs font-semibold uppercase
                               tracking-wider text-[var(--color-foreground-muted)]">
                        {{ __('Code') }}
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-4 text-start text-xs font-semibold uppercase
                               tracking-wider text-[var(--color-foreground-muted)]">
                        {{ __('College') }}
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-4 text-end text-xs font-semibold uppercase
                               tracking-wider text-[var(--color-foreground-muted)]">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[var(--color-border)]">

                @forelse ($departments as $department)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $department->id }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="font-medium">
                                {{ $department->name }}
                            </div>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            <span
                                class="inline-flex rounded-md
                                       bg-[var(--color-surface-muted)]
                                       px-2.5 py-1 text-xs font-medium">
                                {{ $department->code }}
                            </span>
                        </td>

                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $department->college?->name ?? '—' }}
                        </td>

                        <x-table-actions
                            :model="$department"
                            :itemName="$department->name"
                            showRoute="departments.show"
                            editRoute="departments.edit"
                            destroyRoute="departments.destroy"
                            :showEdit="$isAdmin"
                            :showDelete="$isAdmin"
                            deleteConfirm="Are you sure you want to delete this department?" />

                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">

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
                                        d="M3 7.5 12 3l9 4.5M4.5 8.25V19.5L12 21l7.5-1.5V8.25M12 21V12M4.5 8.25 12 12l7.5-3.75" />
                                </svg>

                                <p class="text-sm font-medium">
                                    {{ __('No departments found.') }}
                                </p>

                                @if ($isAdmin)
                                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                        {{ __('Create your first department to get started.') }}
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
    @if ($departments->hasPages())
        <div
            class="border-t border-[var(--color-border)]
                   px-4 py-4 sm:px-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Page') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $departments->currentPage() }}
                    </span>
                    {{ __('of') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $departments->lastPage() }}
                    </span>
                </p>

                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($departments->onFirstPage())
                        <span
                            class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm text-[var(--color-foreground-muted)]
                                   opacity-50">
                            {{ __('Previous') }}
                        </span>
                    @else
                        <a
                            href="{{ $departments->previousPageUrl() }}"
                            class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                            {{ __('Previous') }}
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($departments->getUrlRange(
                        max(1, $departments->currentPage() - 2),
                        min($departments->lastPage(), $departments->currentPage() + 2)
                    ) as $page => $url)

                        @if ($page == $departments->currentPage())
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
                    @if ($departments->hasMorePages())
                        <a
                            href="{{ $departments->nextPageUrl() }}"
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
                                   px-3 text-sm text-[var(--color-foreground-muted)]
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
