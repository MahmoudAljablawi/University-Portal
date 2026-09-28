@props([
    'route',
    'itemName' => 'item',
    'class' => '',
    'confirmText' => 'Are you sure?',
    'buttonText' => 'Delete',
    'buttonClass' => 'inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700',
    'showIcon' => true,
    'svgOnly' => false,
])

{{-- ✅ استخدم class بدل ID --}}
<form 
    action="{{ $route }}" 
    method="POST" 
    class="inline delete-form"
    data-item-name="{{ $itemName }}"
    data-confirm-text="{{ $confirmText }}"
>
    @csrf
    @method('DELETE')
    
    <button 
        type="submit"
        class="{{ $buttonClass }} {{ $class }}"
        @if($attributes->has('title')) title="{{ $attributes->get('title') }}" @endif
    >
        @if ($showIcon)
            @if ($svgOnly)
                {{-- SVG مخصص لـ Icon فقط --}}
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M3 6h18"/>
                    <path d="M8 6V4h8v2"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v5M14 11v5"/>
                </svg>
            @else
                {{-- SVG الافتراضي --}}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            @endif
        @endif
        {{ $buttonText }}
    </button>
</form>

