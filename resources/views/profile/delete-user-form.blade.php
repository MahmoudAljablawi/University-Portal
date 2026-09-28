<x-action-section>
    <x-slot name="title">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400">
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
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                    />
                </svg>
            </div>

            <div>
                <h3 class="text-base font-semibold text-[var(--color-foreground)]">
                    {{ __('Delete Account') }}
                </h3>

                <p class="mt-0.5 text-xs font-normal text-[var(--color-foreground-muted)]">
                    {{ __('Permanently delete your account.') }}
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <span class="text-[var(--color-foreground-muted)]">
            {{ __('Permanently delete your account and all associated data. This action cannot be undone.') }}
        </span>
    </x-slot>

    <x-slot name="content">
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/60 dark:bg-red-950/20">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 shrink-0 text-red-600 dark:text-red-400">
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
                            d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.84 21h16.32a2 2 0 001.73-3.14l-8.18-14a2 2 0 00-3.42 0z"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                        {{ __('This action is permanent') }}
                    </p>

                    <p class="mt-1 text-sm leading-6 text-red-700 dark:text-red-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <x-danger-button
                wire:click="confirmUserDeletion"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                        />
                    </svg>

                    <span>{{ __('Delete Account') }}</span>
                </span>
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400">
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
                                d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.84 21h16.32a2 2 0 001.73-3.14l-8.18-14a2 2 0 00-3.42 0z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-[var(--color-foreground)]">
                            {{ __('Delete Account') }}
                        </h3>

                        <p class="mt-0.5 text-sm text-[var(--color-foreground-muted)]">
                            {{ __('This action cannot be undone.') }}
                        </p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <p class="text-sm leading-6 text-[var(--color-foreground-muted)]">
                    {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div
                    class="mt-5"
                    x-data="{}"
                    x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)"
                >
                    <label
                        for="delete-account-password"
                        class="block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        {{ __('Password') }}
                    </label>

                    <x-input
                        id="delete-account-password"
                        type="password"
                        class="mt-2 block w-full"
                        autocomplete="current-password"
                        placeholder="{{ __('Password') }}"
                        x-ref="password"
                        wire:model="password"
                        wire:keydown.enter="deleteUser"
                    />

                    <x-input-error
                        for="password"
                        class="mt-2"
                    />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button
                    wire:click="$toggle('confirmingUserDeletion')"
                    wire:loading.attr="disabled"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button
                    class="ms-3"
                    wire:click="deleteUser"
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
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                            />
                        </svg>

                        <span>{{ __('Delete Account') }}</span>
                    </span>
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
