
<x-action-section>

    <x-slot name="title">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[var(--color-sidebar-active)] text-[var(--color-primary)]">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75m6 2.25c0 5.25-3.75 8.25-9 10.5C7.75 20.25 4 17.25 4 12V5.25L12 2.25l8 3V12Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                    {{ __('Two Factor Authentication') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <p class="text-sm leading-6 text-[var(--color-foreground-muted)]">
            {{ __('Add additional security to your account using two factor authentication.') }}
        </p>
    </x-slot>

    <x-slot name="content">

        {{-- Status --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-base font-semibold text-[var(--color-foreground)]">
                    @if ($this->enabled)
                        @if ($showingConfirmation)
                            {{ __('Finish enabling two factor authentication.') }}
                        @else
                            {{ __('You have enabled two factor authentication.') }}
                        @endif
                    @else
                        {{ __('You have not enabled two factor authentication.') }}
                    @endif
                </h3>

                <div class="mt-2">
                    @if ($this->enabled)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[var(--color-success)]/10 px-3 py-1 text-xs font-semibold text-[var(--color-success)]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-success)]"></span>
                            {{ __('Enabled') }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[var(--color-warning)]/10 px-3 py-1 text-xs font-semibold text-[var(--color-warning)]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-warning)]"></span>
                            {{ __('Not Enabled') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="mt-4 max-w-3xl text-sm leading-6 text-[var(--color-foreground-muted)]">
            <p>
                {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
            </p>
        </div>

        {{-- QR Code / Setup --}}
        @if ($this->enabled && $showingQrCode)

            <div class="mt-6 rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-5">

                <div class="max-w-2xl">
                    <h4 class="text-sm font-semibold text-[var(--color-foreground)]">
                        @if ($showingConfirmation)
                            {{ __('Finish setting up two factor authentication') }}
                        @else
                            {{ __('Two factor authentication setup') }}
                        @endif
                    </h4>

                    <p class="mt-2 text-sm leading-6 text-[var(--color-foreground-muted)]">
                        @if ($showingConfirmation)
                            {{ __('To finish enabling two factor authentication, scan the QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                        @else
                            {{ __('Two factor authentication is now enabled. Scan the QR code using your phone\'s authenticator application or enter the setup key.') }}
                        @endif
                    </p>
                </div>

                {{-- QR Code --}}
                <div class="mt-5">
                    <div class="inline-flex rounded-xl border border-[var(--color-border)] bg-white p-4 shadow-sm">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>
                </div>

                {{-- Setup Key --}}
                <div class="mt-5">
                    <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                        {{ __('Setup Key') }}
                    </p>

                    <div class="mt-2 overflow-x-auto rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-3">
                        <code class="font-mono text-sm text-[var(--color-foreground)]">
                            {{ decrypt($this->user->two_factor_secret) }}
                        </code>
                    </div>
                </div>

                {{-- Confirmation Code --}}
                @if ($showingConfirmation)
                    <div class="mt-5 max-w-md">
                        <x-label
                            for="code"
                            value="{{ __('Authentication Code') }}"
                            class="text-[var(--color-foreground)]"
                        />

                        <x-input
                            id="code"
                            type="text"
                            name="code"
                            class="mt-2 block w-full border-[var(--color-border)] bg-[var(--color-surface)] text-[var(--color-foreground)] focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                            inputmode="numeric"
                            autofocus
                            autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication"
                        />

                        <x-input-error
                            for="code"
                            class="mt-2"
                        />
                    </div>
                @endif

            </div>

        @endif

        {{-- Recovery Codes --}}
        @if ($showingRecoveryCodes)

            <div class="mt-6 rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-5">

                <h4 class="text-sm font-semibold text-[var(--color-foreground)]">
                    {{ __('Recovery Codes') }}
                </h4>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[var(--color-foreground-muted)]">
                    {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                </p>

                <div class="mt-4 grid gap-2 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] p-4 sm:grid-cols-2">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div class="rounded-md bg-[var(--color-surface-muted)] px-3 py-2 font-mono text-sm text-[var(--color-foreground)]">
                            {{ $code }}
                        </div>
                    @endforeach
                </div>

            </div>

        @endif

        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap items-center gap-3">

            @if (! $this->enabled)

                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button
                        type="button"
                        wire:loading.attr="disabled"
                        class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)]"
                    >
                        {{ __('Enable Two-Factor Authentication') }}
                    </x-button>
                </x-confirms-password>

            @else

                @if ($showingRecoveryCodes)

                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button>
                            {{ __('Regenerate Recovery Codes') }}
                        </x-secondary-button>
                    </x-confirms-password>

                @elseif ($showingConfirmation)

                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button
                            type="button"
                            class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)]"
                            wire:loading.attr="disabled"
                        >
                            {{ __('Confirm') }}
                        </x-button>
                    </x-confirms-password>

                @else

                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button>
                            {{ __('Show Recovery Codes') }}
                        </x-secondary-button>
                    </x-confirms-password>

                @endif

                @if ($showingConfirmation)

                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </x-confirms-password>

                @else

                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            {{ __('Disable Two-Factor Authentication') }}
                        </x-danger-button>
                    </x-confirms-password>

                @endif

            @endif

        </div>

    </x-slot>

</x-action-section>
