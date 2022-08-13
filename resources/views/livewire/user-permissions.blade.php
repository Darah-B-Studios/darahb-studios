<div class="py-6 px-4">
    <x-jet-button wire:click="showCreateModal">{{ __('Create') }}</x-jet-button>

    {{-- create page modal --}}
    <x-jet-dialog-modal wire:model="show_create_modal">
        <x-slot name="title">
            @if ($model)
                {{ __('Update') }}
            @else
                {{ __('Create') }}
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <x-jet-input wire:model.debounce.800ms="role" id="role" type="text" class="mt-1 block w-full" />
                <x-jet-input-error for="role" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="route_name" value="{{ __('Route name') }}" />
                <select name="route_name" id="route_name"
                    class="w-full rounded-md border-1 border-gray-300 outline-1 focus:outline-indigo-400 focus:border-transparent focus:shadow-sm text-gray-500 mt-1"
                    wire:model.debounce.800ms="route_name">
                    <option value="">--select route--</option>
                    @foreach (App\Models\UserPermission::routeNameList() as $permission)
                        <option value="{{ $permission }}">
                            {{ Illuminate\Support\Str::replace('-', ' ', $permission) }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="route_name" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            @if ($model)
                <x-jet-button wire:click="update({{ $model }})">{{ __('Update') }}</x-jet-button>
            @else
                <x-jet-button wire:click="create">{{ __('Save') }}</x-jet-button>
            @endif

            <x-jet-secondary-button wire:click="$toggle('show_create_modal')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Delete page Confirmation Modal -->
    <x-jet-dialog-modal wire:model="show_delete_modal">
        <x-slot name="title">
            {{ __('Delete') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item? This action cannot be reversed.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('show_delete_modal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete({{ $model }})"
                wire:loading.attr="disabled">
                {{ __('Delete page') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- pages data --}}
    <table class="min-w-full divide-y divide-gray-200 mt-8">
        <thead>
            <tr>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Role name</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Route name</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Options</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($user_permissions as $user_permission)
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $user_permission->role }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap capitalize">
                        {{ Illuminate\Support\Str::replace('-', ' ', $user_permission->route_name) }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        <x-jet-button wire:click="edit({{ $user_permission }})">edit</x-jet-button>
                        <x-jet-danger-button wire:click="showDeleteModal({{ $user_permission }})">delete
                        </x-jet-danger-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap span-4">No data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination links --}}
    {{ $user_permissions->links() }}
</div>
