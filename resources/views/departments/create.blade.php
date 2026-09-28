@extends('layouts.app')

@section('title', 'Create Department')

@section('content') <div class="mx-auto max-w-3xl space-y-6">


    {{-- Page Header --}}
    <div>
        <div class="flex items-center gap-2 text-sm text-[var(--color-foreground-muted)]">
            <a
                href="{{ route('departments.index') }}"
                class="transition hover:text-[var(--color-primary)]"
            >
                Departments
            </a>

            <span>/</span>

            <span>Create</span>
        </div>

        <h1 class="mt-2 text-2xl font-semibold tracking-tight">
            Create Department
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Add a new department to a college.
        </p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div
            class="rounded-lg border border-[var(--color-danger)]
                   bg-red-50 p-4 dark:bg-red-950/20"
        >
            <p class="font-medium text-[var(--color-danger)]">
                Please correct the following errors:
            </p>

            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-[var(--color-danger)]">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] p-6 shadow-sm sm:p-8"
    >
        <form
            action="{{ route('departments.store') }}"
            method="POST"
            class="space-y-6"
        >
            @csrf

            {{-- Department Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium"
                >
                    Department Name
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    maxlength="255"
                    placeholder="e.g. Computer Science"
                    class="block w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] px-4 py-2.5 text-sm
                           outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('name')
                    <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Department Code --}}
            <div>
                <label
                    for="code"
                    class="mb-2 block text-sm font-medium"
                >
                    Department Code
                </label>

                <input
                    id="code"
                    name="code"
                    type="text"
                    value="{{ old('code') }}"
                    required
                    maxlength="50"
                    placeholder="e.g. CS"
                    class="block w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] px-4 py-2.5 text-sm
                           uppercase outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >

                @error('code')
                    <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- College --}}
            <div>
                <label
                    for="college_id"
                    class="mb-2 block text-sm font-medium"
                >
                    College
                </label>

                <select
                    id="college_id"
                    name="college_id"
                    required
                    class="block w-full rounded-lg border border-[var(--color-border)]
                           bg-[var(--color-background)] px-4 py-2.5 text-sm
                           outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20"
                >
                    <option value="">Select a college</option>

                    @foreach ($colleges as $college)
                        <option
                            value="{{ $college->id }}"
                            @selected(old('college_id') == $college->id)
                        >
                            {{ $college->name }}
                            @if ($college->code)
                                ({{ $college->code }})
                            @endif
                        </option>
                    @endforeach
                </select>

                @error('college_id')
                    <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror

                @if ($colleges->isEmpty())
                    <p class="mt-2 text-sm text-[var(--color-foreground-muted)]">
                        No colleges are available. Create a college first.
                    </p>
                @endif
            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)]
                       pt-6 sm:flex-row sm:justify-end"
            >
                <a
                    href="{{ route('departments.index') }}"
                    class="inline-flex items-center justify-center rounded-lg
                           border border-[var(--color-border)]
                           px-4 py-2.5 text-sm font-medium
                           transition hover:bg-[var(--color-surface-muted)]"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    @disabled($colleges->isEmpty())
                    class="inline-flex items-center justify-center rounded-lg
                           bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium
                           text-white transition
                           hover:bg-[var(--color-primary-hover)]
                           disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Create Department
                </button>
            </div>
        </form>
    </div>

</div>


@endsection
