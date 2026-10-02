@extends('layouts.app')

@section('title', 'Academic Semesters')

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
                Academic Semesters
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Manage academic semesters and their active status.
            </p>
        </div>

        @if ($isAdmin)
        <a
            href="{{ route('academic-semesters.create') }}"
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

            Add Semester
        </a>
        @endif
    </div>

    {{-- Search & Filters --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
           bg-[var(--color-surface)] p-4 shadow-sm">

        <form
            method="GET"
            action="{{ route('academic-semesters.index') }}"
            class="flex flex-col gap-4 lg:flex-row lg:items-end">

            {{-- Search --}}
            <div class="flex-1">
                <label
                    for="search"
                    class="mb-2 block text-sm font-medium">
                    Search
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
                        placeholder="Search by semester name or code..."
                        class="w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] py-2.5 ps-10 pe-4
                           text-sm outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20">
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="w-full lg:w-56">
                <label
                    for="status"
                    class="mb-2 block text-sm font-medium">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-background)] px-3 py-2.5 text-sm
                       outline-none transition
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">All Statuses</option>

                    <option
                        value="active"
                        @selected(request('status')==='active' )>
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected(request('status')==='inactive' )>
                        Inactive
                    </option>
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

                    Search
                </button>

                @if (request()->filled('search') || request()->filled('status'))
                <a
                    href="{{ route('academic-semesters.index') }}"
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
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-[var(--color-foreground-muted)]">
            Showing
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $semesters->firstItem() ?? 0 }}
            </span>
            to
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $semesters->lastItem() ?? 0 }}
            </span>
            of
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $semesters->total() }}
            </span>
            academic semesters
        </p>
    </div>

    {{-- Semesters Table --}}
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
                            Semester
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Code
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Start Date
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            End Date
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold
                               uppercase tracking-wider
                               text-[var(--color-foreground-muted)]">
                            Status
                        </th>

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

                    @forelse ($semesters as $semester)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $semester->id }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="font-medium">
                                {{ $semester->name }}
                            </div>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            <span
                                class="inline-flex rounded-md
                                       bg-[var(--color-surface-muted)]
                                       px-2.5 py-1 text-xs font-medium">
                                {{ $semester->code }}
                            </span>
                        </td>

                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $semester->start_date
                                ? \Carbon\Carbon::parse($semester->start_date)->format('Y-m-d')
                                : '—' }}
                        </td>

                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                   text-[var(--color-foreground-muted)]">
                            {{ $semester->end_date
                                ? \Carbon\Carbon::parse($semester->end_date)->format('Y-m-d')
                                : '—' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($semester->is_active)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full
                                           bg-[color-mix(in_srgb,var(--color-success)_12%,transparent)]
                                           px-2.5 py-1 text-xs font-medium
                                           text-[var(--color-success)]">

                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                               bg-[var(--color-success)]">
                                </span>

                                Active
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full
                                           bg-[color-mix(in_srgb,var(--color-danger)_12%,transparent)]
                                           px-2.5 py-1 text-xs font-medium
                                           text-[var(--color-danger)]">

                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                               bg-[var(--color-danger)]">
                                </span>

                                Inactive
                            </span>
                            @endif

                        </td>

                        <x-table-actions
                            :model="$semester"
                            :itemName="$semester->name"
                            showRoute="academic-semesters.show"
                            editRoute="academic-semesters.edit"
                            destroyRoute="academic-semesters.destroy"
                            :showEdit="$isAdmin"
                            :showDelete="$isAdmin"
                            deleteConfirm="Are you sure you want to delete this academic semester?" />

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
                                        d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" />
                                </svg>

                                <p class="text-sm font-medium">
                                    No academic semesters found.
                                </p>

                                @if ($isAdmin)
                                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                    Create your first academic semester to get started.
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
        @if ($semesters->hasPages())
        <div
            class="border-t border-[var(--color-border)]
                   px-4 py-4 sm:px-6">

            <div
                class="flex flex-col gap-4 sm:flex-row
                       sm:items-center sm:justify-between">

                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Page
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $semesters->currentPage() }}
                    </span>
                    of
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $semesters->lastPage() }}
                    </span>
                </p>

                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($semesters->onFirstPage())
                    <span
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm
                                   text-[var(--color-foreground-muted)]
                                   opacity-50">
                        Previous
                    </span>
                    @else
                    <a
                        href="{{ $semesters->previousPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        Previous
                    </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($semesters->getUrlRange(
                    max(1, $semesters->currentPage() - 2),
                    min($semesters->lastPage(), $semesters->currentPage() + 2)
                    ) as $page => $url)

                    @if ($page == $semesters->currentPage())
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
                    @if ($semesters->hasMorePages())
                    <a
                        href="{{ $semesters->nextPageUrl() }}"
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
                                   px-3 text-sm transition
                                   hover:bg-[var(--color-surface-muted)]">
                        Next
                    </a>
                    @else
                    <span
                        class="inline-flex h-9 min-w-9 items-center justify-center
                                   rounded-lg border border-[var(--color-border)]
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