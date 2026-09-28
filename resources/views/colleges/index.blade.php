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
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path d="M12 5v14M5 12h14" />
            </svg>

            Add College
        </a>
        @endif
    </div>

    {{-- Colleges Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            College
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Code
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Departments
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
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
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[var(--color-primary)]/10 text-sm font-semibold text-[var(--color-primary)]">
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
                                class="inline-flex rounded-md bg-[var(--color-surface-muted)] px-2.5 py-1 text-xs font-semibold tracking-wide text-[var(--color-foreground)]">
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

                        <x-table-actions
                            :model="$college"
                            :itemName="$college->name"
                            showRoute="colleges.show"
                            editRoute="colleges.edit"
                            destroyRoute="colleges.destroy"
                            :showEdit="auth()->user()->role === 'admin'"
                            :showDelete="auth()->user()->role === 'admin'"
                            deleteConfirm="Are you sure you want to delete this college?" />

                    </tr>

                    @empty

                    <tr>
                        <td
                            colspan="4"
                            class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">

                                <svg
                                    class="mb-3 h-10 w-10 text-[var(--color-foreground-muted)]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M3 21h18" />
                                    <path d="M5 21V5l7-3 7 3v16" />
                                    <path d="M9 21v-4h6v4" />
                                    <path d="M9 8h1M14 8h1M9 12h1M14 12h1" />
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