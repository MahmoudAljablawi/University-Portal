@extends('layouts.app')

@section('title', __('Academic Semester Details'))

@section('content')
@php
$user = auth()->user();
$isAdmin = $user?->role === 'admin';
@endphp


<div class="mx-auto max-w-5xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-[var(--color-foreground-muted)]">
                <a
                    href="{{ route('academic-semesters.index') }}"
                    class="transition hover:text-[var(--color-primary)]"
                >
                    {{ __('Academic Semesters') }}
                </a>

                <span>/</span>

                <span>{{ __('Details') }}</span>
            </div>

            <h1 class="mt-2 text-2xl font-semibold tracking-tight">
                {{ $academicSemester->name }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Academic semester details and related course sections.') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a
                href="{{ route('academic-semesters.index') }}"
                class="inline-flex items-center justify-center rounded-lg
                       border border-[var(--color-border)]
                       px-4 py-2.5 text-sm font-medium
                       transition hover:bg-[var(--color-surface-muted)]"
            >
                {{ __('Back') }}
            </a>

            @if ($isAdmin)
                <a
                    href="{{ route('academic-semesters.edit', $academicSemester) }}"
                    class="inline-flex items-center justify-center rounded-lg
                           bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium
                           text-white transition
                           hover:bg-[var(--color-primary-hover)]"
                >
                    {{ __('Edit Semester') }}
                </a>
            @endif
        </div>
    </div>

    {{-- Semester Information --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] shadow-sm"
    >
        <div class="border-b border-[var(--color-border)] px-6 py-4">
            <h2 class="text-base font-semibold">
                {{ __('Semester Information') }}
            </h2>
        </div>

        <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Name --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Semester Name') }}
                </p>

                <p class="mt-1 font-medium">
                    {{ $academicSemester->name }}
                </p>
            </div>

            {{-- Code --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Code') }}
                </p>

                <p class="mt-1">
                    <span
                        class="inline-flex rounded-md
                               bg-[var(--color-surface-muted)]
                               px-2.5 py-1 text-sm font-medium"
                    >
                        {{ $academicSemester->code }}
                    </span>
                </p>
            </div>

            {{-- Start Date --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Start Date') }}
                </p>

                <p class="mt-1 font-medium">
                    {{ $academicSemester->start_date
                        ? \Carbon\Carbon::parse($academicSemester->start_date)->format('Y-m-d')
                        : '—' }}
                </p>
            </div>

            {{-- End Date --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('End Date') }}
                </p>

                <p class="mt-1 font-medium">
                    {{ $academicSemester->end_date
                        ? \Carbon\Carbon::parse($academicSemester->end_date)->format('Y-m-d')
                        : '—' }}
                </p>
            </div>

        </div>

        <div class="border-t border-[var(--color-border)] px-6 py-4">
            <div class="flex items-center gap-3">
                <span class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Status') }}
                </span>

                @if ($academicSemester->is_active)
                    <span
                        class="inline-flex items-center rounded-full
                               bg-green-100 px-2.5 py-1 text-xs font-medium
                               text-green-700 dark:bg-green-950/40
                               dark:text-green-400"
                    >
                        {{ __('Active') }}
                    </span>
                @else
                    <span
                        class="inline-flex items-center rounded-full
                               bg-[var(--color-surface-muted)]
                               px-2.5 py-1 text-xs font-medium
                               text-[var(--color-foreground-muted)]"
                    >
                        {{ __('Inactive') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Course Sections --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] shadow-sm"
    >
        <div
            class="flex items-center justify-between border-b
                   border-[var(--color-border)] px-6 py-4"
        >
            <div>
                <h2 class="text-base font-semibold">
                    {{ __('Course Sections') }}
                </h2>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Course sections associated with this academic semester.') }}
                </p>
            </div>

            <span
                class="rounded-full bg-[var(--color-surface-muted)]
                       px-3 py-1 text-sm font-medium"
            >
                {{ $academicSemester->courseSections->count()??0}}
            </span>
        </div>

        @if ($academicSemester->courseSections->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-border)]">
                    <thead class="bg-[var(--color-surface-muted)]">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider
                                       text-[var(--color-foreground-muted)]"
                            >
                                #
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider
                                       text-[var(--color-foreground-muted)]"
                            >
                                {{ __('Course') }}
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider
                                       text-[var(--color-foreground-muted)]"
                            >
                                {{ __('Course Code') }}
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider
                                       text-[var(--color-foreground-muted)]"
                            >
                                {{ __('Section') }}
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider
                                       text-[var(--color-foreground-muted)]"
                            >
                                {{ __('Capacity') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[var(--color-border)]">
                        @foreach ($academicSemester->courseSections as $section)
                            <tr class="transition hover:bg-[var(--color-surface-muted)]">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    {{ $section->id }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium">
                                        {{ $section->course?->name ?? '—' }}
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($section->course?->code)
                                        <span
                                            class="inline-flex rounded-md
                                                   bg-[var(--color-surface-muted)]
                                                   px-2.5 py-1 text-xs font-medium"
                                        >
                                            {{ $section->course->code }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $section->section_number ?? $section->id }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $section->capacity ?? '—' }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium">
                    {{ __('No course sections found.') }}
                </p>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('This academic semester does not have any course sections yet.') }}
                </p>
            </div>
        @endif
    </div>

</div>


@endsection
