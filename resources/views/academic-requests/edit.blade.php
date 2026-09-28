
@extends('layouts.app')

@section('title', 'Edit Academic Request')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-foreground)]">
            Edit Academic Request
        </h1>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            Update the request according to your role and permissions.
        </p>
    </div>

    {{-- Request Summary --}}
    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-5">

        <div class="grid gap-4 sm:grid-cols-2">

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
                    Current Status
                </p>

                <p class="mt-1 text-sm font-medium text-[var(--color-foreground)]">
                    {{ ucfirst($academicRequest->status) }}
                </p>
            </div>

        </div>

    </div>

    {{-- Admin Form --}}
    @if (auth()->user()->role === 'admin')

        <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

            <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                Review Request
            </h2>

            <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
                Approve or reject this academic request.
            </p>

            <form
                method="POST"
                action="{{ route('academic-requests.update', $academicRequest) }}"
                class="mt-6 space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >
                        <option value="pending" @selected(old('status', $academicRequest->status) === 'pending')>
                            Pending
                        </option>

                        <option value="approved" @selected(old('status', $academicRequest->status) === 'approved')>
                            Approved
                        </option>

                        <option value="rejected" @selected(old('status', $academicRequest->status) === 'rejected')>
                            Rejected
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Admin Notes --}}
                <div>
                    <label
                        for="admin_notes"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Admin Notes
                    </label>

                    <textarea
                        id="admin_notes"
                        name="admin_notes"
                        rows="4"
                        maxlength="255"
                        placeholder="Optional notes..."
                        class="w-full resize-y rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >{{ old('admin_notes', $academicRequest->admin_notes ?? '') }}</textarea>

                    @error('admin_notes')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                    <a
                        href="{{ route('academic-requests.show', $academicRequest) }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Update Request
                    </button>

                </div>

            </form>

        </div>

    {{-- Student Form --}}
    @elseif (
        auth()->user()->role === 'student' &&
        auth()->user()->id === $academicRequest->student_id &&
        $academicRequest->status === 'pending'
    )

        <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

            <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                Request Information
            </h2>

            <form
                method="POST"
                action="{{ route('academic-requests.update', $academicRequest) }}"
                class="mt-6 space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Request Type --}}
                <div>
                    <label
                        for="request_type"
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Request Type
                    </label>

                    <input
                        id="request_type"
                        name="request_type"
                        type="text"
                        maxlength="100"
                        value="{{ old('request_type', $academicRequest->request_type) }}"
                        required
                        class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >

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
                        class="mb-2 block text-sm font-medium text-[var(--color-foreground)]"
                    >
                        Reason
                    </label>

                    <textarea
                        id="reason"
                        name="reason"
                        rows="6"
                        required
                        class="w-full resize-y rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-3 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20"
                    >{{ old('reason', $academicRequest->reason) }}</textarea>

                    @error('reason')
                        <p class="mt-1 text-sm text-[var(--color-danger)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                    <a
                        href="{{ route('academic-requests.show', $academicRequest) }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:bg-[var(--color-surface-muted)]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--color-primary-hover)]"
                    >
                        Update Request
                    </button>

                </div>

            </form>

        </div>

    @endif

</div>
@endsection

