@extends('layouts.app')

@section('title', 'Enrollments')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold">
                Enrollments
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                View and manage course enrollments.
            </p>
        </div>

        <a
            href="{{ route('enrollments.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
            + Add Enrollment
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            #
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Student
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Course
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Section
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Status
                        </th>

                        <th class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($enrollments as $enrollment)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $enrollment->id }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium">
                                {{ $enrollment->student?->name ?? '—' }}
                            </div>

                            @if ($enrollment->student?->email)
                            <div class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                                {{ $enrollment->student->email }}
                            </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium">
                                {{ $enrollment->section?->course?->name ?? '—' }}
                            </div>

                            @if ($enrollment->section?->course?->code)
                            <div class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                                {{ $enrollment->section->course->code }}
                            </div>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $enrollment->section?->section_number ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            @php
                            $statusClasses = match ($enrollment->status) {
                            'enrolled' => 'bg-green-100 text-green-700',
                            'completed' => 'bg-blue-100 text-blue-700',
                            'dropped' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                            };
                            @endphp

                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                                {{ ucfirst($enrollment->status ?? 'unknown') }}
                            </span>
                        </td>

                        <x-table-actions
                            :model="$enrollment"
                            :itemName="($enrollment->student?->name ?? 'Student') . ' - ' . ($enrollment->section?->course?->code ?? 'Course')"
                            showRoute="enrollments.show"
                            editRoute="enrollments.edit"
                            destroyRoute="enrollments.destroy"
                            :showEdit="true"
                            :showDelete="true"
                            deleteConfirm="Are you sure you want to remove this enrollment?" />

                    </tr>
                    @empty
                    <tr>
                        <td
                            colspan="6"
                            class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]">
                            No enrollments found.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection