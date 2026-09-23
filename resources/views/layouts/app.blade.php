<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    class="h-full"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'University Portal'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="m-0 min-h-full bg-[var(--color-background)] p-0 text-[var(--color-foreground)] antialiased">

    <div class="min-h-screen">

        {{-- الشريط الجانبي --}}
        <x-sidebar />

        {{-- منطقة المحتوى الرئيسي --}}
        <div class="relative flex min-h-screen flex-col gap-0 lg:ms-64">

            {{-- الشريط العلوي Sticky Navbar --}}
            <x-navbar />

            {{-- محتوى الصفحة --}}
            <main class="flex-1 bg-[var(--color-background)] p-4 sm:p-6 lg:p-8">

                {{-- Flash Messages --}}
                @foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning', 'info' => 'info'] as $key => $type)
                    @if (session()->has($key))
                        <x-alert
                            :type="$type"
                            :message="session($key)"
                            class="mb-6"
                        />
                    @endif
                @endforeach

                @yield('content')
                {{ $slot ?? '' }}

            </main>

        </div>

    </div>

    @stack('scripts')

</body>
</html>