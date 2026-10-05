@extends('layouts.app')

@section('title', __('Academic Request Details'))

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                {{ __('Academic Request Details') }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('View the details and current status of this request.') }}
            </p>
        </div>


        @php
        $user = auth()->user();

        $isStudentOwner =
        $user->role === 'student' &&
        $user->id === $academicRequest->student_id;

        $canEdit =
        $isStudentOwner &&
        $academicRequest->status === 'pending';

        $canProcess =
        $user->role === 'employee' &&
        $academicRequest->status === 'pending';
        @endphp


        {{-- Actions --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- Student: Edit --}}
            @if ($canEdit)

            <a
                href="{{ route('academic-requests.edit', $academicRequest) }}"
                class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-[var(--color-primary)]
                           px-4 py-2.5 text-sm font-semibold text-white
                           transition
                           hover:bg-[var(--color-primary-hover)]
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[var(--color-primary)]/20">

                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 20h9" />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5Z" />
                </svg>

                {{ __('Edit Request') }}
            </a>

            @endif


            {{-- Employee: Workflow --}}
            @if ($canProcess)

            {{-- Approve --}}
            <form
                method="POST"
                action="{{ route('academic-requests.approve', $academicRequest) }}">

                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                   rounded-lg
                   border border-[var(--color-success)]/30
                   bg-[var(--color-success)]/10
                   px-4 py-2.5 text-sm font-semibold
                   text-[var(--color-success)]
                   transition
                   hover:border-[var(--color-success)]/50
                   hover:bg-[var(--color-success)]/20
                   focus:outline-none
                   focus:ring-2
                   focus:ring-[var(--color-success)]/20">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m5 12 4 4L19 6" />
                    </svg>

                    {{ __('Approve') }}
                </button>

            </form>


            {{-- Reject --}}
            <form
                method="POST"
                action="{{ route('academic-requests.reject', $academicRequest) }}">

                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                   rounded-lg
                   border border-[var(--color-danger)]/30
                   bg-[var(--color-danger)]/5
                   px-4 py-2.5 text-sm font-semibold
                   text-[var(--color-danger)]
                   transition
                   hover:border-[var(--color-danger)]/50
                   hover:bg-[var(--color-danger)]/10
                   focus:outline-none
                   focus:ring-2
                   focus:ring-[var(--color-danger)]/20">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6l12 12M6 18 18 6" />
                    </svg>

                    {{ __('Reject') }}
                </button>

            </form>

            @endif

        </div>

    </div>


    {{-- Request Information --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] p-6 shadow-sm">

        <div class="grid gap-6 sm:grid-cols-2">


            {{-- Student --}}
            @if (in_array(auth()->user()->role, ['admin', 'employee']))

            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide
                               text-[var(--color-foreground-muted)]">
                    {{ __('Student') }}
                </p>

                <p
                    class="mt-1 text-sm font-medium
                               text-[var(--color-foreground)]">
                    {{ $academicRequest->student?->name ?? '—' }}
                </p>

                <p
                    class="mt-1 text-xs
                               text-[var(--color-foreground-muted)]">
                    {{ $academicRequest->student?->email ?? '—' }}
                </p>

            </div>

            @endif


            {{-- Request Type --}}
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide
                           text-[var(--color-foreground-muted)]">
                    {{ __('Request Type') }}
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
                    {{ __('Status') }}
                </p>

                <div class="mt-2">

                    @switch($academicRequest->status)

                    @case('approved')

                    <span
                        class="inline-flex items-center gap-1.5
                                       rounded-full
                                       bg-[var(--color-success)]/10
                                       px-3 py-1.5 text-sm font-semibold
                                       text-[var(--color-success)]">

                        <span
                            class="h-1.5 w-1.5 rounded-full
                                           bg-[var(--color-success)]">
                        </span>

                        {{ __('Approved') }}
                    </span>

                    @break


                    @case('rejected')

                    <span
                        class="inline-flex items-center gap-1.5
                                       rounded-full
                                       bg-[var(--color-danger)]/10
                                       px-3 py-1.5 text-sm font-semibold
                                       text-[var(--color-danger)]">

                        <span
                            class="h-1.5 w-1.5 rounded-full
                                           bg-[var(--color-danger)]">
                        </span>

                        {{ __('Rejected') }}
                    </span>

                    @break


                    @default

                    <span
                        class="inline-flex items-center gap-1.5
                                       rounded-full
                                       bg-[var(--color-warning)]/10
                                       px-3 py-1.5 text-sm font-semibold
                                       text-[var(--color-warning)]">

                        <span
                            class="h-1.5 w-1.5 rounded-full
                                           bg-[var(--color-warning)]">
                        </span>

                        {{ __('Pending') }}
                    </span>

                    @endswitch

                </div>

            </div>


            {{-- Request ID --}}
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide
                           text-[var(--color-foreground-muted)]">
                    {{ __('Request ID') }}
                </p>

                <p
                    class="mt-1 text-sm font-medium
                           text-[var(--color-foreground)]">
                    #{{ $academicRequest->id }}
                </p>

            </div>


            {{-- Reason --}}
            <div class="sm:col-span-2">

                <p
                    class="text-xs font-medium uppercase tracking-wide
                           text-[var(--color-foreground-muted)]">
                    {{ __('Reason') }}
                </p>

                <div
                    class="mt-2 rounded-lg
                           bg-[var(--color-surface-muted)] p-4">

                    <p
                        class="whitespace-pre-line text-sm leading-6
                               text-[var(--color-foreground)]">
                        {{ $academicRequest->reason ?: '—' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- QR Code Token --}}
        @if ($academicRequest->qr_code_token)

        <div
            class="mt-6 border-t border-[var(--color-border)] pt-6">

            <p
                class="text-xs font-medium uppercase tracking-wide
                           text-[var(--color-foreground-muted)]">
                {{ __('QR Code Token') }}
            </p>

            <p
                class="mt-2 break-all rounded-lg
                           bg-[var(--color-surface-muted)] p-3
                           font-mono text-sm
                           text-[var(--color-foreground)]">
                {{ $academicRequest->qr_code_token }}
            </p>

        </div>

        @endif

    </div>


    {{-- Back --}}
    <div>

        <a
            href="{{ route('academic-requests.index') }}"
            class="inline-flex items-center gap-2 rounded-lg
                   px-4 py-2.5 text-sm font-medium
                   text-[var(--color-foreground-muted)]
                   transition
                   hover:bg-[var(--color-surface-muted)]
                   hover:text-[var(--color-foreground)]">

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7" />
            </svg>

            {{ __('Back to Requests') }}

        </a>

    </div>

</div>

@endsection