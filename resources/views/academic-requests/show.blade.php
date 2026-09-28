
@extends('layouts.app')

@section('title', 'Academic Request Details')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                Academic Request Details
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                View the details and current status of this request.
            </p>
        </div>

        @if (
            auth()->user()->role === 'admin' ||
            (
                auth()->user()->role === 'student' &&
                auth()->user()->id === $academicRequest->student_id &&
                $academicRequest->status === 'pending'
            )
        )
            <a
                href="{{ route('academic-requests.edit', $academicRequest) }}"
                class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
            >
                Edit Request
            </a>
        @endif
    </div>

    {{-- Request Information --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <div class="grid gap-6 sm:grid-cols-2">

            @if (auth()->user()->role === 'admin')
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                        Student
                    </p>

                    <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                        {{ $academicRequest->student?->name ?? '—' }}
                    </p>

                    <p class="mt-1 text-xs text-[var(--color-foreground-muted)]">
                        {{ $academicRequest->student?->email ?? '—' }}
                    </p>
                </div>
            @endif

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Request Type
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ $academicRequest->request_type }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Status
                </p>

                <div class="mt-2">
                    @switch($academicRequest->status)

                        @case('approved')
                            <span class="inline-flex rounded-full bg-[var(--color-success)]/10 px-3 py-1.5 text-sm font-semibold text-[var(--color-success)]">
                                Approved
                            </span>
                            @break

                        @case('rejected')
                            <span class="inline-flex rounded-full bg-[var(--color-danger)]/10 px-3 py-1.5 text-sm font-semibold text-[var(--color-danger)]">
                                Rejected
                            </span>
                            @break

                        @default
                            <span class="inline-flex rounded-full bg-[var(--color-warning)]/10 px-3 py-1.5 text-sm font-semibold text-[var(--color-warning)]">
                                Pending
                            </span>

                    @endswitch
                </div>
            </div>

            <div class="sm:col-span-2">
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    Reason
                </p>

                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[var(--color-foreground)]">
                    {{ $academicRequest->reason }}
                </p>
            </div>

        </div>

        @if ($academicRequest->qr_code_token)
            <div class="mt-6 border-t border-[var(--color-border)] pt-6">
                <p class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">
                    QR Code Token
                </p>

                <p class="mt-2 break-all rounded-lg bg-[var(--color-surface-muted)] p-3 font-mono text-sm text-[var(--color-foreground)]">
                    {{ $academicRequest->qr_code_token }}
                </p>
            </div>
        @endif

    </div>

    {{-- Back --}}
    <div>
        <a
            href="{{ route('academic-requests.index') }}"
            class="inline-flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
        >
            ← Back to Requests
        </a>
    </div>

</div>
@endsection

