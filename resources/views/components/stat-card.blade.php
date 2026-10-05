@props([
'title',
'value',
'description' => null,
'change' => null,
'changeType' => 'increase', // 'increase' | 'decrease' | 'neutral'
])

@php
$changeColors = [
'increase' => 'text-[var(--color-success,#10b981)] bg-[var(--color-success,#10b981)]/10 border-[var(--color-success,#10b981)]/20',
'decrease' => 'text-[var(--color-danger,#ef4444)] bg-[var(--color-danger,#ef4444)]/10 border-[var(--color-danger,#ef4444)]/20',
'neutral' => 'text-[var(--color-foreground-muted)] bg-[var(--color-surface-muted)] border-[var(--color-border)]',
][$changeType] ?? 'text-[var(--color-foreground-muted)] bg-[var(--color-surface-muted)] border-[var(--color-border)]';
@endphp

<div
    {{ $attributes->merge([
        'class' => 'group relative overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition-all duration-300 hover:-translate-y-1 hover:border-[var(--color-primary)]/40 hover:shadow-xl hover:shadow-[var(--color-primary)]/5'
    ]) }}>
    <div class="absolute inset-y-0 start-0 w-1.5 bg-gradient-to-b from-[var(--color-primary)] to-[var(--color-primary)]/40 rounded-s-2xl transition-all duration-300 group-hover:w-2"></div>

    <div class="ms-2 flex items-center justify-between gap-4">

        <div class="min-w-0 flex-1 space-y-1.5">
            <div class="flex items-center gap-2">
                <p class="text-sm font-semibold tracking-wide text-[var(--color-foreground-muted)] transition-colors duration-200 group-hover:text-[var(--color-foreground)]">
                    {{ $title }}
                </p>

                @if ($change)
                <span class="inline-flex items-center gap-1 rounded-full border px-2 py-0.5 text-[11px] font-bold {{ $changeColors }}">
                    @if($changeType === 'increase')
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    @elseif($changeType === 'decrease')
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    @endif
                    {{ $change }}
                </span>
                @endif
            </div>

            @if ($description)
            <p class="text-xs font-normal text-[var(--color-foreground-muted)] leading-relaxed">
                {{ $description }}
            </p>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <div class="flex min-w-[3rem] items-center justify-center rounded-xl border border-[var(--color-primary)]/20 bg-gradient-to-br from-[var(--color-primary)]/10 via-[var(--color-primary)]/5 to-transparent px-3.5 py-2 text-center shadow-inner transition-all duration-300 group-hover:border-[var(--color-primary)]/40 group-hover:scale-105 group-hover:shadow-md">
                <span class="text-2xl font-black tracking-tight text-[var(--color-primary)]">
                    {{ $value }}
                </span>
            </div>

            @if (isset($icon) && $icon->isNotEmpty())
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] text-[var(--color-foreground-muted)] transition-all duration-300 group-hover:border-[var(--color-primary)]/30 group-hover:bg-[var(--color-primary)] group-hover:text-white">
                {{ $icon }}
            </div>
            @endif
        </div>

    </div>
</div>