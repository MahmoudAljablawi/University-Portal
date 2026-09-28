

<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-[var(--color-background)] px-4 py-10 text-[var(--color-foreground)] sm:px-6">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[var(--color-primary)] text-white shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 8V6a4 4 0 0 1 8 0v2"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight">
                    {{ __('Reset your password') }}
                </h1>

                <p class="mt-2 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Choose a new password for your account.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm sm:p-8">

                <x-validation-errors class="mb-6 rounded-xl border border-[var(--color-danger)]/20 bg-[var(--color-danger)]/10 p-4 text-xs text-[var(--color-danger)]" />

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="mb-2 block text-sm font-medium" />

                        <x-input
                            id="email"
                            type="email"
                            name="email"
                            :value="old('email', $request->email)"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('New Password') }}" class="mb-2 block text-sm font-medium" />

                        <x-input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>

                    <div>
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="mb-2 block text-sm font-medium" />

                        <x-input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>

                    <x-button
                        class="w-full justify-center rounded-xl border-0 bg-[var(--color-primary)] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--color-primary-hover)] focus:outline-none focus:ring-1 focus:ring-[var(--color-primary)]"
                    >
                        {{ __('Reset password') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>

