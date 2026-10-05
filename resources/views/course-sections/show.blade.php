@extends('layouts.app')

@section('title', __('Course Section'))

@section('content') <div class="space-y-6">


    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold">
                {{ __('Course Section') }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('View course section details and enrolled students.') }}
            </p>
        </div>

        <div class="flex gap-2">

            <a
                href="{{ route('course-sections.index') }}"
                class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]">
                {{ __('Back') }}
            </a>

            @if (auth()->user()->role === 'admin')
            <a
                href="{{ route('course-sections.edit', $crsSec) }}"
                class="rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
                {{ __('Edit') }}
            </a>
            @endif

        </div>
    </div>

    {{-- Section Information --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

        <h2 class="mb-5 text-lg font-semibold">
            {{ __('Section Information') }}
        </h2>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

            {{-- Course --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Course') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->course?->name ?? '—' }}
                </p>

                @if ($crsSec->course?->code)
                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $crsSec->course->code }}
                </p>
                @endif
            </div>

            {{-- Department --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Department') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->course?->department?->name ?? '—' }}
                </p>

                @if ($crsSec->course?->department?->code)
                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $crsSec->course->department->code }}
                </p>
                @endif
            </div>

            {{-- College --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('College') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->course?->department?->college?->name ?? '—' }}
                </p>

                @if ($crsSec->course?->department?->college?->code)
                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $crsSec->course->department->college->code }}
                </p>
                @endif
            </div>

            {{-- Section Number --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Section Number') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->section_number }}
                </p>
            </div>

            {{-- Academic Semester --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Academic Semester') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->semester?->name ?? '—' }}
                </p>

                @if ($crsSec->semester?->code)
                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $crsSec->semester->code }}
                </p>
                @endif
            </div>

            {{-- Instructor --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Instructor') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->instructor?->name ?? '—' }}
                </p>

                @if ($crsSec->instructor?->email)
                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $crsSec->instructor->email }}
                </p>
                @endif
            </div>

            {{-- Credits --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Credits') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->course?->credits ?? '—' }}
                </p>
            </div>

            {{-- Capacity --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Capacity') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->capacity }}
                </p>
            </div>

            {{-- Enrolled Students --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Enrolled Students') }}
                </p>

                <p class="mt-1 text-sm font-medium">
                    {{ $crsSec->enrollments->count() }}
                </p>
            </div>

        </div>

    </div>

    {{-- Enrolled Students --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">

        <div class="border-b border-[var(--color-border)] px-6 py-5">
            <h2 class="text-lg font-semibold">
                {{ __('Enrolled Students') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Students currently enrolled in this section.') }}
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            #
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            {{ __('Student') }}
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            {{ __('Email') }}
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($crsSec->enrollments as $enrollment)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td class="px-6 py-4 text-sm">
                            {{ $enrollment->id }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium">
                            {{ $enrollment->student?->name ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $enrollment->student?->email ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $enrollment->status ? __(ucfirst($enrollment->status)) : '—' }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td
                            colspan="4"
                            class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]">
                            {{ __('No students are enrolled in this section.') }}
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>


@endsection