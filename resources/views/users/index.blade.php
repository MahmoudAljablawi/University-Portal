@extends('layouts.app')

@section('title', __('Users'))

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
                {{ __('Users') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Manage users and their account information.') }}
            </p>
        </div>

        <a
            href="{{ route('users.create') }}"
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

            {{ __('Add User') }}
        </a>
    </div>

    {{-- Search & Filters --}}
    <div
        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4 shadow-sm"
    >
        <form
            method="GET"
            action="{{ route('users.index') }}"
            class="flex flex-col gap-4 lg:flex-row lg:items-end"
        >

            {{-- Search --}}
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
                        placeholder="{{ __('Search by name, email, or phone...') }}"
                        class="block w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] py-2.5 ps-10 pe-4 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >
                </div>
            </div>

            {{-- Role Filter --}}
            <div class="w-full lg:w-52">
                <label
                    for="role"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('Role') }}
                </label>

                <select
                    id="role"
                    name="role"
                    class="block w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >
                    <option value="">{{ __('All roles') }}</option>
                    <option value="admin" @selected(request('role') === 'admin')>
                        {{ __('Administrator') }}
                    </option>
                    <option value="instructor" @selected(request('role') === 'instructor')>
                        {{ __('Instructor') }}
                    </option>
                    <option value="student" @selected(request('role') === 'student')>
                        {{ __('Student') }}
                    </option>
                    <option value="employee" @selected(request('role') === 'employee')>
                        {{ __('Employee') }}
                    </option>

                </select>
            </div>

            {{-- Status Filter --}}
            <div class="w-full lg:w-52">
                <label
                    for="status"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('Status') }}
                </label>

                <select
                    id="status"
                    name="status"
                    class="block w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >
                    <option value="">{{ __('All statuses') }}</option>
                    <option value="active" @selected(request('status') === 'active')>
                        {{ __('Active') }}
                    </option>
                    <option value="inactive" @selected(request('status') === 'inactive')>
                        {{ __('Inactive') }}
                    </option>
                </select>
            </div>

            {{-- Actions --}}
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

                @if(request()->filled('search') || request()->filled('role') || request()->filled('status'))
                    <a
                        href="{{ route('users.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                    >
                        {{ __('Reset') }}
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Results Summary --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-[var(--color-foreground-muted)]">
            {{ __('Showing') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $users->firstItem() ?? 0 }}
            </span>
            {{ __('to') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $users->lastItem() ?? 0 }}
            </span>
            {{ __('of') }}
            <span class="font-medium text-[var(--color-foreground)]">
                {{ $users->total() }}
            </span>
            {{ __('users') }}
        </p>

        @if(request()->filled('search') || request()->filled('role') || request()->filled('status'))
            <p class="text-sm text-[var(--color-foreground-muted)]">
                {{ __('Filtered results') }}
            </p>
        @endif
    </div>

    {{-- Users Table --}}
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
                            {{ __('Name') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Email') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Phone') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Role') }}
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            {{ __('Status') }}
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

                    @forelse ($users as $user)

                        <tr class="transition hover:bg-[var(--color-surface-muted)]">

                            {{-- Name --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[var(--color-primary)] text-sm font-semibold text-white"
                                    >
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-[var(--color-foreground)]">
                                            {{ $user->name }}
                                        </p>

                                        <p class="text-xs text-[var(--color-foreground-muted)]">
                                            #{{ $user->id }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="text-sm text-[var(--color-foreground)]">
                                    {{ $user->email }}
                                </span>
                            </td>

                            {{-- Phone --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="text-sm text-[var(--color-foreground-muted)]">
                                    {{ $user->phone ?? '—' }}
                                </span>
                            </td>

                            {{-- Role --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @php
                                    $roleLabels = [
                                        'admin' => __('Administrator'),
                                        'instructor' => __('Instructor'),
                                        'student' => __('Student'),
                                        'employee' => __('Employee'),
                                    ];

                                    $roleLabel = $roleLabels[$user->role]
                                        ?? __(ucfirst($user->role));
                                @endphp

                                <span
                                    class="inline-flex rounded-full bg-[var(--color-surface-muted)] px-2.5 py-1 text-xs font-medium text-[var(--color-foreground)]"
                                >
                                    {{ $roleLabel }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($user->is_active)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-success)_12%,transparent)] px-2.5 py-1 text-xs font-medium text-[var(--color-success)]"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-success)]"></span>
                                        {{ __('Active') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-danger)_12%,transparent)] px-2.5 py-1 text-xs font-medium text-[var(--color-danger)]"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-danger)]"></span>
                                        {{ __('Inactive') }}
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <x-table-actions
                                :model="$user"
                                itemName="{{ $user->name }}"
                                showRoute="users.show"
                                editRoute="users.edit"
                                destroyRoute="users.destroy"
                                deleteConfirm="Delete this user?"
                            />

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="6"
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
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>

                                    <p class="text-sm font-medium text-[var(--color-foreground)]">
                                        {{ __('No users found') }}
                                    </p>

                                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                        {{ __('Try adjusting your search or filters.') }}
                                    </p>

                                    @if(request()->filled('search') || request()->filled('role') || request()->filled('status'))
                                        <a
                                            href="{{ route('users.index') }}"
                                            class="mt-4 text-sm font-medium text-[var(--color-primary)] hover:underline"
                                        >
                                            {{ __('Clear filters') }}
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
        @if ($users->hasPages())
            <div
                class="flex flex-col gap-4 border-t border-[var(--color-border)] px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Page') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $users->currentPage() }}
                    </span>
                    {{ __('of') }}
                    <span class="font-medium text-[var(--color-foreground)]">
                        {{ $users->lastPage() }}
                    </span>
                </p>

                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($users->onFirstPage())
                        <span
                            class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[var(--color-border)] px-3 text-sm text-[var(--color-foreground-muted)] opacity-50"
                        >
                            {{ __('Previous') }}
                        </span>
                    @else
                        <a
                            href="{{ $users->previousPageUrl() }}"
                            class="inline-flex h-9 items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                        >
                            {{ __('Previous') }}
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($users->getUrlRange(
                        max(1, $users->currentPage() - 1),
                        min($users->lastPage(), $users->currentPage() + 1)
                    ) as $page => $url)

                        @if ($page == $users->currentPage())
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
                    @if ($users->hasMorePages())
                        <a
                            href="{{ $users->nextPageUrl() }}"
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
