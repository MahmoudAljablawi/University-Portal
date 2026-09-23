@extends('layouts.app')
@section('title','Audit Log')
@section('content')
<div class="mx-auto max-w-4xl space-y-6"><div><a href="{{ route('audit-logs.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[var(--color-foreground-muted)] hover:text-[var(--color-primary)]">? Back to Audit Log</a><h1 class="mt-3 text-2xl font-semibold text-[var(--color-foreground)]">Audit Log</h1><p class="mt-1 text-sm text-[var(--color-foreground-muted)]">View record details and related information.</p></div><div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]"><dl class="grid gap-6 px-6 py-6 sm:grid-cols-2 sm:px-8"><div><dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">User</dt><dd class="mt-1 break-words text-sm font-medium text-[var(--color-foreground)]">{{ optional($auditLog->user)->name ?? '?' }}</dd></div><div><dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">Action</dt><dd class="mt-1 break-words text-sm font-medium text-[var(--color-foreground)]">{{ $auditLog->action ?? '?' }}</dd></div><div><dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">Target</dt><dd class="mt-1 break-words text-sm font-medium text-[var(--color-foreground)]">{{ $auditLog->target_table ?? '?' }}</dd></div><div><dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">Target ID</dt><dd class="mt-1 break-words text-sm font-medium text-[var(--color-foreground)]">{{ $auditLog->target_id ?? '?' }}</dd></div><div><dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">IP address</dt><dd class="mt-1 break-words text-sm font-medium text-[var(--color-foreground)]">{{ $auditLog->ip_address ?? '?' }}</dd></div><div><dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-foreground-muted)]">Description</dt><dd class="mt-1 break-words text-sm font-medium text-[var(--color-foreground)]">{{ $auditLog->description ?? '?' }}</dd></div></dl><div class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] px-6 py-5 sm:flex-row sm:justify-end sm:px-8"><a href="{{ route('audit-logs.index') }}" class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-center text-sm">Back</a></div></div></div>
@endsection
@extends('layouts.app')

@section('title', 'Audit Log Details')

@section('content') <div class="mx-auto max-w-4xl space-y-6">


    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-foreground)]">
                Audit Log Details
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                View the details of a recorded system activity.
            </p>
        </div>

        <a
            href="{{ route('audit-logs.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] px-4 py-2 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]"
        >
            Back to Audit Logs
        </a>
    </div>

    {{-- Audit Log Information --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">

        <div class="border-b border-[var(--color-border)] px-6 py-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                        Activity Information
                    </h2>

                    <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                        Recorded audit information for this activity.
                    </p>
                </div>

                <span class="inline-flex rounded-md bg-[var(--color-surface-muted)] px-3 py-1 text-xs font-medium text-[var(--color-foreground)]">
                    #{{ $auditLog->id }}
                </span>
            </div>
        </div>

        <div class="grid gap-6 p-6 sm:grid-cols-2">

            {{-- User --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    User
                </p>

                @if($auditLog->user)
                    <div class="mt-1">
                        <p class="font-medium text-[var(--color-foreground)]">
                            {{ $auditLog->user->name }}
                        </p>

                        <p class="text-sm text-[var(--color-foreground-muted)]">
                            {{ $auditLog->user->email }}
                        </p>
                    </div>
                @else
                    <p class="mt-1 font-medium text-[var(--color-foreground)]">
                        System
                    </p>
                @endif
            </div>

            {{-- Action --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Action
                </p>

                <p class="mt-1 font-medium text-[var(--color-foreground)]">
                    {{ $auditLog->action ?? '—' }}
                </p>
            </div>

            {{-- IP Address --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    IP Address
                </p>

                <p class="mt-1 font-mono text-sm text-[var(--color-foreground)]">
                    {{ $auditLog->ip_address ?? '—' }}
                </p>
            </div>

            {{-- Created At --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Created At
                </p>

                <p class="mt-1 text-sm text-[var(--color-foreground)]">
                    {{ $auditLog->created_at?->format('Y-m-d H:i:s') ?? '—' }}
                </p>
            </div>

            {{-- Updated At --}}
            <div>
                <p class="text-sm text-[var(--color-foreground-muted)]">
                    Updated At
                </p>

                <p class="mt-1 text-sm text-[var(--color-foreground)]">
                    {{ $auditLog->updated_at?->format('Y-m-d H:i:s') ?? '—' }}
                </p>
            </div>

        </div>

        {{-- Description --}}
        <div class="border-t border-[var(--color-border)] p-6">
            <p class="text-sm text-[var(--color-foreground-muted)]">
                Description
            </p>

            <div class="mt-3 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4">
                <p class="whitespace-pre-wrap break-words text-sm leading-6 text-[var(--color-foreground)]">
                    {{ $auditLog->description ?? 'No description available.' }}
                </p>
            </div>
        </div>

    </div>

</div>


@endsection
