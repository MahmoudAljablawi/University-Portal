@extends('layouts.app')

@section('title', 'Grades')

@section('content')
<div class="space-y-6">

    @php
    $userRole = auth()->user()->role;
    $isStudent = $userRole === 'student';
    $canManageGrades = in_array($userRole, ['admin', 'instructor']);
    @endphp

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                Grades
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ $isStudent
                    ? 'View your published grades.'
                    : 'Manage and review student grades.'
                }}
            </p>
        </div>

        @if ($canManageGrades)
        <a
            href="{{ route('grades.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]">
            Add Grade
        </a>
        @endif

    </div>


    {{-- Grades Table --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">

                    <tr>

                        {{-- Student --}}
                        @if (! $isStudent)
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Student
                        </th>
                        @endif


                        {{-- Course --}}
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Course
                        </th>


                        {{-- Midterm --}}
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Midterm
                        </th>


                        {{-- Final --}}
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Final
                        </th>


                        {{-- Total --}}
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Total
                        </th>


                        {{-- Letter --}}
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Letter
                        </th>


                        {{-- Published --}}
                        @if (! $isStudent)
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Published
                        </th>
                        @endif


                        {{-- Actions --}}
                        <th class="px-6 py-3 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($grades as $grade)

                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        {{-- Student --}}
                        @if (! $isStudent)
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">
                            {{ $grade->enrollment?->student?->name ?? '—' }}
                        </td>
                        @endif


                        {{-- Course --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <div class="text-sm font-medium text-[var(--color-foreground)]">
                                {{ $grade->enrollment?->section?->course?->name ?? '—' }}
                            </div>

                            <div class="text-xs text-[var(--color-foreground-muted)]">
                                {{ $grade->enrollment?->section?->course?->code ?? '—' }}
                            </div>

                        </td>


                        {{-- Midterm --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">
                            {{ $grade->midterm_grade ?? '—' }}
                        </td>


                        {{-- Final --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">
                            {{ $grade->final_grade ?? '—' }}
                        </td>


                        {{-- Total --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-[var(--color-foreground)]">
                            {{ $grade->total_grade ?? '—' }}
                        </td>


                        {{-- Letter --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($grade->letter_grade)

                            <span class="inline-flex rounded-full bg-[var(--color-sidebar-active)] px-2.5 py-1 text-xs font-semibold text-[var(--color-primary)]">
                                {{ $grade->letter_grade }}
                            </span>

                            @else

                            <span class="text-sm text-[var(--color-foreground-muted)]">
                                —
                            </span>

                            @endif

                        </td>


                        {{-- Published --}}
                        @if (! $isStudent)

                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($grade->is_published)

                            <span class="inline-flex rounded-full bg-[var(--color-success)]/10 px-2.5 py-1 text-xs font-semibold text-[var(--color-success)]">
                                Published
                            </span>

                            @else

                            <span class="inline-flex rounded-full bg-[var(--color-warning)]/10 px-2.5 py-1 text-xs font-semibold text-[var(--color-warning)]">
                                Not Published
                            </span>

                            @endif

                        </td>

                        @endif


                        <x-table-actions
                            :model="$grade"
                            itemName="Grade #{{ $grade->id }}"
                            showRoute="grades.show"
                            editRoute="grades.edit"
                            destroyRoute="grades.destroy"
                            :showEdit="$canManageGrades"
                            :showDelete="$canManageGrades"
                            deleteConfirm="Are you sure you want to delete this grade?" />

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="{{ $isStudent ? 6 : 8 }}"
                            class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]">
                            {{ $isStudent
                                    ? 'No published grades found.'
                                    : 'No grades found.'
                                }}
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection