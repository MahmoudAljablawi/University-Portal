@extends('layouts.app')

@section('title', __('Department Details'))

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
                    href="{{ route('departments.index') }}"
                    class="transition hover:text-[var(--color-primary)]"
                >
                    {{ __('Departments') }}
                </a>

                <span>/</span>

                <span>{{ __('Details') }}</span>
            </div>

            <h1 class="mt-2 text-2xl font-semibold tracking-tight">
                {{ $department->name }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Department details and related courses.') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a
                href="{{ route('departments.index') }}"
                class="inline-flex items-center justify-center rounded-lg
                       border border-[var(--color-border)]
                       px-4 py-2.5 text-sm font-medium
                       transition hover:bg-[var(--color-surface-muted)]"
            >
                {{ __('Back') }}
            </a>

            @if ($isAdmin)
                <a
                    href="{{ route('departments.edit', $department) }}"
                    class="inline-flex items-center justify-center rounded-lg
                           bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium
                           text-white transition
                           hover:bg-[var(--color-primary-hover)]"
                >
                    {{ __('Edit Department') }}
                </a>
            @endif
        </div>
    </div>

    {{-- Department Information --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] shadow-sm"
    >
        <div class="border-b border-[var(--color-border)] px-6 py-4">
            <h2 class="text-base font-semibold">
                {{ __('Department Information') }}
            </h2>
        </div>

        <div class="grid gap-6 p-6 sm:grid-cols-2">

            {{-- Name --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Department Name') }}
                </p>

                <p class="mt-1 font-medium">
                    {{ $department->name }}
                </p>
            </div>

            {{-- Code --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Department Code') }}
                </p>

                <p class="mt-1">
                    <span
                        class="inline-flex rounded-md
                               bg-[var(--color-surface-muted)]
                               px-2.5 py-1 text-sm font-medium"
                    >
                        {{ $department->code }}
                    </span>
                </p>
            </div>

            {{-- College --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('College') }}
                </p>

                @if ($department->college)
                    <a
                        href="{{ route('colleges.show', $department->college) }}"
                        class="mt-1 inline-block font-medium
                               text-[var(--color-primary)]
                               transition hover:underline"
                    >
                        {{ $department->college->name }}
                    </a>

                    @if ($department->college->code)
                        <p class="mt-0.5 text-sm text-[var(--color-foreground-muted)]">
                            {{ $department->college->code }}
                        </p>
                    @endif
                @else
                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('No college assigned.') }}
                    </p>
                @endif
            </div>

            {{-- Courses Count --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Courses') }}
                </p>

                <p class="mt-1 font-medium">
                    {{ $department->courses->count() }}
                </p>
            </div>

        </div>
    </div>

    {{-- Courses --}}
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
                    {{ __('Courses') }}
                </h2>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Courses belonging to this department.') }}
                </p>
            </div>

            <span
                class="rounded-full bg-[var(--color-surface-muted)]
                       px-3 py-1 text-sm font-medium"
            >
                {{ $department->courses->count() }}
            </span>
        </div>

        @if ($department->courses->isNotEmpty())
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
                                {{ __('Code') }}
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider
                                       text-[var(--color-foreground-muted)]"
                            >
                                {{ __('Credits') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[var(--color-border)]">
                        @foreach ($department->courses as $course)
                            <tr class="transition hover:bg-[var(--color-surface-muted)]">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    {{ $course->id }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium">
                                        {{ $course->name }}
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-md
                                               bg-[var(--color-surface-muted)]
                                               px-2.5 py-1 text-xs font-medium"
                                    >
                                        {{ $course->code }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $course->credits ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium">
                    {{ __('No courses found.') }}
                </p>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('This department does not have any courses yet.') }}
                </p>
            </div>
        @endif
    </div>

</div>


@endsection
