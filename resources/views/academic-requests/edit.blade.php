@extends('layouts.app')

@section('title', __('Edit Academic Request'))

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            {{ __('Edit Academic Request') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Update your academic service request while it is still pending.') }}
        </p>

    </div>


    {{-- Request Summary --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface-muted)] p-5">

        <div class="grid gap-4 sm:grid-cols-2">


            {{-- Request Type --}}
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide
                           text-[var(--color-foreground-muted)]">
                    {{ __('Current Request Type') }}
                </p>

                <p
                    class="mt-1 text-sm font-medium
                           text-[var(--color-foreground)]">
                    {{ match ($academicRequest->request_type) {
                        'grade_inquiry' => __('Grade Inquiry'),
                        'enrollment_pause' => __('Enrollment Pause'),
                        'objection' => __('Objection'),
                        default => __(ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $academicRequest->request_type
                            )
                        )),
                    } }}
                </p>

            </div>


            {{-- Status --}}
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide
                           text-[var(--color-foreground-muted)]">
                    {{ __('Current Status') }}
                </p>

                <div class="mt-2">

                    <span
                        class="inline-flex rounded-full
                               bg-[var(--color-warning)]/10
                               px-2.5 py-1 text-xs font-semibold
                               text-[var(--color-warning)]">
                        {{ __('Pending') }}
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- Edit Form --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] p-6 shadow-sm">

        <div>

            <h2
                class="text-lg font-semibold
                       text-[var(--color-foreground)]">
                {{ __('Request Information') }}
            </h2>

            <p
                class="mt-1 text-sm
                       text-[var(--color-foreground-muted)]">
                {{ __('Update the information you want to change.') }}
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('academic-requests.update', $academicRequest) }}"
            class="mt-6 space-y-6">

            @csrf
            @method('PUT')


            {{-- Request Type --}}
            <div>

                <label
                    for="request_type"
                    class="mb-2 block text-sm font-medium
                           text-[var(--color-foreground)]">
                    {{ __('Request Type') }}
                </label>

                <select
                    id="request_type"
                    name="request_type"
                    required
                    class="w-full rounded-lg
                           border border-[var(--color-border)]
                           bg-[var(--color-surface)]
                           px-4 py-2.5 text-sm
                           text-[var(--color-foreground)]
                           outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2
                           focus:ring-[var(--color-primary)]/20">

                    <option
                        value="grade_inquiry"
                        @selected(
                        old( 'request_type' ,
                        $academicRequest->request_type
                        ) === 'grade_inquiry'
                        )
                        >
                        {{ __('Grade Inquiry') }}
                    </option>

                    <option
                        value="enrollment_pause"
                        @selected(
                        old( 'request_type' ,
                        $academicRequest->request_type
                        ) === 'enrollment_pause'
                        )
                        >
                        {{ __('Enrollment Pause') }}
                    </option>

                    <option
                        value="objection"
                        @selected(
                        old( 'request_type' ,
                        $academicRequest->request_type
                        ) === 'objection'
                        )
                        >
                        {{ __('Objection') }}
                    </option>

                </select>

                @error('request_type')

                <p
                    class="mt-1 text-sm
                               text-[var(--color-danger)]">
                    {{ $message }}
                </p>

                @enderror

            </div>


            {{-- Reason --}}
            <div>

                <label
                    for="reason"
                    class="mb-2 block text-sm font-medium
                           text-[var(--color-foreground)]">
                    {{ __('Reason') }}
                </label>

                <textarea
                    id="reason"
                    name="reason"
                    rows="6"
                    required
                    placeholder="{{ __('Describe the reason for your request...') }}"
                    class="w-full resize-y rounded-lg
                           border border-[var(--color-border)]
                           bg-[var(--color-surface)]
                           px-4 py-3 text-sm
                           text-[var(--color-foreground)]
                           outline-none transition
                           focus:border-[var(--color-primary)]
                           focus:ring-2
                           focus:ring-[var(--color-primary)]/20">{{ old('reason', $academicRequest->reason) }}</textarea>

                @error('reason')

                <p
                    class="mt-1 text-sm
                               text-[var(--color-danger)]">
                    {{ $message }}
                </p>

                @enderror

            </div>


            {{-- Actions --}}
            <div
                class="flex items-center justify-end gap-3
                       border-t border-[var(--color-border)]
                       pt-6">

                <a
                    href="{{ route('academic-requests.show', $academicRequest) }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium
                           text-[var(--color-foreground-muted)]
                           transition
                           hover:bg-[var(--color-surface-muted)]">
                    {{ __('Cancel') }}
                </a>


                <button
                    type="submit"
                    class="rounded-lg
                           bg-[var(--color-primary)]
                           px-5 py-2.5 text-sm font-semibold text-white
                           transition
                           hover:bg-[var(--color-primary-hover)]">
                    {{ __('Update Request') }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection