{{-- =========================================================
   resources/views/auth/register.blade.php
   ========================================================= --}}

<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-[var(--color-background)] px-4 py-10 text-[var(--color-foreground)] transition-colors duration-200 sm:px-6">

        <div class="w-full max-w-md">

            {{-- Brand --}}
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[var(--color-primary)] text-white shadow-sm">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.5 12 4l9 5.5-9 5.5L3 9.5Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 11.5V16c3.5 2.5 8.5 2.5 12 0v-4.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 9.5V15"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    {{ __('Create your account') }}
                </h1>

                <p class="mt-2 text-sm text-[var(--color-foreground-muted)]">
                    {{ __('Create your University Portal account to get started.') }}
                </p>
            </div>


            {{-- Card --}}
            <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">

                <div class="p-6 sm:p-8">

                    <x-validation-errors
                        class="mb-6 rounded-xl border border-[var(--color-danger)]/20 bg-[var(--color-danger)]/10 p-4 text-xs leading-5 text-[var(--color-danger)]"
                    />

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <x-label
                                for="name"
                                value="{{ __('Name') }}"
                                class="mb-2 block text-sm font-medium"
                            />

                            <x-input
                                id="name"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="{{ __('Full name') }}"
                                class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                            />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-label
                                for="email"
                                value="{{ __('Email') }}"
                                class="mb-2 block text-sm font-medium"
                            />

                            <x-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username"
                                placeholder="name@example.com"
                                class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                            />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-label
                                for="password"
                                value="{{ __('Password') }}"
                                class="mb-2 block text-sm font-medium"
                            />

                            <x-input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                            />
                        </div>

                        {{-- Confirm --}}
                        <div>
                            <x-label
                                for="password_confirmation"
                                value="{{ __('Confirm Password') }}"
                                class="mb-2 block text-sm font-medium"
                            />

                            <x-input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                            />
                        </div>

                        {{-- Terms --}}
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div>
                                <x-label for="terms">
                                    <div class="flex items-start">
                                        <x-checkbox
                                            id="terms"
                                            name="terms"
                                            required
                                            class="mt-0.5 h-4 w-4 rounded border-[var(--color-border)] text-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                                        />

                                        <div class="ms-3 text-xs leading-5 text-[var(--color-foreground-muted)]">
                                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-medium text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-medium text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]">'.__('Privacy Policy').'</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif

                        {{-- Register --}}
                        <x-button
                            class="w-full justify-center rounded-xl border-0 bg-[var(--color-primary)] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--color-primary-hover)] focus:outline-none focus:ring-1 focus:ring-[var(--color-primary)]"
                        >
                            {{ __('Create account') }}
                        </x-button>

                    </form>
                </div>

                {{-- Login --}}
                <div class="border-t border-[var(--color-border)] bg-[var(--color-surface-muted)] px-6 py-5 text-center sm:px-8">
                    <span class="text-sm text-[var(--color-foreground-muted)]">
                        {{ __('Already have an account?') }}
                    </span>

                    <a
                        href="{{ route('login') }}"
                        class="ms-1 text-sm font-semibold text-[var(--color-primary)] transition hover:text-[var(--color-primary-hover)]"
                    >
                        {{ __('Log in') }}
                    </a>
                </div>

            </div>

            <p class="mt-6 text-center text-xs text-[var(--color-foreground-muted)]">
                {{ __('University Portal') }}
            </p>

        </div>
    </div>
</x-guest-layout>

