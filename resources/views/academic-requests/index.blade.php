@extends('layouts.app')

@section('title', __('Academic Requests'))

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
                {{ __('Academic Requests') }}
            </h1>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                {{ __('View and manage academic service requests.') }}
            </p>
        </div>

        @if (auth()->user()->role === 'student')
        <a
            href="{{ route('academic-requests.create') }}"
            class="inline-flex items-center justify-center gap-2
                       rounded-lg bg-[var(--color-primary)]
                       px-4 py-2.5 text-sm font-medium text-white
                       transition hover:bg-[var(--color-primary-hover)]">

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14" />
            </svg>

            {{ __('New Request') }}
        </a>
        @endif

    </div>


    {{-- Filters --}}
    <div
        class="rounded-xl border border-[var(--color-border)]
               bg-[var(--color-surface)] p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('academic-requests.index') }}"
            class="space-y-4">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- Search --}}
                <div class="md:col-span-1">

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium
                               text-[var(--color-foreground)]">
                        {{ __('Search') }}
                    </label>

                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="{{ in_array(auth()->user()->role, ['admin', 'employee'])
                            ? 'Student name, email, type or reason'
                            : 'Request type or reason' }}"
                        class="w-full rounded-lg
                               border border-[var(--color-border)]
                               bg-[var(--color-surface)]
                               px-4 py-2.5 text-sm
                               text-[var(--color-foreground)]
                               outline-none transition
                               focus:border-[var(--color-primary)]
                               focus:ring-2
                               focus:ring-[var(--color-primary)]/20">

                </div>


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
                        class="w-full rounded-lg
                               border border-[var(--color-border)]
                               bg-[var(--color-surface)]
                               px-4 py-2.5 text-sm
                               text-[var(--color-foreground)]
                               outline-none transition
                               focus:border-[var(--color-primary)]
                               focus:ring-2
                               focus:ring-[var(--color-primary)]/20">

                        <option value="">
                            {{ __('All Types') }}
                        </option>

                        @foreach ($requestTypes as $type)

                        <option
                            value="{{ $type }}"
                            @selected(request('request_type')===$type)>
                            {{ match ($type) {
                                    'grade_inquiry' => __('Grade Inquiry'),
                                    'enrollment_pause' => __('Enrollment Pause'),
                                    'objection' => __('Objection'),
                                    default => __(ucfirst(str_replace('_', ' ', $type))),
                                } }}
                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium
                               text-[var(--color-foreground)]">
                        {{ __('Status') }}
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg
                               border border-[var(--color-border)]
                               bg-[var(--color-surface)]
                               px-4 py-2.5 text-sm
                               text-[var(--color-foreground)]
                               outline-none transition
                               focus:border-[var(--color-primary)]
                               focus:ring-2
                               focus:ring-[var(--color-primary)]/20">

                        <option value="">
                            {{ __('All Statuses') }}
                        </option>

                        @foreach ($statuses as $status)

                        <option
                            value="{{ $status }}"
                            @selected(request('status')===$status)>
                            {{ __(ucfirst($status)) }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- Filter Actions --}}
            <div class="flex gap-2">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-[var(--color-primary)]
                           px-4 py-2.5 text-sm font-medium text-white
                           transition hover:bg-[var(--color-primary-hover)]">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-4-4" />
                    </svg>

                    {{ __('Search') }}
                </button>


                @if (
                request()->filled('search') ||
                request()->filled('request_type') ||
                request()->filled('status')
                )

                <a
                    href="{{ route('academic-requests.index') }}"
                    class="inline-flex items-center justify-center
                               rounded-lg
                               border border-[var(--color-border)]
                               bg-[var(--color-surface)]
                               px-4 py-2.5 text-sm font-medium
                               text-[var(--color-foreground)]
                               transition
                               hover:bg-[var(--color-surface-muted)]">
                    {{ __('Reset') }}
                </a>

                @endif

            </div>

        </form>

    </div>


    {{-- Results Summary --}}
    <div>
        <p class="text-sm text-[var(--color-foreground-muted)]">

            {{ __('Showing') }}

            <span class="font-medium text-[var(--color-foreground)]">
                {{ $requests->firstItem() ?? 0 }}
            </span>

            {{ __('to') }}

            <span class="font-medium text-[var(--color-foreground)]">
                {{ $requests->lastItem() ?? 0 }}
            </span>

            {{ __('of') }}

            <span class="font-medium text-[var(--color-foreground)]">
                {{ $requests->total() }}
            </span>

            {{ __('academic requests') }}

        </p>
    </div>


    {{-- Requests Table --}}
    <div
        class="overflow-hidden rounded-xl
               border border-[var(--color-border)]
               bg-[var(--color-surface)] shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-[var(--color-border)]">

                <thead class="bg-[var(--color-surface-muted)]">

                    <tr>

                        {{-- Student --}}
                        @if (in_array(auth()->user()->role, ['admin', 'employee']))

                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs
                                       font-semibold uppercase
                                       tracking-wider
                                       text-[var(--color-foreground-muted)]">
                            {{ __('Student') }}
                        </th>

                        @endif


                        {{-- Request Type --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            {{ __('Request Type') }}
                        </th>


                        {{-- Reason --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            {{ __('Reason') }}
                        </th>


                        {{-- Status --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-start text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            {{ __('Status') }}
                        </th>


                        {{-- Actions --}}
                        <th
                            scope="col"
                            class="px-6 py-4 text-end text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-[var(--color-foreground-muted)]">
                            {{ __('Actions') }}
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($requests as $requestItem)

                    <tr
                        class="transition
                                   hover:bg-[var(--color-surface-muted)]/50">

                        {{-- Student --}}
                        @if (in_array(auth()->user()->role, ['admin', 'employee']))

                        <td class="whitespace-nowrap px-6 py-4">

                            <div>

                                <div
                                    class="text-sm font-medium
                                                   text-[var(--color-foreground)]">
                                    {{ $requestItem->student?->name ?? '—' }}
                                </div>

                                @if ($requestItem->student?->email)

                                <div
                                    class="mt-1 text-xs
                                                       text-[var(--color-foreground-muted)]">
                                    {{ $requestItem->student->email }}
                                </div>

                                @endif

                            </div>

                        </td>

                        @endif


                        {{-- Request Type --}}
                        <td
                            class="whitespace-nowrap px-6 py-4 text-sm
                                       text-[var(--color-foreground)]">

                            {{ match ($requestItem->request_type) {
                                    'grade_inquiry' => 'Grade Inquiry',
                                    'enrollment_pause' => 'Enrollment Pause',
                                    'objection' => 'Objection',
                                    default => ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $requestItem->request_type
                                        )
                                    ),
                                } }}

                        </td>


                        {{-- Reason --}}
                        <td
                            class="max-w-xs px-6 py-4 text-sm
                                       text-[var(--color-foreground-muted)]">

                            <div
                                class="truncate"
                                title="{{ $requestItem->reason }}">
                                {{ $requestItem->reason ?: '—' }}
                            </div>

                        </td>


                        {{-- Status --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @switch($requestItem->status)

                            @case('approved')

                            <span
                                class="inline-flex items-center gap-1.5
                                                   rounded-full
                                                   bg-[var(--color-success)]/10
                                                   px-2.5 py-1 text-xs
                                                   font-semibold
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
                                                   px-2.5 py-1 text-xs
                                                   font-semibold
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
                                                   px-2.5 py-1 text-xs
                                                   font-semibold
                                                   text-[var(--color-warning)]">

                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                                       bg-[var(--color-warning)]">
                                </span>

                                {{ __('Pending') }}
                            </span>

                            @endswitch

                        </td>


                        {{-- Actions --}}


                        @php
                        $user = auth()->user();

                        $isStudentOwner =
                        $user->role === 'student' &&
                        $user->id === $requestItem->student_id;

                        $canEdit =
                        $isStudentOwner &&
                        $requestItem->status === 'pending';

                        $canDelete =
                        $isStudentOwner &&
                        $requestItem->status === 'pending';

                        $canProcess =
                        $user->role === 'employee' &&
                        $requestItem->status === 'pending';
                        @endphp

                        <div class="flex items-center justify-end gap-2">

                            {{-- Standard CRUD Actions --}}
                            <x-table-actions
                                :model="$requestItem"
                                itemName="Academic Request #{{ $requestItem->id }}"
                                showRoute="academic-requests.show"
                                editRoute="academic-requests.edit"
                                destroyRoute="academic-requests.destroy"
                                :showEdit="$canEdit"
                                :showDelete="$canDelete"
                                deleteConfirm="Are you sure you want to delete this academic request?" />




                        </div>



                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="{{ in_array(auth()->user()->role, ['admin', 'employee']) ? 5 : 4 }}"
                            class="px-6 py-12 text-center">

                            <div
                                class="text-sm font-medium
                                           text-[var(--color-foreground)]">
                                {{ __('No academic requests found.') }}
                            </div>

                            <p
                                class="mt-1 text-sm
                                           text-[var(--color-foreground-muted)]">
                                {{ __('Try changing your search or filter criteria.') }}
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