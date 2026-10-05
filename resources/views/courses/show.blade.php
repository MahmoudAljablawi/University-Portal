
@extends('layouts.app')

@section('title', $course->name)

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold">
                        {{ $course->name }}
                    </h1>

                    <span class="rounded-full bg-[var(--color-sidebar-active)] px-3 py-1 text-sm font-medium text-[var(--color-primary)]">
                        {{ $course->code }}
                    </span>
                </div>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Course details and academic information.') }}
                </p>
            </div>

            <div class="flex gap-2">
                <a
                    href="{{ route('courses.index') }}"
                    class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium transition hover:bg-[var(--color-surface-muted)]"
                >
                    {{ __('Back') }}
                </a>

                @if (auth()->user()->role === 'admin')
                    <a
                        href="{{ route('courses.edit', $course) }}"
                        class="rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        {{ __('Edit') }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Course Information --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">
                <h2 class="mb-5 text-lg font-semibold">
                    {{ __('Course Information') }}
                </h2>

                <dl class="space-y-4">

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Course Name') }}
                        </dt>
                        <dd class="text-sm font-medium">
                            {{ $course->name }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Code') }}
                        </dt>
                        <dd class="text-sm font-medium">
                            {{ $course->code }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Credits') }}
                        </dt>
                        <dd class="text-sm font-medium">
                            {{ $course->credits }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Department') }}
                        </dt>
                        <dd class="text-sm font-medium">
                            {{ $course->department?->name ?? '—' }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Sections') }}
                        </dt>
                        <dd class="text-sm font-medium">
                            {{ $course->sections->count() }}
                        </dd>
                    </div>

                </dl>
            </div>

            {{-- Description --}}
            <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">
                <h2 class="mb-5 text-lg font-semibold">
                    {{ __('Description') }}
                </h2>

                @if ($course->description)
                    <p class="whitespace-pre-line text-sm leading-7 text-[var(--color-foreground-muted)]">
                        {{ $course->description }}
                    </p>
                @else
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        {{ __('No description available.') }}
                    </p>
                @endif
            </div>

        </div>

        {{-- Prerequisites --}}
        <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">

            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold">
                        {{ __('Prerequisites') }}
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Courses that should be completed before taking this course.') }}
                    </p>
                </div>
            </div>

            {{-- Add prerequisite --}}
            @if (auth()->user()->role === 'admin')
                <form
                    action="{{ url('courses/' . $course->id . '/prerequisites') }}"
                    method="POST"
                    class="mb-6 flex flex-col gap-3 sm:flex-row"
                >
                    @csrf

                    <select
                        name="prerequisite_id"
                        required
                        class="flex-1 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm outline-none focus:border-[var(--color-primary)]"
                    >
                        <option value="">{{ __('Select prerequisite course') }}</option>

                        @foreach ($allCourses as $availableCourse)
                            @if (!$course->prerequisites->contains('id', $availableCourse->id))
                                <option value="{{ $availableCourse->id }}">
                                    {{ $availableCourse->code }} — {{ $availableCourse->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        {{ __('Add Prerequisite') }}
                    </button>
                </form>
            @endif

            {{-- Prerequisites List --}}
            @if ($course->prerequisites->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[var(--color-border)]">
                        <thead class="bg-[var(--color-surface-muted)]">
                            <tr>
                                <th class="px-5 py-3 text-start text-xs font-semibold uppercase tracking-wider">
                                    {{ __('Code') }}
                                </th>

                                <th class="px-5 py-3 text-start text-xs font-semibold uppercase tracking-wider">
                                    {{ __('Course') }}
                                </th>

                                @if (auth()->user()->role === 'admin')
                                    <th class="px-5 py-3 text-end text-xs font-semibold uppercase tracking-wider">
                                        {{ __('Action') }}
                                    </th>
                                @endif
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[var(--color-border)]">
                            @foreach ($course->prerequisites as $prerequisite)
                                <tr>
                                    <td class="px-5 py-3 text-sm font-medium">
                                        {{ $prerequisite->code }}
                                    </td>

                                    <td class="px-5 py-3 text-sm">
                                        {{ $prerequisite->name }}
                                    </td>

                                    @if (auth()->user()->role === 'admin')
                                        <td class="px-5 py-3 text-end">
                                            <form
                                                action="{{ url('courses/' . $course->id . '/prerequisites') }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to remove this prerequisite?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <input
                                                    type="hidden"
                                                    name="prerequisite_id"
                                                    value="{{ $prerequisite->id }}"
                                                >

                                                <button
                                                    type="submit"
                                                    class="text-sm font-medium text-[var(--color-danger)] hover:underline"
                                                >
                                                    {{ __('Remove') }}
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-lg bg-[var(--color-surface-muted)] px-5 py-8 text-center">
                    <p class="text-sm text-[var(--color-foreground-muted)]">
                        {{ __('No prerequisites have been added.') }}
                    </p>
                </div>
            @endif

        </div>

    </div>
@endsection


