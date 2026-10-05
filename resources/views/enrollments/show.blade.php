
@extends('layouts.app')

@section('title', __('Enrollment Details'))

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold">
                    {{ __('Enrollment Details') }}
                </h1>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('View enrollment and course information.') }}
                </p>
            </div>

            <div class="flex gap-2">

                <a
                    href="{{ route('enrollments.index') }}"
                    class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                >
                    {{ __('Back') }}
                </a>

                <a
                    href="{{ route('enrollments.edit', $enrollment) }}"
                    class="rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    {{ __('Edit') }}
                </a>

            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Enrollment Information --}}
            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

                <h2 class="mb-5 text-lg font-semibold">
                    {{ __('Enrollment Information') }}
                </h2>

                <dl class="space-y-4">

                    <div>
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Enrollment ID') }}
                        </dt>

                        <dd class="mt-1 text-sm font-medium">
                            {{ $enrollment->id }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Student') }}
                        </dt>

                        <dd class="mt-1 text-sm font-medium">
                            {{ $enrollment->student?->name ?? '—' }}
                        </dd>

                        @if ($enrollment->student?->email)
                            <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                                {{ $enrollment->student->email }}
                            </p>
                        @endif
                    </div>

                    <div>
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Status') }}
                        </dt>

                        <dd class="mt-2">
                            @php
                                $statusClasses = match ($enrollment->status) {
                                    'enrolled' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-blue-100 text-blue-700',
                                    'dropped' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                                {{ __(ucfirst($enrollment->status ?? 'unknown')) }}
                            </span>
                        </dd>
                    </div>

                </dl>
            </div>

            {{-- Course Information --}}
            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

                <h2 class="mb-5 text-lg font-semibold">
                    {{ __('Course Information') }}
                </h2>

                <dl class="space-y-4">

                    <div>
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Course') }}
                        </dt>

                        <dd class="mt-1 text-sm font-medium">
                            {{ $enrollment->section?->course?->name ?? '—' }}
                        </dd>

                        @if ($enrollment->section?->course?->code)
                            <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                                {{ $enrollment->section->course->code }}
                            </p>
                        @endif
                    </div>

                    <div>
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Section') }}
                        </dt>

                        <dd class="mt-1 text-sm font-medium">
                            {{ $enrollment->section?->section_number ?? '—' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Semester') }}
                        </dt>

                        <dd class="mt-1 text-sm font-medium">
                            {{ $enrollment->section?->semester?->name ?? '—' }}
                        </dd>
                    </div>

                </dl>
            </div>

        </div>

    </div>
@endsection

