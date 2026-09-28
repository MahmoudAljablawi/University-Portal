
<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-[var(--color-background)] px-4 py-10 text-[var(--color-foreground)] sm:px-6">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[var(--color-primary)] text-white shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="10" width="16" height="10" rx="2"/>
                        <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight">
                    {{ __('Confirm your password') }}
                </h1>

                <p class="mt-2 text-sm leading-6 text-[var(--color-foreground-muted)]">
                    {{ __('For your security, please confirm your password before continuing.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm sm:p-8">

                <x-validation-errors class="mb-6 rounded-xl border border-[var(--color-danger)]/20 bg-[var(--color-danger)]/10 p-4 text-xs text-[var(--color-danger)]" />

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" class="mb-2 block text-sm font-medium" />

                        <x-input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            autofocus
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>

                    <x-button
                        class="w-full justify-center rounded-xl border-0 bg-[var(--color-primary)] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--color-primary-hover)] focus:outline-none focus:ring-1 focus:ring-[var(--color-primary)]"
                    >
                        {{ __('Confirm password') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>
