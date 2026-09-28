
@extends('layouts.app')

@section('title', __('Profile'))

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Page Header --}}
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                {{ __('Profile') }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Manage your account information, security, and active sessions.') }}
            </p>
        </div>

        {{-- Profile Information --}}
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
                @livewire('profile.update-profile-information-form')
            </div>
        @endif

        {{-- Password --}}
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
                @livewire('profile.update-password-form')
            </div>
        @endif

        {{-- Two Factor Authentication --}}
        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
                @livewire('profile.two-factor-authentication-form')
            </div>
        @endif

        {{-- Browser Sessions --}}
        <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        {{-- Delete Account --}}
        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
                @livewire('profile.delete-user-form')
            </div>
        @endif

    </div>
@endsection
