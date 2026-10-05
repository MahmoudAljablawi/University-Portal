@extends('layouts.app')

@section('title', __('Colleges'))

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
                {{ __('Colleges') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Manage the university colleges and their academic departments.') }}
            </p>
        </div>

        @if (auth()->user()->role === 'admin')
            <a
                href="{{ route('colleges.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M12 5v14M5 12h14" />
                </svg>

                {{ __('Add College') }}
            </a>
        @endif
    </div>

    {{-- Search --}}
    <div
        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4 shadow-sm"
    >
        <form
            method="GET"
            action="{{ route('colleges.index') }}"
            class="flex flex-col gap-4 sm:flex-row sm:items-end"
        >
            <div class="flex-1">
                <label
                    for="search"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('Search') }}
                </label>

                <div class="relative">
                    <div
                        class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-[var(--color-foreground-muted)]"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-4-4" />
                        </svg>
                    </div>

                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search by college name or code...') }}"
                        class="block w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] py-2.5 ps-10 pe-4 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >
                </div>
            </div>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-4-4" />
                    </svg>

                    {{ __('Search') }}
                </button>

                @if(request()->filled('search'))
                    <a
                        href="{{ route('colleges.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                    >
                        {{ __('Reset') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Results Summary --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-[var(--color-foreground-muted)]">
            {{ __('Showing') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $colleges->firstItem() ?? 0 }}
            </span>
            {{ __('to') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $colleges->lastItem() ?? 0 }}
            </span>
            {{ __('of') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $colleges->total() }}
            </span>
            {{ __('colleges') }}
        </p>
    </div>

    {{-- Colleges Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('College') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Code') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Departments') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($colleges as $college)

                        <tr class="transition hover:bg-[var(--color-surface-muted)]">

                            {{-- College --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[var(--color-primary)]/10 text-sm font-semibold text-[var(--color-primary)]"
                                    >
                                        {{ strtoupper(substr($college->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-[var(--color-foreground)]">
                                            {{ $college->name }}
                                        </p>

                                        <p class="text-xs text-[var(--color-foreground-muted)]">
                                            #{{ $college->id }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- Code --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="inline-flex rounded-md bg-[var(--color-surface-muted)] px-2.5 py-1 text-xs font-semibold tracking-wide text-[var(--color-foreground)]"
                                >
                                    {{ $college->code }}
                                </span>
                            </td>

                            {{-- Departments --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="text-sm text-[var(--color-foreground)]">
                                    {{ $college->departments->count() }}
                                </span>

                                <span class="ms-1 text-xs text-[var(--color-foreground-muted)]">
                                    {{ $college->departments->count() === 1 ? 'department' : 'departments' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <x-table-actions
                                :model="$college"
                                :itemName="$college->name"
                                showRoute="colleges.show"
                                editRoute="colleges.edit"
                                destroyRoute="colleges.destroy"
                                :showEdit="auth()->user()->role === 'admin'"
                                :showDelete="auth()->user()->role === 'admin'"
                                deleteConfirm="Are you sure you want to delete this college?"
                            />

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center"
                            >
                                <div class="flex flex-col items-center">

                                    <svg
                                        class="mb-3 h-10 w-10 text-[var(--color-foreground-muted)]"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    >
                                        <path d="M3 21h18" />
                                        <path d="M5 21V5l7-3 7 3v16" />
                                        <path d="M9 21v-4h6v4" />
                                        <path d="M9 8h1M14 8h1M9 12h1M14 12h1" />
                                    </svg>

                                    <p class="text-sm font-medium text-[var(--color-foreground)]">
                                        {{ __('No colleges found') }}
                                    </p>

                                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                        @if(request()->filled('search'))
                                            Try adjusting your search.
                                        @else
                                            Create a college to get started.
                                        @endif
                                    </p>

                                    @if(request()->filled('search'))
                                        <a
                                            href="{{ route('colleges.index') }}"
                                            class="mt-4 text-sm font-medium text-[var(--color-primary)] hover:underline"
                                        >
                                            {{ __('Clear search') }}
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        @if ($colleges->hasPages())
            <div
                class="flex flex-col gap-4 border-t border-[var(--color-border)] px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Page') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $colleges->currentPage() }}
                    </span>
                    {{ __('of') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $colleges->lastPage() }}
                    </span>
                </p>

                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($colleges->onFirstPage())
                        <span
                            class="inline-flex h-9 items-center justify-center rounded-lg border border-[var(--color-border)] px-3 text-sm text-[var(--color-foreground-muted)] opacity-50"
                        >
                            {{ __('Previous') }}
                        </span>
                    @else
                        <a
                            href="{{ $colleges->previousPageUrl() }}"
                            class="inline-flex h-9 items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                        >
                            {{ __('Previous') }}
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($colleges->getUrlRange(
                        max(1, $colleges->currentPage() - 1),
                        min($colleges->lastPage(), $colleges->currentPage() + 1)
                    ) as $page => $url)

                        @if ($page == $colleges->currentPage())
                            <span
                                class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-[var(--color-primary)] px-3 text-sm font-medium text-white"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $url }}"
                                class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                            >
                                {{ $page }}
                            </a>
                        @endif

                    @endforeach

                    {{-- Next --}}
                    @if ($colleges->hasMorePages())
                        <a
                            href="{{ $colleges->nextPageUrl() }}"
                            class="inline-flex h-9 items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                        >
                            {{ __('Next') }}
                        </a>
                    @else
                        <span
                            class="inline-flex h-9 items-center justify-center rounded-lg border border-[var(--color-border)] px-3 text-sm text-[var(--color-foreground-muted)] opacity-50"
                        >
                            {{ __('Next') }}
                        </span>
                    @endif

                </div>
            </div>
        @endif

    </div>

</div>
@endsection
