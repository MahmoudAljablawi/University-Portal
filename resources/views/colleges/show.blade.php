@extends('layouts.app')

@section('title', $college->name)

@section('content') <div class="mx-auto max-w-6xl space-y-6">


    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-foreground)]">
                {{ $college->name }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('College details and departments') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('colleges.index') }}"
                class="rounded-lg border border-[var(--color-border)] px-4 py-2 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
            >
                {{ __('Back') }}
            </a>

            @if(auth()->user()->role === 'admin')
                <a
                    href="{{ route('colleges.edit', $college) }}"
                    class="rounded-lg bg-[var(--color-primary)] px-4 py-2 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    {{ __('Edit College') }}
                </a>
            @endif
        </div>
    </div>

    {{-- College Information --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
            {{ __('College Information') }}
        </h2>

        <div class="mt-6 grid gap-6 sm:grid-cols-2">
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Name') }}
                </p>

                <p class="mt-1 font-medium text-[var(--color-foreground)]">
                    {{ $college->name }}
                </p>
            </div>

            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Code') }}
                </p>

                <p class="mt-1 font-medium text-[var(--color-foreground)]">
                    {{ $college->code }}
                </p>
            </div>

            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Departments') }}
                </p>

                <p class="mt-1 font-medium text-[var(--color-foreground)]">
                    {{ $college->departments->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- Departments --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
        <div class="border-b border-[var(--color-border)] px-6 py-4">
            <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                {{ __('Departments') }}
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Departments belonging to this college') }}
            </p>
        </div>

        @if($college->departments->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-border)]">
                    <thead class="bg-[var(--color-surface-muted)]">
                        <tr>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                {{ __('ID') }}
                            </th>

                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                {{ __('Name') }}
                            </th>

                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                {{ __('Code') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[var(--color-border)]">
                        @foreach($college->departments as $department)
                            <tr class="transition hover:bg-[var(--color-surface-muted)]">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    {{ $department->id }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-[var(--color-foreground)]">
                                    {{ $department->name }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    {{ $department->code }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('No departments found') }}
                </p>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('This college does not have any departments yet.') }}
                </p>
            </div>
        @endif
    </div>

</div>


@endsection
