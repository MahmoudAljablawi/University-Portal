<header
    class="sticky top-0 z-30 m-0 h-16 w-full self-start border-b border-[var(--color-border)] bg-[var(--color-surface)]/95 backdrop-blur"
>
    <div class="flex h-full items-center justify-between px-4 sm:px-6">

        {{-- =====================================================
             Left Side
        ====================================================== --}}

        <div class="flex items-center gap-3">

            {{-- Mobile Menu --}}
            <button
                type="button"
                data-sidebar-toggle
                class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-foreground)] lg:hidden"
                aria-label="{{ __('navigation.open_menu') }}"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>

            {{-- Page / Application Title --}}
            <div>
                <h1 class="text-lg font-semibold text-[var(--color-foreground)]">
                    {{ __('navigation.university_portal') }}
                </h1>
            </div>

        </div>


        {{-- =====================================================
             Right Side
        ====================================================== --}}

        <div class="flex items-center gap-1 sm:gap-2">

            {{-- Language --}}
            <a
                href="{{ route(
                    'language.switch',
                    app()->getLocale() === 'en' ? 'ar' : 'en'
                ) }}"
                class="rounded-lg px-3 py-2 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-foreground)]"
                aria-label="{{ __('navigation.language') }}"
            >
                {{ __('navigation.language') }}
            </a>


            {{-- Theme --}}
            <button
                type="button"
                data-theme-toggle
                class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-foreground)]"
                aria-label="{{ __('navigation.toggle_theme') }}"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 3v1
                           m0 16v1
                           m9-9h-1
                           M4 12H3
                           m15.364-6.364-.707.707
                           M6.343 17.657l-.707.707
                           m12.728 0-.707-.707
                           M6.343 6.343l-.707-.707
                           M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                    />
                </svg>
            </button>


            {{-- Divider --}}
            <div
                class="mx-1 hidden h-6 w-px bg-[var(--color-border)] sm:block"
            ></div>


            {{-- User Dropdown --}}
            @php
                $user = auth()->user();

                $roleLabels = [
                    'admin' => 'Administrator',
                    'teacher' => 'Instructor',
                    'employee' => 'Employee',
                    'student' => 'Student',
                ];

                $roleLabel = $roleLabels[$user->role]
                    ?? ucfirst($user->role);
            @endphp

            <div
                class="relative"
                data-user-menu
            >

                {{-- User Button --}}
                <button
                    type="button"
                    data-user-menu-button
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 transition hover:bg-[var(--color-surface-muted)]"
                    aria-haspopup="true"
                    aria-expanded="false"
                >

                    {{-- User Information --}}
                    <div class="hidden text-end sm:block">
                        <p class="text-sm font-medium text-[var(--color-foreground)]">
                            {{ $user->name }}
                        </p>

                        <p class="text-xs text-[var(--color-foreground-muted)]">
                            {{ $roleLabel }}
                        </p>
                    </div>

                    {{-- Avatar --}}
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[var(--color-primary)] text-sm font-semibold text-white"
                    >
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>

                    {{-- Arrow --}}
                    <svg
                        data-user-menu-arrow
                        class="hidden h-4 w-4 text-[var(--color-foreground-muted)] transition-transform sm:block"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m6 9 6 6 6-6"
                        />
                    </svg>

                </button>


                {{-- Dropdown Menu --}}
                <div
                    data-user-menu-dropdown
                    class="absolute end-0 top-full z-50 mt-2 hidden w-56 overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-lg"
                    role="menu"
                >

                    {{-- User Details --}}
                    <div class="border-b border-[var(--color-border)] px-4 py-3">
                        <p class="truncate text-sm font-medium text-[var(--color-foreground)]">
                            {{ $user->name }}
                        </p>

                        <p class="truncate text-xs text-[var(--color-foreground-muted)]">
                            {{ $user->email }}
                        </p>
                    </div>


                    {{-- Profile --}}
                    <a
                        href="{{ route('profile.show') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                        role="menuitem"
                    >
                        <svg
                            class="h-5 w-5 text-[var(--color-foreground-muted)]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 0 1 15 0"
                            />
                        </svg>

                        <span>{{ __('navigation.profile') }}</span>
                    </a>


                    {{-- Logout --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 px-4 py-3 text-sm text-red-600 transition hover:bg-red-50 dark:hover:bg-red-950/30"
                            role="menuitem"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 12h9m0 0-3-3m3 3-3 3"
                                />
                            </svg>

                            <span>{{ __('navigation.logout') }}</span>
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
</header>


{{-- =====================================================
     User Dropdown Script
====================================================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenu = document.querySelector('[data-user-menu]');
        const userMenuButton = document.querySelector('[data-user-menu-button]');
        const userMenuDropdown = document.querySelector('[data-user-menu-dropdown]');
        const userMenuArrow = document.querySelector('[data-user-menu-arrow]');

        if (!userMenu || !userMenuButton || !userMenuDropdown) {
            return;
        }

        function openUserMenu() {
            userMenuDropdown.classList.remove('hidden');
            userMenuButton.setAttribute('aria-expanded', 'true');

            if (userMenuArrow) {
                userMenuArrow.classList.add('rotate-180');
            }
        }

        function closeUserMenu() {
            userMenuDropdown.classList.add('hidden');
            userMenuButton.setAttribute('aria-expanded', 'false');

            if (userMenuArrow) {
                userMenuArrow.classList.remove('rotate-180');
            }
        }

        userMenuButton.addEventListener('click', function (event) {
            event.stopPropagation();

            if (userMenuDropdown.classList.contains('hidden')) {
                openUserMenu();
            } else {
                closeUserMenu();
            }
        });

        document.addEventListener('click', function (event) {
            if (!userMenu.contains(event.target)) {
                closeUserMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeUserMenu();
            }
        });
    });
</script>
