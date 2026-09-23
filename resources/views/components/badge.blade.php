@props([
    'type' => 'default',
])

@php
    $classes = match ($type) {
        'success' =>
            'bg-[var(--color-success)]/10 text-[var(--color-success)]',

        'warning' =>
            'bg-[var(--color-warning)]/10 text-[var(--color-warning)]',

        'danger' =>
            'bg-[var(--color-danger)]/10 text-[var(--color-danger)]',

        'primary' =>
            'bg-[var(--color-primary)]/10 text-[var(--color-primary)]',

        default =>
            'bg-[var(--color-surface-muted)] text-[var(--color-foreground-muted)]',
    };
@endphp

<span
    {{ $attributes->merge([
        'class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {$classes}"
    ]) }}
>
    {{ $slot }}
</span>