@props([
    'title',
    'description' => null,
])

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            {{ $title }}
        </h1>

        @if ($description)
            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ $description }}
            </p>
        @endif
    </div>

    @if ($actions ?? false)
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>