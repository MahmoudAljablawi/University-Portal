
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
            @yield('title', config('app.name', 'University Portal'))
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

        {{ $slot }}

        @livewireScripts

        @stack('scripts')
    </body>
</html>
