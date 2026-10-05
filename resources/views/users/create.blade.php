@extends('layouts.app')

@section('title', __('Add User'))

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    ```
    {{-- Page Header --}}
    <div>
        <a
            href="{{ route('users.index') }}"
            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-[var(--color-foreground-muted)] transition hover:text-[var(--color-primary)]">
            <svg
                class="h-4 w-4 rtl:rotate-180"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path d="M19 12H5" />
                <path d="M12 19l-7-7 7-7" />
            </svg>

            {{ __('Back to Users') }}
        </a>

        <h2 class="text-2xl font-semibold text-[var(--color-foreground)]">
            {{ __('Add User') }}
        </h2>

        <p class="mt-1 text-sm text-[var(--color-foreground-muted)]">
            {{ __('Create a new user account.') }}
        </p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
    <div
        class="rounded-lg border border-[var(--color-danger)]/30 bg-[color-mix(in_srgb,var(--color-danger)_8%,transparent)] p-4">
        <div class="flex gap-3">
            <svg
                class="mt-0.5 h-5 w-5 shrink-0 text-[var(--color-danger)]"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 8v4" />
                <path d="M12 16h.01" />
            </svg>

            <div>
                <p class="text-sm font-medium text-[var(--color-danger)]">
                    {{ __('Please correct the following errors:') }}
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-[var(--color-danger)]">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <div
        class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">
        <form
            action="{{ route('users.store') }}"
            method="POST"
            class="space-y-6 p-6 sm:p-8">
            @csrf

            {{-- Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Name') }}
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="{{ __('Enter full name') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                @error('name')
                <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label
                    for="email"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Email') }}
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="{{ __('Enter email address') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                @error('email')
                <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label
                    for="phone"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Phone') }}
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ old('phone') }}"
                    autocomplete="tel"
                    placeholder="{{ __('Enter phone number') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                @error('phone')
                <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label
                    for="password"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Password') }}
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Enter password') }}"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition placeholder:text-[var(--color-foreground-muted)] focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">

                <p class="mt-1.5 text-xs text-[var(--color-foreground-muted)]">
                    {{ __('Password must contain at least 8 characters.') }}
                </p>

                @error('password')
                <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label
                    for="role"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('Role') }}
                </label>

                <select
                    id="role"
                    name="role"
                    required
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">
                    <option value="">{{ __('Select role') }}</option>

                    <option value="admin" @selected(old('role')==='admin' )>
                        {{ __('Administrator') }}
                    </option>

                    <option value="instructor" @selected(old('role')==='instructor' )>
                        {{ __('Instructor') }}
                    </option>

                    <option value="student" @selected(old('role')==='student' )>
                        {{ __('Student') }}
                    </option>

                    <option value="employee" @selected(old('role')==='employee' )>
                        {{ __('Employee') }}
                    </option>
                </select>

                @error('role')
                <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- College --}}
            <div
                id="college-field"
                class="{{ old('role') === 'employee' ? '' : 'hidden' }}">
                <label
                    for="college_id"
                    class="mb-2 block text-sm font-medium text-[var(--color-foreground)]">
                    {{ __('College') }}
                </label>

                <select
                    id="college_id"
                    name="college_id"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-4 py-2.5 text-sm text-[var(--color-foreground)] outline-none transition focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20">
                    <option value="">{{ __('Select college') }}</option>

                    @foreach ($colleges as $college)
                    <option
                        value="{{ $college->id }}"
                        @selected((string) old('college_id')===(string) $college->id)
                        >
                        {{ $college->name }}
                    </option>
                    @endforeach
                </select>

                <p class="mt-1.5 text-xs text-[var(--color-foreground-muted)]">
                    {{ __('Required for employee accounts.') }}
                </p>

                @error('college_id')
                <p class="mt-1.5 text-sm text-[var(--color-danger)]">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Active Status --}}
            <div class="flex items-start gap-3">

                <input
                    type="hidden"
                    name="is_active"
                    value="0">

                <input
                    id="is_active"
                    name="is_active"
                    type="checkbox"
                    value="1"
                    @checked(old('is_active', true))
                    class="mt-1 h-4 w-4 rounded border-[var(--color-border)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]">

                <div>
                    <label
                        for="is_active"
                        class="text-sm font-medium text-[var(--color-foreground)]">
                        {{ __('Active account') }}
                    </label>

                    <p class="mt-0.5 text-xs text-[var(--color-foreground-muted)]">
                        {{ __('The user will be able to access the system.') }}
                    </p>
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('users.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-medium text-[var(--color-foreground)] transition hover:bg-[var(--color-surface-muted)]">
                    {{ __('Cancel') }}
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[var(--color-primary-hover)]">
                    {{ __('Create User') }}
                </button>

            </div>

        </form>
    </div>
    ```

</div>

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const roleSelect = document.getElementById('role');
        const collegeField = document.getElementById('college-field');
        const collegeSelect = document.getElementById('college_id');

        if (!roleSelect || !collegeField || !collegeSelect) {
            return;
        }

        const toggleCollegeField = () => {
            const isEmployee = roleSelect.value === 'employee';

            collegeField.classList.toggle('hidden', !isEmployee);
            collegeSelect.required = isEmployee;

            if (!isEmployee) {
                collegeSelect.value = '';
            }
        };

        roleSelect.addEventListener('change', toggleCollegeField);

        toggleCollegeField();
    });
</script>

@endpush

@endsection