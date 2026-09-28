@extends('layouts.app')

@section('title', 'Courses')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold">
                Courses
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Manage university courses and their academic information.
            </p>
        </div>

        @if (auth()->user()->role === 'admin')
        <a
            href="{{ route('courses.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
            + Add Course
        </a>
        @endif
    </div>

    {{-- Courses Table --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">
                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>
                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            #
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Code
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Course Name
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Department
                        </th>

                        <th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider">
                            Credits
                        </th>

                        <th class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse ($courses as $course)
                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $course->id }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                            {{ $course->code }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $course->name }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $course->department?->name ?? '—' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            {{ $course->credits }}
                        </td>

                        <x-table-actions
                            :model="$course"
                            :itemName="$course->name"
                            showRoute="courses.show"
                            editRoute="courses.edit"
                            destroyRoute="courses.destroy"
                            :showEdit="auth()->user()->role === 'admin'"
                            :showDelete="auth()->user()->role === 'admin'"
                            deleteConfirm="Are you sure you want to delete this course?" />
                    </tr>
                    @empty
                    <tr>
                        <td
                            colspan="6"
                            class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]">
                            No courses found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection