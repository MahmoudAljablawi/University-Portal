
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    data-theme="light"
>
    <head>
        <meta charset="utf-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >

        <meta
            name="csrf-token"
            content="{{ csrf_token() }}"
        >

        <title>
            @yield('title', __(config('app.name', 'University Portal')))
        </title>

        {{-- Theme --}}
        <script>
            (() => {
                const savedTheme = localStorage.getItem('theme');

                document.documentElement.dataset.theme =
                    savedTheme === 'dark' || savedTheme === 'light'
                        ? savedTheme
                        : 'light';
            })();
        </script>

        {{-- Assets --}}
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

        @stack('styles')

        @livewireStyles
    </head>

    <body
        class="min-h-screen bg-[var(--color-background)] font-sans text-[var(--color-foreground)] antialiased transition-colors duration-200"
    >
        <a
            href="{{ route('language.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}"
            class="fixed end-4 top-4 z-50 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2 text-sm font-medium"
            lang="{{ app()->getLocale() === 'en' ? 'ar' : 'en' }}"
        >
            {{ __('navigation.language') }}
        </a>

        {{ $slot }}

        @livewireScripts

        @stack('scripts')
    </body>
</html>
