@extends('layouts.app')

@section('title', 'Users')

@section('content') <div class="space-y-6">


    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
                Users
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Manage users and their account information.
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
                <path d="M12 5v14M5 12h14"/>
            </svg>

            Add User
        </a>
    </div>

    {{-- Users Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Name
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Email
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Phone
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Role
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Status
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Actions
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
                                        'admin' => 'Administrator',
                                        'instructor' => 'Instructor',
                                        'student' => 'Student',
                                    ];

                                    $roleLabel = $roleLabels[$user->role]
                                        ?? ucfirst($user->role);
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
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-danger)_12%,transparent)] px-2.5 py-1 text-xs font-medium text-[var(--color-danger)]"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-danger)]"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('users.show', $user) }}"
                                        class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-foreground)]"
                                        title="View"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-primary)]"
                                        title="Edit"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[color-mix(in_srgb,var(--color-danger)_10%,transparent)] hover:text-[var(--color-danger)]"
                                            title="Delete"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4h8v2"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v5M14 11v5"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>

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
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>

                                    <p class="text-sm font-medium text-[var(--color-foreground)]">
                                        No users found
                                    </p>

                                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                        Create the first user to get started.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>


@endsection
