@props([
    'headers' => [],
])

<div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[var(--color-border)]">
            <thead class="bg-[var(--color-surface-muted)]">
                <tr>
                    @foreach ($headers as $header)
                        <th
                            scope="col"
                            class="px-4 py-3 text-start text-xs font-semibold uppercase tracking-wide text-[var(--color-foreground-muted)]"
                        >
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y divide-[var(--color-border)]">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>