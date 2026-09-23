@props([
    'type' => 'info',
    'message' => null,
])

@php
    $styles = match ($type) {
        'success' => [
            'container' => 'border-[var(--color-success)]/30 bg-[var(--color-success)]/10',
            'text' => 'text-[var(--color-success)]',
        ],
        'warning' => [
            'container' => 'border-[var(--color-warning)]/30 bg-[var(--color-warning)]/10',
            'text' => 'text-[var(--color-warning)]',
        ],
        'danger', 'error' => [
            'container' => 'border-[var(--color-danger)]/30 bg-[var(--color-danger)]/10',
            'text' => 'text-[var(--color-danger)]',
        ],
        default => [
            'container' => 'border-[var(--color-primary)]/30 bg-[var(--color-primary)]/10',
            'text' => 'text-[var(--color-primary)]',
        ],
    };
@endphp

@if ($message)
    <div
        {{ $attributes->merge([
            'class' => "rounded-lg border px-4 py-3 text-sm {$styles['container']} {$styles['text']}"
        ]) }}
        role="alert"
    >
        {{ $message }}
    </div>
@endif