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
                <h1
                    class="text-lg font-semibold text-[var(--color-foreground)]"
                >
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
                aria-label="Toggle theme"
            >
                {{-- Sun --}}
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


            {{-- User --}}
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

            <div class="flex items-center gap-3 px-1 sm:px-2">

                {{-- User Information --}}
                <div class="hidden text-end sm:block">

                    <p
                        class="text-sm font-medium text-[var(--color-foreground)]"
                    >
                        {{ $user->name }}
                    </p>

                    <p
                        class="text-xs text-[var(--color-foreground-muted)]"
                    >
                        {{ $roleLabel }}
                    </p>

                </div>


                {{-- Avatar --}}
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[var(--color-primary)] text-sm font-semibold text-white"
                >
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

            </div>

        </div>

    </div>
</header>
