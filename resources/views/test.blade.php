@extends('layouts.app')

@section('title', 'UI Components')

@section('content')

    <div class="space-y-8">

        <x-page-header
            title="UI Components"
            description="Testing the frontend component system."
        >
            <x-slot:actions>
                <x-button>
                    Add Student
                </x-button>
            </x-slot:actions>
        </x-page-header>


        <div class="flex flex-wrap gap-3">
            <x-button>
                Primary
            </x-button>

            <x-button variant="secondary">
                Secondary
            </x-button>

            <x-button variant="success">
                Success
            </x-button>

            <x-button variant="danger">
                Delete
            </x-button>

            <x-button variant="ghost">
                Cancel
            </x-button>
        </div>


        <div class="flex flex-wrap gap-3">
            <x-badge type="primary">Pending</x-badge>
            <x-badge type="success">Approved</x-badge>
            <x-badge type="warning">Waiting</x-badge>
            <x-badge type="danger">Rejected</x-badge>
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
                        Active
                    </x-badge>
                </td>

                <td class="px-4 py-4">
                    <x-button variant="ghost">
                        Edit
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
                        Pending
                    </x-badge>
                </td>

                <td class="px-4 py-4">
                    <x-button variant="ghost">
                        Edit
                    </x-button>
                </td>
            </tr>

        </x-table>

    </div>

@endsection