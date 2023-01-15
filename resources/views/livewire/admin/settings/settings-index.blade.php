<div class="space-y-6">
    @section('page-title', __('Settings'))
    {{--    <x-slot:header>--}}

    {{--    </x-slot:header>--}}

    <x-card cardClasses="my-6" title="{{ __('Settings') }}">
        <x-slot:action  class="items-center justify-center">
            <x-button wire:click="create" icon="plus" primary label="Add Setting"/>
        </x-slot:action>
        <div class="grid gap-x-3 mb-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4"
        style="color: #eb2581"
        >
            <x-input label="Search" wire:model="search" placeholder="Search ..."/>
            <x-native-select
                    label="PerPage"
                    :options="[10, 25, 50, 100]"
                    wire:model="perPage"
            />
        </div>
    </x-card>
    <div class="w-full overflow-hidden rounded-lg">
        <div class="w-full overflow-x-auto shadow-xs">
            <x-table>
                <x-slot:header>
                    <x-table.heading
                            sortable
                            value="ID"
                            wire:click="sortBy('id')"
                            :direction="$sortBy === 'id' ? $sortDirection : null"
                    />
                    <x-table.heading sortable wire:click="sortBy('key')" :direction="$sortBy === 'key' ? $sortDirection : null" class="ltr:text-left rtl:text-right">Key</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('display_name')" :direction="$sortBy === 'display_name' ? $sortDirection : null">Display Name</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('type')" :direction="$sortBy === 'type' ? $sortDirection : null">Type</x-table.heading>
                    <x-table.heading value="Value" />
                    <x-table.heading sortable wire:click="sortBy('order')" :direction="$sortBy === 'order' ? $sortDirection : null">Order</x-table.heading>
                    <x-table.heading
                            value="Actions"
                            class="px-4 py-3 w-16"
                    />
                </x-slot:header>
                @forelse($items as $item)
                    <tr class="text-sm text-center text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">{{ $item->id }}</td>
                        <td class="px-4 py-3">{{ $item->key }}</td>
                        <td class="px-4 py-3">{{ $item->display_name }}</td>
                        <td class="px-4 py-3">{{ $item->type }}</td>
                        <td class="px-4 py-3">
                            @if(!empty($item->value) && $item->type === 'image')
                                <a href="{{ url('storage/'.$item->value) }}" target="_blank">
                                    <img src="{{ url('storage/'.$item->value) }}" class="object-cover h-12">
                                </a>
                            @elseif(!empty($item->value) && $item->type === 'file')
                                <a href="{{ url('storage/'.$item->value) }}" target="_blank">show</a>
                            @else
                                {{ $item->value }}
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $item->order }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center gap-x-1">
                                <x-button.circle wire:click="edit({{$item->id}})" primary flat icon="pencil"/>
                                <x-button.circle primary flat icon="eye"/>
                                <x-button.circle primary flat icon="trash"/>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </x-table>
        </div>
        @if(!empty($items))
            <div class="px-4 py-3 border-t dark:border-secondary-700 bg-white divide-y dark:divide-secondary-700 dark:bg-secondary-800">
                {{ $items->links() }}
            </div>
        @endif
    </div>
    <livewire:admin.settings.settings-create />
</div>
