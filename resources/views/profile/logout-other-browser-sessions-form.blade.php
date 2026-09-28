<x-action-section>
    <x-slot name="title">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[var(--color-primary)] dark:bg-blue-950/40">
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M9.75 3.75h4.5A2.25 2.25 0 0116.5 6v12a2.25 2.25 0 01-2.25 2.25h-4.5A2.25 2.25 0 017.5 18V6a2.25 2.25 0 012.25-2.25zM9.75 6h4.5M11 17.25h2"
                    />
                </svg>
            </div>

            <div>
                <h3 class="text-base font-semibold text-[var(--color-foreground)]">
                    {{ __('Browser Sessions') }}
                </h3>

                <p class="mt-0.5 text-xs font-normal text-[var(--color-foreground-muted)]">
                    {{ __('Manage your active sessions and devices.') }}
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <span class="text-[var(--color-foreground-muted)]">
            {{ __('Manage and log out your active sessions on other browsers and devices.') }}
        </span>
    </x-slot>

    <x-slot name="content">
        <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 shrink-0 text-[var(--color-primary)]">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 9v3.75m0 3h.008v.008H12V15.75zM4.5 19.5h15a1.5 1.5 0 001.3-2.25l-7.5-13a1.5 1.5 0 00-2.6 0l-7.5 13a1.5 1.5 0 001.3 2.25z"
                        />
                    </svg>
                </div>

                <p class="text-sm leading-6 text-[var(--color-foreground-muted)]">
                    {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
                </p>
            </div>
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-3">
                @foreach ($this->sessions as $session)
                    <div
                        class="flex items-center gap-4 rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4 transition-colors"
                    >
                        {{-- Device Icon --}}
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[var(--color-surface-muted)] text-[var(--color-foreground-muted)]">
                            @if ($session->agent->isDesktop())
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.6"
                                        d="M3 5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25v9A2.25 2.25 0 0118.75 16.5H5.25A2.25 2.25 0 013 14.25v-9z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.6"
                                        d="M8.25 21h7.5M12 16.5V21"
                                    />
                                </svg>
                            @else
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.6"
                                        d="M8.25 2.25h7.5A2.25 2.25 0 0118 4.5v15a2.25 2.25 0 01-2.25 2.25h-7.5A2.25 2.25 0 016 19.5v-15a2.25 2.25 0 012.25-2.25z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.6"
                                        d="M10.5 18.75h3"
                                    />
                                </svg>
                            @endif
                        </div>

                        {{-- Session Information --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                <span class="text-sm font-semibold text-[var(--color-foreground)]">
                                    {{ $session->agent->platform() ?: __('Unknown') }}
                                </span>

                                <span class="text-[var(--color-foreground-muted)]">
                                    •
                                </span>

                                <span class="text-sm text-[var(--color-foreground-muted)]">
                                    {{ $session->agent->browser() ?: __('Unknown') }}
                                </span>

                                @if ($session->is_current_device)
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-950/40 dark:text-green-400">
                                        {{ __('This device') }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-[var(--color-foreground-muted)]">
                                <span>
                                    {{ $session->ip_address }}
                                </span>

                                @if (! $session->is_current_device)
                                    <span>•</span>
                                    <span>
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-5 rounded-lg border border-dashed border-[var(--color-border)] p-6 text-center">
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    {{ __('No active browser sessions found.') }}
                </p>
            </div>
        @endif

        {{-- Logout Other Sessions --}}
        <div class="mt-6 flex flex-wrap items-center gap-3">
            <x-button
                wire:click="confirmLogout"
                wire:loading.attr="disabled"
            >
                <span class="flex items-center gap-2">
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M9.75 12h9m0 0l-3-3m3 3l-3 3"
                        />
                    </svg>

                    <span>{{ __('Log Out Other Browser Sessions') }}</span>
                </span>
            </x-button>

            <x-action-message
                class="text-sm text-[var(--color-success)]"
                on="loggedOut"
            >
                {{ __('Done.') }}
            </x-action-message>
        </div>

        <!-- Log Out Other Devices Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[var(--color-primary)] dark:bg-blue-950/40">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9.75 12h9m0 0l-3-3m3 3l-3 3"
                            />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-[var(--color-foreground)]">
                            {{ __('Log Out Other Browser Sessions') }}
                        </h3>

                        <p class="mt-0.5 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Confirm this security action.') }}
                        </p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <p class="text-sm leading-6 text-[var(--color-foreground-muted)]">
                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}
                </p>

                <div
                    class="mt-5"
                    x-data="{}"
                    x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)"
                >
                    <label
                        for="logout-sessions-password"
                        class="block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        {{ __('Password') }}
                    </label>

                    <x-input
                        id="logout-sessions-password"
                        type="password"
                        class="mt-2 block w-full"
                        autocomplete="current-password"
                        placeholder="{{ __('Password') }}"
                        x-ref="password"
                        wire:model="password"
                        wire:keydown.enter="logoutOtherBrowserSessions"
                    />

                    <x-input-error
                        for="password"
                        class="mt-2"
                    />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button
                    wire:click="$toggle('confirmingLogout')"
                    wire:loading.attr="disabled"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-button
                    class="ms-3"
                    wire:click="logoutOtherBrowserSessions"
                    wire:loading.attr="disabled"
                >
                    {{ __('Log Out Other Browser Sessions') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
