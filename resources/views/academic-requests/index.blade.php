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

                        @if (auth()->user()->role === 'admin')
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-[var(--color-foreground)]">
                            {{ $requestItem->student?->name ?? '—' }}
                        </td>
                        @endif

                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-[var(--color-foreground)]">
                            {{ $requestItem->request_type }}
                        </td>

                        <td class="max-w-xs px-6 py-4 text-sm text-[var(--color-foreground-muted)]">
                            <div class="truncate">
                                {{ $requestItem->reason }}
                            </div>
                        </td>

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

                        @php
                        $canEditOrDelete = auth()->user()->role === 'admin' ||
                        (auth()->user()->role === 'student' &&
                        auth()->user()->id === $requestItem->student_id &&
                        $requestItem->status === 'pending');
                        @endphp

                        @php
                        $canEditOrDelete = auth()->user()->role === 'admin' ||
                        (auth()->user()->role === 'student' &&
                        auth()->user()->id === $requestItem->student_id &&
                        $requestItem->status === 'pending');
                        @endphp

                        <x-table-actions
                            :model="$requestItem"
                            itemName="Academic Request #{{ $requestItem->id }}"
                            showRoute="academic-requests.show"
                            editRoute="academic-requests.edit"
                            destroyRoute="academic-requests.destroy"
                            :showEdit="$canEditOrDelete"
                            :showDelete="$canEditOrDelete"
                            deleteConfirm="Are you sure you want to delete this academic request?" />
                    </tr>

                    @empty

                    <tr>
                        <td
                            colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}"
                            class="px-6 py-12 text-center text-sm text-[var(--color-foreground-muted)]">
                            No academic requests found.
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection