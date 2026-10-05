@extends('layouts.app')

@section('title', __('Audit Logs'))

@section('content')
<div class="mx-au{{ __('to') }} max-w-7xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-semibold text-[var(--color-foreground)]">
            {{ __('Audit Logs') }}
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Review system activities and recorded user actions.') }}
        </p>
    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('audit-logs.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

            {{-- Search --}}
            <div class="xl:col-span-2">
                <label
                    for="search"
                    class="mb-1.5 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Search') }}
                </label>

                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search action, table, description, IP, user name or email...') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">
            </div>

            {{-- Action --}}
            <div>
                <label
                    for="action"
                    class="mb-1.5 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Action') }}
                </label>

                <select
                    id="action"
                    name="action"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">
                        {{ __('All Actions') }}
                    </option>

                    @foreach ($actions as $action)
                    <option
                        value="{{ $action }}"
                        @selected(request('action')===$action)>
                        {{ ucfirst($action) }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- Target Table --}}
            <div>
                <label
                    for="target_table"
                    class="mb-1.5 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Target Table') }}
                </label>

                <select
                    id="target_table"
                    name="target_table"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">
                        {{ __('All Tables') }}
                    </option>

                    @foreach ($targetTables as $table)
                    <option
                        value="{{ $table }}"
                        @selected(request('target_table')===$table)>
                        {{ $table }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 md:col-span-2 xl:col-span-4">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]">
                    {{ __('Search') }}
                </button>

                <a
                    href="{{ route('audit-logs.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm font-semibold text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]">
                    {{ __('Reset') }}
                </a>

            </div>

        </form>
    </div>

    {{-- Results Summary --}}
    <div>
        <p class="text-sm text-[var(--color-foreground-muted)]">
            {{ __('Showing') }}
            <span class="font-semibold text-[var(--color-foreground)]">
                {{ $auditLogs->firstItem() ?? 0 }}
            </span>
            -
            <span class="font-semibold text-[var(--color-foreground)]">
                {{ $auditLogs->lastItem() ?? 0 }}
            </span>
            {{ __('of') }}
            <span class="font-semibold text-[var(--color-foreground)]">
                {{ $auditLogs->total() }}
            </span>
            {{ __('audit logs') }}
        </p>
    </div>

    {{-- Audit Logs Table --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">

        @if ($auditLogs->isNotEmpty())

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('ID') }}
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('User') }}
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('Action') }}
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('Target') }}
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('IP Address') }}
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('Date') }}
                        </th>

                        <th class="px-6 py-3 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            {{ __('Actions') }}
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @foreach ($auditLogs as $auditLog)

                    <tr class="transition hover:bg-[var(--color-surface-muted)]">

                        {{-- ID --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                            #{{ $auditLog->id }}
                        </td>

                        {{-- User --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($auditLog->user)

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
                                {{ __('System') }}
                            </span>

                            @endif

                        </td>

                        {{-- Action --}}
                        <td class="whitespace-nowrap px-6 py-4">
                            @php
                            $actionClasses = match (strtolower($auditLog->action)) {
                            'create', 'created' =>
                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',

                            'update', 'updated' =>
                            'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',

                            'delete', 'deleted' =>
                            'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',

                            default =>
                            'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                            };
                            @endphp

                            <span class="inline-flex rounded-md px-2.5 py-1 text-xs font-semibold {{ $actionClasses }}">
                                {{ $auditLog->action }}
                            </span>
                        </td>

                        {{-- Target --}}
                        <td class="px-6 py-4">

                            <div class="text-sm font-medium text-[var(--color-foreground)]">
                                {{ $auditLog->target_table ?? '—' }}
                            </div>

                            @if ($auditLog->target_id)
                            <div class="mt-0.5 text-xs text-[var(--color-foreground-muted)]">
                                ID: {{ $auditLog->target_id }}
                            </div>
                            @endif

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
                                class="text-sm font-medium text-[var(--color-primary)] transition hover:text-[var(--color-primary-hover)]">
                                {{ __('View') }}
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
                {{ __('No audit logs found') }}
            </h3>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('Try changing your search or filter criteria.') }}
            </p>

        </div>

        @endif

    </div>

    {{-- Pagination --}}
    @if ($auditLogs->hasPages())
    <div class="flex justify-center">
        {{ $auditLogs->onEachSide(1)->links() }}
    </div>
    @endif

</div>
@endsection