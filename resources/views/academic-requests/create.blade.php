@extends('layouts.app')

@section('title', __('New Academic Request'))

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            {{ __('New Academic Request') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Submit a new academic service request.') }}
        </p>
    </div>


    {{-- Form --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <form
            method="POST"
            action="{{ route('academic-requests.store') }}"
            class="space-y-6">
            @csrf

            {{-- Request Type --}}
            <div>
                <label
                    for="request_type"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Request Type') }}
                </label>

                <select
                    id="request_type"
                    name="request_type"
                    required
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">
                    <option value="" disabled @selected(old('request_type')===null)>
                        {{ __('Select request type') }}
                    </option>

                    <option
                        value="grade_inquiry"
                        @selected(old('request_type')==='grade_inquiry' )>
                        {{ __('Grade Inquiry') }}
                    </option>

                    <option
                        value="enrollment_pause"
                        @selected(old('request_type')==='enrollment_pause' )>
                        {{ __('Enrollment Pause') }}
                    </option>

                    <option
                        value="objection"
                        @selected(old('request_type')==='objection' )>
                        {{ __('Objection') }}
                    </option>
                </select>

                @error('request_type')
                <p class="mt-1 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>


            {{-- Reason --}}
            <div>
                <label
                    for="reason"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Reason') }}
                </label>

                <textarea
                    id="reason"
                    name="reason"
                    rows="6"
                    required
                    placeholder="{{ __('Describe the reason for your request...') }}"
                    class="w-full resize-y rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">{{ old('reason') }}</textarea>

                @error('reason')
                <p class="mt-1 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>


            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                <a
                    href="{{ route('academic-requests.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]">
                    {{ __('Cancel') }}
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]">
                    {{ __('Submit Request') }}
                </button>

            </div>

        </form>

    </div>

</div>
@endsection