
@extends('layouts.app')

@section('title', 'Academic Requests')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                Academic Requests
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                View and manage academic service requests.
            </p>
        </div>

        @if (auth()->user()->role === 'student')
            <a
                href="{{ route('academic-requests.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]">
                New Request
            </a>
        @endif
    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

        <form
            method="GET"
            action="{{ route('academic-requests.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

            {{-- Search --}}
            <div class="xl:col-span-2">
                <label
                    for="search"
                    class="mb-1.5 block text-sm font-medium text-[var(--color-foreground)]">
                    Search
                </label>

                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by request type, reason{{ auth()->user()->role === 'admin' ? ', student name or email' : '' }}..."
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">
            </div>

            {{-- Request Type --}}
            <div>
                <label
                    for="request_type"
                    class="mb-1.5 block text-sm font-medium text-[var(--color-foreground)]">
                    Request Type
                </label>

                <select
                    id="request_type"
                    name="request_type"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">All Request Types</option>

                    @foreach ($requestTypes as $type)
                        <option
                            value="{{ $type }}"
                            @selected(request('request_type') === $type)>
                            {{ $type }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Status --}}
            <div>
                <label
                    for="status"
                    class="mb-1.5 block text-sm font-medium text-[var(--color-foreground)]">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-3 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                    <option value="">All Statuses</option>

                    @foreach ($statuses as $status)
                        <option
                            value="{{ $status }}"
                            @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 md:col-span-2 xl:col-span-4">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]">
                    Search
                </button>

                <a
                    href="{{ route('academic-requests.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm font-semibold text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]">
                    Reset
                </a>

            </div>

        </form>
    </div>

    {{-- Results Summary --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-[var(--color-foreground-muted)]">
            Showing
            <span class="font-semibold text-[var(--color-foreground)]">
                {{ $requests->firstItem() ?? 0 }}
            </span>
            -
            <span class="font-semibold text-[var(--color-foreground)]">
                {{ $requests->lastItem() ?? 0 }}
            </span>
            of
            <span class="font-semibold text-[var(--color-foreground)]">
                {{ $requests->total() }}
            </span>
            requests
        </p>
    </div>

    {{-- Requests Table --}}
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">
                    <tr>

                        @if (auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                                Student
                            </th>
                        @endif

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Request Type
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Reason
                        </th>

                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Status
                        </th>

                        <th class="px-6 py-3 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">
                            Actions
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($requests as $requestItem)

                        <tr class="transition hover:bg-[var(--color-surface-muted)]">

                            {{-- Student --}}
                            @if (auth()->user()->role === 'admin')
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-[var(--color-foreground)]">
                                    {{ $requestItem->student?->name ?? '—' }}
                                </td>
                            @endif

                            {{-- Request Type --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-[var(--color-foreground)]">
                                {{ $requestItem->request_type }}
                            </td>

                            {{-- Reason --}}
                            <td class="max-w-xs px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                                <div
                                    class="truncate"
                                    title="{{ $requestItem->reason }}">
                                    {{ $requestItem->reason }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @switch($requestItem->status)

                                    @case('approved')
                                        <span class="inline-flex rounded-full bg-[var(--color-success)]/10 px-2.5 py-1 text-xs font-semibold text-[var(--color-success)]">
                                            Approved
                                        </span>
                                        @break

                                    @case('rejected')
                                        <span class="inline-flex rounded-full bg-[var(--color-danger)]/10 px-2.5 py-1 text-xs font-semibold text-[var(--color-danger)]">
                                            Rejected
                                        </span>
                                        @break

                                    @default
                                        <span class="inline-flex rounded-full bg-[var(--color-warning)]/10 px-2.5 py-1 text-xs font-semibold text-[var(--color-warning)]">
                                            Pending
                                        </span>

                                @endswitch

                            </td>

                            {{-- Actions --}}
                            @php
                                $canEditOrDelete =
                                    auth()->user()->role === 'admin' ||
                                    (
                                        auth()->user()->role === 'student' &&
                                        auth()->user()->id === $requestItem->student_id &&
                                        $requestItem->status === 'pending'
                                    );
                            @endphp

                            <x-table-actions
                                :model="$requestItem"
                                itemName="Academic Request #{{ $requestItem->id }}"
                                showRoute="academic-requests.show"
                                editRoute="academic-requests.edit"
                                destroyRoute="academic-requests.destroy"
                                :showEdit="$canEditOrDelete"
                                :showDelete="$canEditOrDelete"
                                deleteConfirm="Are you sure you want to delete this academic request?"
                            />

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}"
                                class="px-6 py-12 text-center">

                                <div class="text-sm font-medium text-[var(--color-foreground)]">
                                    No academic requests found.
                                </div>

                                <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                                    Try changing your search or filter criteria.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

    {{-- Pagination --}}
    @if ($requests->hasPages())
        <div class="flex justify-center">
            {{ $requests->onEachSide(1)->links() }}
        </div>
    @endif

</div>
@endsection

