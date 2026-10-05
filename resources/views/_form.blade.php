@extends('layouts.app')
@section('title', __($editing ? 'Edit '.$heading : 'Create '.$heading))
@section('content')
<div class="mx-auto max-w-3xl space-y-6"><div><a href="{{ route($backRoute) }}" class="text-sm text-[var(--color-foreground-muted)] hover:text-[var(--color-primary)]">{{ __('Back') }}</a><h1 class="mt-3 text-2xl font-semibold text-[var(--color-foreground)]">{{ __($editing ? 'Edit '.$heading : 'Create '.$heading) }}</h1></div>@if($errors->any())<x-validation-errors /></div>@endif
<div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]"><form method="POST" action="{{ $editing ? route($updateRoute,$item) : route($storeRoute) }}" class="space-y-6 p-6 sm:p-8">@csrf @if($editing) @method('PUT') @endif
{!! $fields !!}<div class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-6 sm:flex-row sm:justify-end"><a href="{{ route($backRoute) }}" class="rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-center text-sm">{{ __('Cancel') }}</a><button class="rounded-lg bg-[var(--color-primary)] px-5 py-2.5 text-sm font-medium text-white">{{ __($editing ? 'Save Changes' : 'Create') }}</button></div></form></div></div>
@endsection
