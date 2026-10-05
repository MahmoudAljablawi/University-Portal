@extends('layouts.app')

@section('title', __('Edit College'))

@section('content') <div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-semibold text-[var(--color-foreground)]">
            {{ __('Edit College') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Update the college information.') }}
        </p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-lg border border-[var(--color-danger)]/30 bg-[var(--color-danger)]/10 p-4">
            <ul class="list-disc space-y-1 ps-5 text-sm text-[var(--color-danger)]">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm">
        <form
            action="{{ route('colleges.update', $college) }}"
            method="POST"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('College Name') }}
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $college->name) }}"
                    required
                    maxlength="255"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('name')
                    <p class="mt-1 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Code --}}
            <div>
                <label
                    for="code"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    {{ __('College Code') }}
                </label>

                <input
                    id="code"
                    name="code"
                    type="text"
                    value="{{ old('code', $college->code) }}"
                    required
                    maxlength="50"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm uppercase text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('code')
                    <p class="mt-1 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">
                <a
                    href="{{ route('colleges.index') }}"
                    class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                >
                    {{ __('Cancel') }}
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    {{ __('Update College') }}
                </button>
            </div>
        </form>
    </div>

</div>


@endsection
