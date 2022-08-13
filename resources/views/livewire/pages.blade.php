<div class="py-6 px-4">
    <x-jet-button wire:click="createShowModal">{{ __('create page') }}</x-jet-button>

    {{-- create page modal --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            @if ($page)
                {{ __('Update ' . $page->title) }}
            @else
                {{ __('Create new page') }}
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input wire:model.debounce.800ms="title" id="title" type="text" class="mt-1 block w-full" />
                <x-jet-input-error for="title" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <x-jet-input wire:model.debounce.800ms="slug" id="slug" type="text" class="mt-1 block w-full" />
                <x-jet-input-error for="slug" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="content" value="{{ __('Content') }}" />
                <input type="hidden" name="content" id="content">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl font-bold">Markdown x testing goes here</h1>
                    <livewire:markdown-x :style="[
                            'toolbar' => 'flex items-center justify-between bg-gray-300',
                            'textarea' => 'w-full h-full rounded-lg border-2 border-gray-200 focus:border-gray-200 focus:outline-none p-4',
                            'height' => 'h-64',
                            'preview' => 'bg-gray-200 p-10',
                            'help' => 'bg-gray-300 p-8 prose max-w-none'
                        ]"/>
                </div>
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <trix-editor class="trix-content" x-ref="trix" wire:model.debounce.999999ms="content"
                                wire:model="content" input="content" wire:key="trix-content-unique-key">
                            </trix-editor>
                        </div>
                    </div>
                    <x-jet-input-error for="content" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            @if ($page)
                <x-jet-button wire:click="update({{ $page }})">{{ __('Update') }}</x-jet-button>
            @else
                <x-jet-button wire:click="create">{{ __('Save') }}</x-jet-button>
            @endif

            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Delete page Confirmation Modal -->
    <x-jet-dialog-modal wire:model="modalConfirmDelete">
        <x-slot name="title">
            {{ __('Delete Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this page? This action cannot be reversed.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDelete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete({{ $page }})"
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
                    Content</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    slug</th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Options</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($pages as $page)
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $page->title }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        {!! $page->content !!}
                    </td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $page->slug }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        <x-jet-button wire:click="edit({{ $page }})">edit</x-jet-button>
                        <x-jet-danger-button wire:click="showDeleteModal({{ $page }})">delete
                        </x-jet-danger-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-nowrap" span="4">
                        No data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
