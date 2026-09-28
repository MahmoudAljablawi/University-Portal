
<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-[var(--color-background)] px-4 py-10 text-[var(--color-foreground)] sm:px-6">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[var(--color-primary)] text-white shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a4 4 0 1 0-6 3.46V13l-2 2 2 2 2-2h2.54A4 4 0 0 0 15 7Z"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight">
                    {{ __('Forgot your password?') }}
                </h1>

                <p class="mt-2 text-sm leading-6 text-[var(--color-foreground-muted)]">
                    {{ __('Enter your email address and we will send you a password reset link.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm sm:p-8">

                <x-validation-errors class="mb-6 rounded-xl border border-[var(--color-danger)]/20 bg-[var(--color-danger)]/10 p-4 text-xs text-[var(--color-danger)]" />

                @session('status')
                    <div class="mb-6 rounded-xl border border-[var(--color-success)]/20 bg-[var(--color-success)]/10 p-4 text-xs text-[var(--color-success)]">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="mb-2 block text-sm font-medium" />

                        <x-input
                            id="email"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="name@example.com"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>

                    <x-button
                        class="w-full justify-center rounded-xl border-0 bg-[var(--color-primary)] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--color-primary-hover)] focus:outline-none focus:ring-1 focus:ring-[var(--color-primary)]"
                    >
                        {{ __('Send password reset link') }}
                    </x-button>
                </form>

                <div class="mt-6 border-t border-[var(--color-border)] pt-5 text-center">
                    <a
                        href="{{ route('login') }}"
                        class="text-sm font-semibold text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]"
                    >
                        {{ __('Back to login') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>


