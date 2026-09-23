@extends('layouts.app')

@section('title', 'Enrollments')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-semibold text-[var(--color-foreground)]">Enrollments</h1><p class="mt-1 text-sm text-[var(--color-foreground-muted)]">View student enrollment records</p></div>
        <a href="{{ route('enrollments.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--color-primary)] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">Add Enrollment</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]"><div class="overflow-x-auto"><table class="min-w-full divide-y divide-[var(--color-border)]"><thead class="bg-[var(--color-surface-muted)]"><tr><th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">Student</th><th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">Course</th><th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">Section</th><th class="px-6 py-4 text-start text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">Status</th><th class="px-6 py-4 text-end text-xs font-semibold uppercase tracking-wider text-[var(--color-foreground-muted)]">Actions</th></tr></thead><tbody class="divide-y divide-[var(--color-border)]">
    @forelse ($enrollments as $enrollment)
    <tr class="transition hover:bg-[var(--color-surface-muted)]"><td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">{{ optional($enrollment->student)->name ?? '—' }}</td><td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">{{ optional(optional($enrollment->section)->course)->name ?? '—' }}</td><td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">{{ optional($enrollment->section)->section_number ?? '—' }}</td><td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-foreground)]">{{ ucfirst($enrollment->status) }}</td><td class="whitespace-nowrap px-6 py-4"><div class="flex items-center justify-end gap-2"><a href="{{ route('enrollments.show', $enrollment) }}" class="rounded-lg px-3 py-2 text-sm font-medium text-[var(--color-primary)] hover:bg-[var(--color-primary)]/10">View</a><a href="{{ route('enrollments.edit', $enrollment) }}" class="rounded-lg px-3 py-2 text-sm font-medium text-[var(--color-foreground-muted)] hover:bg-[var(--color-surface-muted)]">Edit</a> <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?')">@csrf @method('DELETE')<button class="rounded-lg px-3 py-2 text-sm font-medium text-[var(--color-danger)] hover:bg-[var(--color-danger)]/10">Delete</button></form></div></td></tr>
    @empty
    <tr><td colspan="5" class="px-6 py-14 text-center"><p class="text-sm font-medium text-[var(--color-foreground)]">No records found</p><p class="mt-1 text-sm text-[var(--color-foreground-muted)]">There are no records to display yet.</p></td></tr>
    @endforelse
    </tbody></table></div></div>
</div>
@endsection
