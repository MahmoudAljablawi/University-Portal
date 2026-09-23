@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content') <div class="mx-auto max-w-7xl space-y-6">


    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-semibold text-[var(--color-foreground)]">
            Audit Logs
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Review system activities and recorded user actions.
        </p>
    </div>

    {{-- Audit Logs Table --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">

        @if($auditLogs->isNotEmpty())

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-border)]">

                    <thead class="bg-[var(--color-surface-muted)]">
                        <tr>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                ID
                            </th>

                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                User
                            </th>

                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                Action
                            </th>

                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                IP Address
                            </th>

                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                Date
                            </th>

                            <th class="px-6 py-3 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[var(--color-border)]">

                        @foreach($auditLogs as $auditLog)
                            <tr class="transition hover:bg-[var(--color-surface-muted)]">

                                {{-- ID --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    #{{ $auditLog->id }}
                                </td>

                                {{-- User --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if($auditLog->user)
                                        <div>
                                            <p class="text-sm font-medium text-[var(--color-foreground)]">
                                                {{ $auditLog->user->name }}
                                            </p>

                                            <p class="text-xs text-[var(--color-foreground-muted)]">
                                                {{ $auditLog->user->email }}
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-sm text-[var(--color-foreground-muted)]">
                                            System
                                        </span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-md bg-[var(--color-surface-muted)] px-2.5 py-1 text-xs font-medium text-[var(--color-foreground)]">
                                        {{ $auditLog->action }}
                                    </span>
                                </td>

                                {{-- IP --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    {{ $auditLog->ip_address ?? '—' }}
                                </td>

                                {{-- Date --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                    {{ $auditLog->created_at?->format('Y-m-d H:i') ?? '—' }}
                                </td>

                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4 text-end">
                                    <a
                                        href="{{ route('audit-logs.show', $auditLog) }}"
                                        class="text-sm font-medium text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]"
                                    >
                                        View
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        @else

            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">
                <h3 class="text-sm font-semibold text-[var(--color-foreground)]">
                    No audit logs found
                </h3>

                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                    There are no recorded activities yet.
                </p>
            </div>

        @endif

    </div>

</div>


@endsection
