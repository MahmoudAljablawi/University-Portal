
<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-[var(--color-background)] px-4 py-10 text-[var(--color-foreground)] sm:px-6">

        <div class="w-full max-w-md">

            {{-- Brand --}}
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[var(--color-primary)] text-white shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="5" y="3" width="14" height="18" rx="2"/>
                        <path stroke-linecap="round" d="M9 7h6M9 11h6M9 15h2"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight">
                    {{ __('Two-factor authentication') }}
                </h1>

                <p
                    id="two-factor-description"
                    class="mt-2 text-sm leading-6 text-[var(--color-foreground-muted)]"
                >
                    {{ __('Enter the authentication code from your authenticator application.') }}
                </p>
            </div>


            {{-- Card --}}
            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm sm:p-8">

                <x-validation-errors
                    class="mb-6 rounded-xl border border-[var(--color-danger)]/20 bg-[var(--color-danger)]/10 p-4 text-xs leading-5 text-[var(--color-danger)]"
                />

                <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5">
                    @csrf

                    {{-- Authentication Code --}}
                    <div id="authentication-code-section">
                        <x-label
                            for="code"
                            value="{{ __('Authentication code') }}"
                            class="mb-2 block text-sm font-medium"
                        />

                        <x-input
                            id="code"
                            type="text"
                            name="code"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            autofocus
                            placeholder="000000"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-center text-lg tracking-[0.35em] text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>


                    {{-- Recovery Code --}}
                    <div id="recovery-code-section" class="hidden">
                        <x-label
                            for="recovery_code"
                            value="{{ __('Recovery code') }}"
                            class="mb-2 block text-sm font-medium"
                        />

                        <x-input
                            id="recovery_code"
                            type="text"
                            name="recovery_code"
                            autocomplete="one-time-code"
                            placeholder="{{ __('Enter your recovery code') }}"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-1 focus:ring-[var(--color-primary)]"
                        />
                    </div>


                    {{-- Submit --}}
                    <x-button
                        class="w-full justify-center rounded-xl border-0 bg-[var(--color-primary)] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--color-primary-hover)] focus:outline-none focus:ring-1 focus:ring-[var(--color-primary)]"
                    >
                        {{ __('Verify and continue') }}
                    </x-button>


                    {{-- Toggle --}}
                    <div class="border-t border-[var(--color-border)] pt-5 text-center">

                        <button
                            type="button"
                            id="toggle-two-factor"
                            class="text-sm font-medium text-[var(--color-primary)] transition hover:text-[var(--color-primary-hover)]"
                        >
                            {{ __('Use a recovery code instead') }}
                        </button>

                    </div>

                </form>

            </div>

            <p class="mt-6 text-center text-xs text-[var(--color-foreground-muted)]">
                {{ __('University Portal') }}
            </p>

        </div>
    </div>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const codeSection = document.getElementById('authentication-code-section');
                const recoverySection = document.getElementById('recovery-code-section');
                const toggleButton = document.getElementById('toggle-two-factor');
                const description = document.getElementById('two-factor-description');
                const codeInput = document.getElementById('code');
                const recoveryInput = document.getElementById('recovery_code');

                let recoveryMode = false;

                toggleButton.addEventListener('click', () => {
                    recoveryMode = !recoveryMode;

                    codeSection.classList.toggle('hidden', recoveryMode);
                    recoverySection.classList.toggle('hidden', !recoveryMode);

                    codeInput.disabled = recoveryMode;
                    recoveryInput.disabled = !recoveryMode;

                    if (recoveryMode) {
                        description.textContent =
                            '{{ __("Enter one of your recovery codes to continue.") }}';

                        toggleButton.textContent =
                            '{{ __("Use an authentication code instead") }}';

                        recoveryInput.focus();
                    } else {
                        description.textContent =
                            '{{ __("Enter the authentication code from your authenticator application.") }}';

                        toggleButton.textContent =
                            '{{ __("Use a recovery code instead") }}';

                        codeInput.focus();
                    }
                });
            });
        </script>
    @endpush

</x-guest-layout>
