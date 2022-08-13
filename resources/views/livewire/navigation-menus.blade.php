<div class="py-6 px-4">
    <x-jet-button wire:click="showCreateModal">{{ __('Create menu') }}</x-jet-button>

    {{-- create page modal --}}
    <x-jet-dialog-modal wire:model="show_create_modal">
        <x-slot name="title">
            @if ($navigation_menu)
                {{ __('Update ' . $navigation_menu->label) }}
            @else
                {{ __('Create new menu') }}
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="label" value="{{ __('Label') }}" />
                <x-jet-input wire:model.debounce.800ms="label" id="label" type="text" class="mt-1 block w-full" />
                <x-jet-input-error for="label" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <select name="slug" id="slug"
                    class="w-full rounded-md border-1 border-gray-300 outline-1 focus:outline-indigo-400 focus:border-transparent focus:shadow-sm text-gray-500 mt-1"
                    wire:model.debounce.800ms="slug">
                    @foreach ($pages as $page)
                        <option value="{{ $page->slug }}">{{ $page->title }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="slug" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <x-jet-input wire:model.debounce.800ms="type" type="text" name="type" id="type"
                    class="mt-1 block w-full" />
            </div>
            <div class="mt-4">
                <x-jet-label for="sequence" value="{{ __('Sequence') }}" />
                <x-jet-input wire:model.debounce.800ms="sequence" type="number" name="sequence" id="sequence"
                    class="mt-1 block w-full" />
            </div>
        </x-slot>

        <x-slot name="footer">
            @if ($navigation_menu)
                <x-jet-button wire:click="update({{ $navigation_menu }})">{{ __('Update') }}</x-jet-button>
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
            {{ __('Delete Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this menu? This action cannot be reversed.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('show_delete_modal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete({{ $navigation_menu }})"
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
                    Title</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    slug</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Options</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($navigation_menus as $menu)
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $menu->label }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $menu->slug }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        <x-jet-button wire:click="edit({{ $menu }})">edit</x-jet-button>
                        <x-jet-danger-button wire:click="showDeleteModal({{ $menu }})">delete
                        </x-jet-danger-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">Sample title</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">http://localhost:8000/pages/page-name-goes-here</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">sample-title</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">options</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
