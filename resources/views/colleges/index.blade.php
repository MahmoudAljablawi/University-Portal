@extends('layouts.app')

@section('title', 'Colleges')

@section('content') <div class="space-y-6">


    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
                Colleges
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Manage the university colleges and their academic departments.
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
                    <path d="M12 5v14M5 12h14"/>
                </svg>

                Add College
            </a>
        @endif
    </div>

    {{-- Colleges Table --}}
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
                            College
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Code
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]"
                        >
                            Departments
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
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('colleges.show', $college) }}"
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

                                    @if (auth()->user()->role === 'admin')

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('colleges.edit', $college) }}"
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
                                            action="{{ route('colleges.destroy', $college) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this college?');"
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

                                    @endif

                                </div>
                            </td>

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
                                        <path d="M3 21h18"/>
                                        <path d="M5 21V5l7-3 7 3v16"/>
                                        <path d="M9 21v-4h6v4"/>
                                        <path d="M9 8h1M14 8h1M9 12h1M14 12h1"/>
                                    </svg>

                                    <p class="text-sm font-medium text-[var(--color-foreground)]">
                                        No colleges found
                                    </p>

                                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                        Create a college to get started.
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
