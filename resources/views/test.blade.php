@extends('layouts.app')

@section('title', __('UI Components'))

@section('content')

    <div class="space-y-8">

        <x-page-header
            title="{{ __('UI Components') }}"
            description="Testing the frontend component system."
        >
            <x-slot:actions>
                <x-button>
                    {{ __('Add Student') }}
                </x-button>
            </x-slot:actions>
        </x-page-header>


        <div class="flex flex-wrap gap-3">
            <x-button>
                {{ __('Primary') }}
            </x-button>

            <x-button variant="secondary">
                {{ __('Secondary') }}
            </x-button>

            <x-button variant="success">
                {{ __('Success') }}
            </x-button>

            <x-button variant="danger">
                {{ __('Delete') }}
            </x-button>

            <x-button variant="ghost">
                {{ __('Cancel') }}
            </x-button>
        </div>


        <div class="flex flex-wrap gap-3">
            <x-badge type="primary">{{ __('Pending') }}</x-badge>
            <x-badge type="success">{{ __('Approved') }}</x-badge>
            <x-badge type="warning">{{ __('Waiting') }}</x-badge>
            <x-badge type="danger">{{ __('Rejected') }}</x-badge>
        </div>


        <x-table :headers="['Name', 'Email', 'Status', 'Actions']">

            <tr>
                <td class="px-4 py-4 text-sm text-[var(--color-foreground)]">
                    Ahmed
                </td>

                <td class="px-4 py-4 text-sm text-[var(--color-foreground-muted)]">
                    ahmed@example.com
                </td>

                <td class="px-4 py-4">
                    <x-badge type="success">
                        {{ __('Active') }}
                    </x-badge>
                </td>

                <td class="px-4 py-4">
                    <x-button variant="ghost">
                        {{ __('Edit') }}
                    </x-button>
                </td>
            </tr>

            <tr>
                <td class="px-4 py-4 text-sm text-[var(--color-foreground)]">
                    Sara
                </td>

                <td class="px-4 py-4 text-sm text-[var(--color-foreground-muted)]">
                    sara@example.com
                </td>

                <td class="px-4 py-4">
                    <x-badge type="warning">
                        {{ __('Pending') }}
                    </x-badge>
                </td>

                <td class="px-4 py-4">
                    <x-button variant="ghost">
                        {{ __('Edit') }}
                    </x-button>
                </td>
            </tr>

        </x-table>

    </div>

@endsection