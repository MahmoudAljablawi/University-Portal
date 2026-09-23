@props([
    'title',
    'value',
    'description' => null,
])

<div
    class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5"
>
    <div class="flex items-start justify-between gap-4">

        <div class="min-w-0">
            <p class="text-sm font-medium text-[var(--color-foreground-muted)]">
                {{ $title }}
            </p>

            <p class="mt-2 text-2xl font-bold text-[var(--color-foreground)]">
                {{ $value }}
            </p>

            @if ($description)
                <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                    {{ $description }}
                </p>
            @endif
        </div>

        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[var(--color-primary)]/10 text-[var(--color-primary)]"
        >
            {{ $icon ?? '' }}
        </div>

    </div>
</div>