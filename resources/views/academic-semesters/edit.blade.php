@extends('layouts.app')

@section('title', __('Edit Academic Semester'))

@section('content') <div class="mx-auto max-w-3xl space-y-6">


    {{-- Page Header --}}
    <div>
        <div class="flex items-center gap-2 text-sm text-[var(--color-foreground-muted)]">
            <a
                href="{{ route('academic-semesters.index') }}"
                class="transition hover:text-[var(--color-primary)]"
            >
                {{ __('Academic Semesters') }}
            </a>

            <span>/</span>

            <span>{{ __('Edit') }}</span>
        </div>

        <h1 class="mt-2 text-2xl font-semibold tracking-tight">
            {{ __('Edit Academic Semester') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Update the academic semester information.') }}
        </p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div
            class="rounded-lg border border-[var(--color-danger)]
                   bg-red-50 p-4 dark:bg-red-950/20"
        >
            <p class="font-medium text-[var(--color-danger)]">
                {{ __('Please correct the following errors:') }}
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
            action="{{ route('academic-semesters.update', $academicSemester) }}"
            method="POST"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium"
                >
                    {{ __('Semester Name') }}
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $academicSemester->name) }}"
                    required
                    autofocus
                    maxlength="255"
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

            {{-- Code --}}
            <div>
                <label
                    for="code"
                    class="mb-2 block text-sm font-medium"
                >
                    {{ __('Semester Code') }}
                </label>

                <input
                    id="code"
                    name="code"
                    type="text"
                    value="{{ old('code', $academicSemester->code) }}"
                    required
                    maxlength="50"
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

            {{-- Dates --}}
            <div class="grid gap-6 sm:grid-cols-2">

                {{-- Start Date --}}
                <div>
                    <label
                        for="start_date"
                        class="mb-2 block text-sm font-medium"
                    >
                        {{ __('Start Date') }}
                    </label>

                    <input
                        id="start_date"
                        name="start_date"
                        type="date"
                        value="{{ old('start_date', $academicSemester->start_date) }}"
                        required
                        class="block w-full rounded-lg border border-[var(--color-border)]
                               bg-[var(--color-background)] px-4 py-2.5 text-sm
                               outline-none transition
                               focus:border-[var(--color-primary)]
                               focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('start_date')
                        <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- End Date --}}
                <div>
                    <label
                        for="end_date"
                        class="mb-2 block text-sm font-medium"
                    >
                        {{ __('End Date') }}
                    </label>

                    <input
                        id="end_date"
                        name="end_date"
                        type="date"
                        value="{{ old('end_date', $academicSemester->end_date) }}"
                        required
                        class="block w-full rounded-lg border border-[var(--color-border)]
                               bg-[var(--color-background)] px-4 py-2.5 text-sm
                               outline-none transition
                               focus:border-[var(--color-primary)]
                               focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

                    @error('end_date')
                        <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Active Status --}}
            <div
                class="rounded-lg border border-[var(--color-border)]
                       bg-[var(--color-surface-muted)] p-4"
            >
                <label class="flex cursor-pointer items-start gap-3">
                     <input type="hidden" name="is_active" value="0">
                    <input
                        id="is_active"
                        name="is_active"
                        type="checkbox"
                        value="1"
                        @checked(old('is_active', $academicSemester->is_active))
                        class="mt-0.5 h-4 w-4 rounded border-[var(--color-border)]
                               text-[var(--color-primary)]
                               focus:ring-[var(--color-primary)]/30"
                    >

                    <span>
                        <span class="block text-sm font-medium">
                            {{ __('Active Semester') }}
                        </span>

                        <span class="mt-1 block text-sm text-[var(--color-foreground-muted)]">
                            {{ __('Mark this semester as active.') }}
                        </span>
                    </span>
                </label>

                @error('is_active')
                    <p class="mt-2 text-sm text-[var(--color-danger)]">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)]
                       pt-6 sm:flex-row sm:justify-end"
            >
                <a
                    href="{{ route('academic-semesters.show', $academicSemester) }}"
                    class="inline-flex items-center justify-center rounded-lg
                           border border-[var(--color-border)]
                           px-4 py-2.5 text-sm font-medium
                           transition hover:bg-[var(--color-surface-muted)]"
                >
                    {{ __('Cancel') }}
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg
                           bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium
                           text-white transition
                           hover:bg-[var(--color-primary-hover)]"
                >
                    {{ __('Update Semester') }}
                </button>
            </div>
        </form>
    </div>

</div>


@endsection

@push('scripts') <script>
document.addEventListener('DOMContentLoaded', () => {
const startDate = document.getElementById('start_date');
const endDate = document.getElementById('end_date');


        if (!startDate || !endDate) {
            return;
        }

        const updateEndDateMinimum = () => {
            endDate.min = startDate.value;
        };

        startDate.addEventListener('change', updateEndDateMinimum);

        updateEndDateMinimum();
    });
</script>


@endpush
