@props([
    'model',              // الـ model
    'itemName',           // اسم العنصر للحذف
    'showRoute' => null,  // route للـ show (مثل: 'users.show')
    'editRoute' => null,  // route للـ edit
    'destroyRoute' => null, // route للـ destroy
    'showView' => true,
    'showEdit' => true,
    'showDelete' => true,
    'deleteConfirm' => 'Are you sure?',
])

<td class="whitespace-nowrap px-6 py-4">
    <div class="flex items-center justify-end gap-2">

        {{-- View --}}
        @if ($showView && $showRoute)
            <a
                href="{{ route($showRoute, $model) }}"
                class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-foreground)]"
                title="View">
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </a>
        @endif

        {{-- Edit --}}
        @if ($showEdit && $editRoute)
            <a
                href="{{ route($editRoute, $model) }}"
                class="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)] hover:text-[var(--color-primary)]"
                title="Edit">
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 20h9" />
                    <path d="M16.5 3.5a 2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z" />
                </svg>
            </a>
        @endif

        {{-- Delete --}}
        @if ($showDelete && $destroyRoute)
            <x-delete-button
                :route="route($destroyRoute, $model)"
                :itemName="$itemName"
                buttonText=""
                :confirmText="$deleteConfirm"
                buttonClass="rounded-lg p-2 text-[var(--color-foreground-muted)] transition hover:bg-[color-mix(in_srgb,var(--color-danger)_10%,transparent)] hover:text-[var(--color-danger)]"
                svgOnly="true"
                title="Delete"
            />
        @endif

    </div>
</td>