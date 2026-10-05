@extends('layouts.app')

@section('title', __('User Details'))

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div>
        <a
            href="{{ route('users.index') }}"
            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:text-[var(--color-primary)]">
            <svg
                class="h-4 w-4 rtl:rotate-180"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path d="M19 12H5" />
                <path d="M12 19l-7-7 7-7" />
            </svg>

            {{ __('Back to Users') }}
        </a>

        <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
            {{ __('User Details') }}
        </h2>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('View account information and status.') }}
        </p>
    </div>

    {{-- User Profile Card --}}
    <div
        class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        {{-- Profile Header --}}
        <div class="border-b border-[var(--color-border)] px-6 py-6 sm:px-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                <div
                    class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[var(--color-primary)] text-xl font-semibold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div class="min-w-0">

                    <h3 class="text-xl font-semibold text-[var(--color-foreground)]">
                        {{ $user->name }}
                    </h3>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        {{ $user->email }}
                    </p>

                </div>

                <div class="sm:ms-auto">

                    @if ($user->is_active)

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-success)_12%,transparent)] px-3 py-1.5 text-xs font-medium text-[var(--color-success)]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-success)]"></span>
                        {{ __('Active') }}
                    </span>

                    @else

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-[color-mix(in_srgb,var(--color-danger)_12%,transparent)] px-3 py-1.5 text-xs font-medium text-[var(--color-danger)]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-danger)]"></span>
                        {{ __('Inactive') }}
                    </span>

                    @endif

                </div>

            </div>

        </div>

        {{-- User Information --}}
        <div class="grid gap-6 px-6 py-6 sm:grid-cols-2 sm:px-8">

            {{-- User ID --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('User ID') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    #{{ $user->id }}
                </p>
            </div>

            {{-- Full Name --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Full Name') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $user->name }}
                </p>
            </div>

            {{-- Email --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Email Address') }}
                </p>

                <p class="mt-1 break-all text-sm font-medium text-[var(--color-foreground)]">
                    {{ $user->email }}
                </p>
            </div>

            {{-- Phone --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Phone') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $user->phone ?? '—' }}
                </p>
            </div>

            {{-- Role --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Role') }}
                </p>

                @php
                $roleLabels = [
                'admin' => __('Administrator'),
                'instructor' => __('Instructor'),
                'student' => __('Student'),
                'employee' => __('Employee'),
                ];

                $roleLabel = $roleLabels[$user->role]
                ?? __(ucfirst($user->role));
                @endphp

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $roleLabel }}
                </p>
            </div>

            {{-- College --}}
            @if ($user->role === 'employee')
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('College') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $user->college?->name ?? '—' }}
                </p>
            </div>
            @endif

            {{-- Account Status --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    {{ __('Account Status') }}
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ __($user->is_active ? 'Active' : 'Inactive') }}
                </p>
            </div>

        </div>

        {{-- Actions --}}
        <div
            class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] px-6 py-5 sm:flex-row sm:justify-end sm:px-8">

            <a
                href="{{ route('users.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]">
                {{ __('Back') }}
            </a>

            <a
                href="{{ route('users.edit', $user) }}"
                class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
                {{ __('Edit User') }}
            </a>

        </div>

    </div>

</div>

@endsection