@extends('layouts.app')

@section('title', 'Departments')

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
                Departments
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Manage and view university departments.
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

            Add Department
        </a>
        @endif
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
                            class="px-6 py-4 text-left text-xs font-semibold uppercase
                                   tracking-wider text-[var(--color-foreground-muted)]">
                            #
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold uppercase
                                   tracking-wider text-[var(--color-foreground-muted)]">
                            Department
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold uppercase
                                   tracking-wider text-[var(--color-foreground-muted)]">
                            Code
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold uppercase
                                   tracking-wider text-[var(--color-foreground-muted)]">
                            College
                        </th>

                        <th
                            scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold uppercase
                                   tracking-wider text-[var(--color-foreground-muted)]">
                            Actions
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
                                class="inline-flex rounded-md bg-[var(--color-surface-muted)]
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
                                    class="mb-3 h-10 w-10 text-[var(--color-foreground-muted)]"
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
                                    No departments found.
                                </p>

                                @if ($isAdmin)
                                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                    Create your first department to get started.
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