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

    {{-- Semesters Table --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">
                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            #
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Semester
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Code
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Start Date
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            End Date
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Status
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse ($semesters as $semester)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
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

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $semester->start_date ? \Carbon\Carbon::parse($semester->start_date)->format('Y-m-d') : '—' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $semester->end_date ? \Carbon\Carbon::parse($semester->end_date)->format('Y-m-d') : '—' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($semester->is_active)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-success)_12%,transparent)] px-2.5 py-1 text-xs font-medium text-[var(--color-success)]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-success)]"></span>
                                Active
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-danger)_12%,transparent)] px-2.5 py-1 text-xs font-medium text-[var(--color-danger)]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-danger)]"></span>
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
                                    class="mb-3 h-10 w-10 text-[var(--color-foreground-muted)]"
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
    </div>

</div>


@endsection