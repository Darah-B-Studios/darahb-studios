<div class="py-6 px-4">
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
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input wire:model.debounce.800ms="name" id="name" type="text" class="mt-1 block w-full" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <select name="role" id="role"
                    class="w-full rounded-md border-1 border-gray-300 outline-1 focus:outline-indigo-400 focus:border-transparent focus:shadow-sm text-gray-500 mt-1"
                    wire:model.debounce.800ms="role">
                    <option value="">--select role--</option>
                    @foreach (App\Models\User::userRoleList() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="role" class="mt-2" />
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

    <!-- Delete Confirmation Modal -->
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
                    Name</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Email </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Role </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Options</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($users as $user)
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        <span class="bg-blue-200 rounded p-1 text-xs text-blue-700">{{ $user->role }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        <x-jet-button wire:click="edit({{ $user }})">edit</x-jet-button>
                        <x-jet-danger-button wire:click="showDeleteModal({{ $user }})">delete
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
    {{ $users->links() }}
</div>
