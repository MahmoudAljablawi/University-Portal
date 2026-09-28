
<x-form-section submit="updateProfileInformation">

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
                        d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                    {{ __('Profile Information') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <p class="text-sm leading-6 text-[var(--color-foreground-muted)]">
            {{ __('Update your account\'s profile information and email address.') }}
        </p>
    </x-slot>

    <x-slot name="form">

        {{-- Profile Photo --}}
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div
                x-data="{ photoName: null, photoPreview: null }"
                class="col-span-6"
            >
                <input
                    type="file"
                    id="photo"
                    class="hidden"
                    wire:model.live="photo"
                    x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    "
                />

                <x-label
                    for="photo"
                    value="{{ __('Profile Photo') }}"
                    class="text-[var(--color-foreground)]"
                />

                <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center">

                    {{-- Current Photo --}}
                    <div x-show="! photoPreview">
                        <img
                            src="{{ $this->user->profile_photo_url }}"
                            alt="{{ $this->user->name }}"
                            class="h-20 w-20 rounded-full object-cover ring-2 ring-[var(--color-border)]"
                        >
                    </div>

                    {{-- New Photo Preview --}}
                    <div
                        x-show="photoPreview"
                        style="display: none;"
                    >
                        <span
                            class="block h-20 w-20 rounded-full bg-cover bg-center bg-no-repeat ring-2 ring-[var(--color-border)]"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'"
                        ></span>
                    </div>

                    <div class="flex flex-wrap gap-2">

                        <button
                            type="button"
                            x-on:click.prevent="$refs.photo.click()"
                            class="inline-flex items-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                        >
                            {{ __('Select A New Photo') }}
                        </button>

                        @if ($this->user->profile_photo_path)
                            <button
                                type="button"
                                wire:click="deleteProfilePhoto"
                                class="inline-flex items-center rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium text-[var(--color-danger)] transition hover:bg-[var(--color-danger)]/10"
                            >
                                {{ __('Remove Photo') }}
                            </button>
                        @endif

                    </div>
                </div>

                <x-input-error
                    for="photo"
                    class="mt-2"
                />
            </div>
        @endif

        {{-- Name --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label
                for="name"
                value="{{ __('Name') }}"
                class="text-[var(--color-foreground)]"
            />

            <x-input
                id="name"
                type="text"
                class="mt-2 block w-full border-[var(--color-border)] bg-[var(--color-surface)] text-[var(--color-foreground)] focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                wire:model="state.name"
                required
                autocomplete="name"
            />

            <x-input-error
                for="name"
                class="mt-2"
            />
        </div>

        {{-- Email --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label
                for="email"
                value="{{ __('Email') }}"
                class="text-[var(--color-foreground)]"
            />

            <x-input
                id="email"
                type="email"
                class="mt-2 block w-full border-[var(--color-border)] bg-[var(--color-surface)] text-[var(--color-foreground)] focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]"
                wire:model="state.email"
                required
                autocomplete="username"
            />

            <x-input-error
                for="email"
                class="mt-2"
            />

            @if (
                Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification())
                && ! $this->user->hasVerifiedEmail()
            )
                <div class="mt-3 rounded-lg border border-[var(--color-warning)]/30 bg-[var(--color-warning)]/10 p-3">
                    <p class="text-sm text-[var(--color-foreground)]">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button
                        type="button"
                        class="mt-1 text-sm font-medium text-[var(--color-primary)] underline underline-offset-2 transition hover:text-[var(--color-primary-hover)]"
                        wire:click.prevent="sendEmailVerification"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>

                @if ($this->verificationLinkSent)
                    <div class="mt-3 rounded-lg border border-[var(--color-success)]/30 bg-[var(--color-success)]/10 p-3">
                        <p class="text-sm font-medium text-[var(--color-success)]">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    </div>
                @endif
            @endif
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
                wire:loading.attr="disabled"
                wire:target="photo"
                class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)]"
            >
                {{ __('Save Changes') }}
            </x-button>

        </div>
    </x-slot>

</x-form-section>

