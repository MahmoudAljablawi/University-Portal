@extends('layouts.app')

@section('title', 'Add College')

@section('content') <div class="mx-auto max-w-3xl space-y-6">


    {{-- Page Header --}}
    <div>
        <a
            href="{{ route('colleges.index') }}"
            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:text-[var(--color-primary)]"
        >
            <svg
                class="h-4 w-4 rtl:rotate-180"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="M19 12H5"/>
                <path d="M12 19l-7-7 7-7"/>
            </svg>

            Back to Colleges
        </a>

        <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
            Add College
        </h2>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Create a new college in the university.
        </p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div
            class="rounded-lg border border-[var(--color-danger)]/30 bg-[color-mix(in_srgb,var(--color-danger)_8%,transparent)] p-4"
        >
            <div class="flex gap-3">
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-[var(--color-danger)]"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 8v4"/>
                    <path d="M12 16h.01"/>
                </svg>

                <div>
                    <p class="text-sm font-medium text-[var(--color-danger)]">
                        Please correct the following errors:
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-[var(--color-danger)]">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <div
        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]"
    >
        <form
            action="{{ route('colleges.store') }}"
            method="POST"
            class="space-y-6 p-6 sm:p-8"
        >
            @csrf

            {{-- College Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    College Name
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Enter college name"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('name')
                    <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- College Code --}}
            <div>
                <label
                    for="code"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                >
                    College Code
                </label>

                <input
                    id="code"
                    name="code"
                    type="text"
                    value="{{ old('code') }}"
                    required
                    placeholder="Enter college code"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm uppercase text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('code')
                    <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-6 sm:flex-row sm:justify-end"
            >
                <a
                    href="{{ route('colleges.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]"
                >
                    Create College
                </button>
            </div>

        </form>
    </div>

</div>


@endsection
