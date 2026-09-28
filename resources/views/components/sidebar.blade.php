
@php
    use App\Support\Navigation;

    $user = auth()->user();
    $userRole = $user?->role;

    $navigationItems = collect(Navigation::items())
        ->filter(fn ($item) => in_array($userRole, $item['roles']))
        ->values();
@endphp

{{-- =========================================================
Desktop Sidebar
========================================================= --}}

<aside
    class="fixed inset-y-0 start-0 z-40 hidden w-64 border-e border-[var(--color-border)] bg-[var(--color-sidebar)] lg:block"
>
    <div class="flex h-full flex-col">

        {{-- Logo --}}
        <div class="flex h-16 shrink-0 items-center border-b border-[var(--color-border)] px-6">
            <a
                href="{{ route('dashboard') }}"
                class="text-lg font-bold text-[var(--color-foreground)]"
            >
                {{ __('navigation.university_portal') }}
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-1 overflow-y-auto p-4">

            @foreach ($navigationItems as $item)

                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp

                <a
                    href="{{ route($item['url'] ?? $item['route']) }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $isActive
                        ? 'bg-[var(--color-sidebar-active)] text-[var(--color-primary)]'
                        : 'text-[var(--color-sidebar-foreground)] hover:bg-[var(--color-surface-muted)]'
                    }}"
                >

                    {{-- Icon --}}
                    <span class="h-5 w-5 shrink-0">

                        @switch($item['icon'])

                            {{-- Dashboard --}}
                            @case('dashboard')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 12l9-9 9 9M5 10v10h14V10"
                                    />
                                </svg>
                                @break

                            {{-- Users --}}
                            @case('users')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1
                                           M9 20H4v-2a4 4 0 014-4h1
                                           m4-4a4 4 0 100-8 4 4 0 000 8
                                           m6 2a3 3 0 100-6 3 3 0 000 6"
                                    />
                                </svg>
                                @break

                            {{-- Colleges --}}
                            @case('colleges')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 10l9-5 9 5
                                           M5 10v8
                                           M9 10v8
                                           M15 10v8
                                           M19 10v8
                                           M3 18h18
                                           M2 21h20"
                                    />
                                </svg>
                                @break

                            {{-- Departments --}}
                            @case('departments')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 5h16M4 12h10M4 19h16
                                           M18 10v8
                                           M15 15l3 3 3-3"
                                    />
                                </svg>
                                @break

                            {{-- Academic Semesters --}}
                            @case('academic-semesters')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 3v4M17 3v4
                                           M4 9h16
                                           M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z
                                           M8 13h3M8 17h3M14 13h2M14 17h2"
                                    />
                                </svg>
                                @break

                            {{-- Courses --}}
                            @case('courses')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 19.5A2.5 2.5 0 016.5 17H20
                                           M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                                    />
                                </svg>
                                @break

                            {{-- Course Sections --}}
                            @case('course-sections')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 5h16M4 12h16M4 19h16"
                                    />
                                </svg>
                                @break

                            {{-- Enrollments --}}
                            @case('enrollments')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2
                                           M9 11a4 4 0 100-8 4 4 0 000 8
                                           M22 21v-2a4 4 0 00-3-3.87
                                           M16 3.13a4 4 0 010 7.75"
                                    />
                                </svg>
                                @break

                            {{-- Grades --}}
                            @case('grades')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4
                                           M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5
                                           a2 2 0 01-2-2V6a2 2 0 012-2z"
                                    />
                                </svg>
                                @break

                            {{-- Academic Requests --}}
                            @case('academic-requests')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6
                                           M9 16h6
                                           M8 4h8
                                           a2 2 0 012 2v14H6V6a2 2 0 012-2z"
                                    />
                                </svg>
                                @break

                            {{-- Audit Logs --}}
                            @case('audit-logs')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5H6a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-3
                                           M9 5a3 3 0 016 0
                                           M8 12h8
                                           M8 16h5"
                                    />
                                </svg>
                                @break

                        @endswitch

                    </span>

                    <span class="truncate">
                        {{ __($item['label']) }}
                    </span>

                </a>

            @endforeach

        </nav>

        {{-- Footer --}}
        <div class="shrink-0 border-t border-[var(--color-border)] p-4">
            <p class="text-xs text-[var(--color-foreground-muted)]">
                {{ __('navigation.university_portal') }}
            </p>
        </div>

    </div>
</aside>


{{-- =========================================================
Mobile Sidebar
========================================================= --}}

<div
    data-sidebar
    class="fixed inset-0 z-50 hidden lg:hidden"
>

    {{-- Overlay --}}
    <div
        data-sidebar-overlay
        class="absolute inset-0 bg-black/40"
    ></div>

    {{-- Drawer --}}
    <aside
        class="relative flex h-full w-72 max-w-[85vw] flex-col bg-[var(--color-sidebar)] shadow-xl"
    >

        {{-- Header --}}
        <div class="flex h-16 shrink-0 items-center justify-between border-b border-[var(--color-border)] px-5">

            <a
                href="{{ route('dashboard') }}"
                class="text-lg font-bold text-[var(--color-foreground)]"
            >
                {{ __('navigation.university_portal') }}
            </a>

            <button
                type="button"
                data-sidebar-close
                class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
                aria-label="{{ __('navigation.close_menu') }}"
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
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-1 overflow-y-auto p-4">

            @foreach ($navigationItems as $item)

                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp

                <a
                    href="{{ route($item['url'] ?? $item['route']) }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $isActive
                        ? 'bg-[var(--color-sidebar-active)] text-[var(--color-primary)]'
                        : 'text-[var(--color-sidebar-foreground)] hover:bg-[var(--color-surface-muted)]'
                    }}"
                >

                    <span class="h-5 w-5 shrink-0">

                        @switch($item['icon'])

                            @case('dashboard')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 12l9-9 9 9M5 10v10h14V10"
                                    />
                                </svg>
                                @break

                            @case('users')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1
                                           M9 20H4v-2a4 4 0 014-4h1
                                           m4-4a4 4 0 100-8 4 4 0 000 8
                                           m6 2a3 3 0 100-6 3 3 0 000 6"
                                    />
                                </svg>
                                @break

                            @case('colleges')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 10l9-5 9 5
                                           M5 10v8
                                           M9 10v8
                                           M15 10v8
                                           M19 10v8
                                           M3 18h18
                                           M2 21h20"
                                    />
                                </svg>
                                @break

                            @case('departments')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 5h16M4 12h10M4 19h16
                                           M18 10v8
                                           M15 15l3 3 3-3"
                                    />
                                </svg>
                                @break

                            @case('academic-semesters')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 3v4M17 3v4
                                           M4 9h16
                                           M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z
                                           M8 13h3M8 17h3M14 13h2M14 17h2"
                                    />
                                </svg>
                                @break

                            @case('courses')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 19.5A2.5 2.5 0 016.5 17H20
                                           M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                                    />
                                </svg>
                                @break

                            @case('course-sections')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 5h16M4 12h16M4 19h16"
                                    />
                                </svg>
                                @break

                            @case('enrollments')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2
                                           M9 11a4 4 0 100-8 4 4 0 000 8
                                           M22 21v-2a4 4 0 00-3-3.87
                                           M16 3.13a4 4 0 010 7.75"
                                    />
                                </svg>
                                @break

                            @case('grades')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4
                                           M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5
                                           a2 2 0 01-2-2V6a2 2 0 012-2z"
                                    />
                                </svg>
                                @break

                            @case('academic-requests')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6
                                           M9 16h6
                                           M8 4h8
                                           a2 2 0 012 2v14H6V6a2 2 0 012-2z"
                                    />
                                </svg>
                                @break

                            @case('audit-logs')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5H6a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-3
                                           M9 5a3 3 0 016 0
                                           M8 12h8
                                           M8 16h5"
                                    />
                                </svg>
                                @break

                        @endswitch

                    </span>

                    <span class="truncate">
                        {{ __($item['label']) }}
                    </span>

                </a>

            @endforeach

        </nav>

    </aside>

</div>
