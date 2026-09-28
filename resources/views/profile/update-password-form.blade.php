
<x-form-section submit="updatePassword">

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
                        d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25v-6A2.25 2.25 0 0 1 6.75 10.5Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                    {{ __('Update Password') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <p class="text-sm leading-6 text-[var(--color-foreground-muted)]">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </x-slot>

    <x-slot name="form">

        {{-- Current Password --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label
                for="current_password"
                value="{{ __('Current Password') }}"
                class="text-[var(--color-foreground)]"
            />

            <x-input
                id="current_password"
                type="password"
                class="mt-2 block w-full border-[var(--color-border)] bg-[var(--color-surface)] text-[var(--color-foreground)] focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                wire:model="state.current_password"
                autocomplete="current-password"
            />

            <x-input-error
                for="current_password"
                class="mt-2"
            />
        </div>

        {{-- New Password --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label
                for="password"
                value="{{ __('New Password') }}"
                class="text-[var(--color-foreground)]"
            />

            <x-input
                id="password"
                type="password"
                class="mt-2 block w-full border-[var(--color-border)] bg-[var(--color-surface)] text-[var(--color-foreground)] focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                wire:model="state.password"
                autocomplete="new-password"
            />

            <x-input-error
                for="password"
                class="mt-2"
            />
        </div>

        {{-- Confirm Password --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label
                for="password_confirmation"
                value="{{ __('Confirm Password') }}"
                class="text-[var(--color-foreground)]"
            />

            <x-input
                id="password_confirmation"
                type="password"
                class="mt-2 block w-full border-[var(--color-border)] bg-[var(--color-surface)] text-[var(--color-foreground)] focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                wire:model="state.password_confirmation"
                autocomplete="new-password"
            />

            <x-input-error
                for="password_confirmation"
                class="mt-2"
            />
        </div>

    </x-slot>

    <x-slot name="actions">
        <div class="flex w-full items-center justify-end gap-3">

            <x-action-message
                class="text-sm text-[var(--color-success)]"
                on="saved"
            >
                {{ __('Saved.') }}
            </x-action-message>

            <x-button
                class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)]"
            >
                {{ __('Update Password') }}
            </x-button>

        </div>
    </x-slot>

</x-form-section>
