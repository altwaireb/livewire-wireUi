<div class="space-y-6">
    @section('page-title', __('settings.settings'))

    <x-card cardClasses="my-6" title="{{ __('settings.settings') }}">
        <x-slot:action class="items-center justify-center">
            @can('create',\App\Models\Setting::class)
                <x-button
                        wire:click="$emit('openCreateModel')"
                        label="{{ __('app.create') .' '. __('settings.setting') }}"
                        wire:loading.class="disabled"
                        icon="plus" primary
                />
            @endcan
        </x-slot:action>

        <div class="grid gap-x-3 mb-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-8">
            <div class="col-span-3">
                <x-input
                        wire:model="search"
                        :label="__('app.search')"
                        :placeholder="__('app.searchInput')"
                        class="ltr:pl-12 rtl:pr-12"
                >
                    <x-slot name="prepend">
                        <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center p-0.5">
                            <x-button
                                    wire:click="resetSearch"
                                    {{ empty($search) ? 'disabled' : ''  }}
                                    class="h-full ltr:rounded-l-md rtl:rounded-r-md"
                                    icon="minus-circle" primary flat squared
                            />
                        </div>
                    </x-slot>
                </x-input>
            </div>
            <div class="col-span-2">
                <x-select
                        :label="__('settings.type')"
                        :placeholder="__('app.select').' '.__('settings.type')"
                        wire:model="typeSearch"
                        :options="$types"
                        :empty-message="__('wireui::messages.empty_options')"
                />
            </div>

            <div class="xl:col-start-8 xl:col-end-8 items-end justify-end">
                <x-select
                        label="{{ __('app.PerPage') }}"
                        :options="[10, 25, 50, 100]"
                        wire:model="perPage"
                        :clearable="false"
                />
            </div>

        </div>
    </x-card>

    <div class="w-full overflow-hidden rounded-lg">
        <div class="w-full overflow-x-auto shadow-xs">
            <x-table>
                <x-slot:header>
                    <x-table.heading
                            sortable
                            value="#"
                            wire:click="sortBy('id')"
                            class="px-2 py-3"
                            :direction="$sortBy === 'id' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('settings.key')"
                            wire:click="sortBy('key')"
                            :direction="$sortBy === 'key' ? $sortDirection : null"
                            class="ltr:text-left rtl:text-right"
                    />
                    <x-table.heading
                            sortable
                            :value="__('settings.display_name')"
                            wire:click="sortBy('display_name')"
                            :direction="$sortBy === 'display_name' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('settings.type')"
                            wire:click="sortBy('type')"
                            :direction="$sortBy === 'type' ? $sortDirection : null"
                    />
                    <x-table.heading
                            :value="__('settings.value')"
                    />
                    <x-table.heading
                            sortable
                            :value="__('settings.order')"
                            wire:click="sortBy('order')"
                            :direction="$sortBy === 'order' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('app.created_at')"
                            wire:click="sortBy('created_at')"
                            :direction="$sortBy === 'created_at' ? $sortDirection : null"
                    />
                    <x-table.heading
                            :value="__('app.actions')"
                            class="px-4 py-3 w-16"
                    />
                </x-slot:header>
                @forelse($items as $item)
                    <x-table.row wire:key="items-{{ $item->id }}">
                        <x-table.cell :value="$item->id" class="px-2 py-3 text-center"/>
                        <x-table.cell :value="$item->key" />
                        <x-table.cell :value="$item->display_name" class="text-center" />
                        <x-table.cell :value="$item->type" class="text-center" />
                        <x-table.cell class="text-center">
                            @if(!empty($item->value) && $item->type === 'image')
                                <a href="{{ url('storage/'.$item->value) }}" target="_blank">
                                    <img src="{{ url('storage/'.$item->value) }}" class="h-8 object-cover object-center rounded">
                                </a>
                            @elseif(!empty($item->value) && $item->type === 'file')
                                <a href="{{ url('storage/'.$item->value) }}" target="_blank">{{ __('app.show') }}</a>
                            @else
                                {{ $item->valueLimit }}
                            @endif
                        </x-table.cell>
                        <x-table.cell :value="$item->order" class="text-center"/>
                        <x-table.cell
                                :value="date('Y-m-d H:i', strtotime($item->created_at))"
                                class="text-center text-xs"
                        />
                        <x-table.cell>
                            <div class="flex justify-center items-center gap-x-1">
                                @can('update',$item)
                                    <x-button.circle
                                            wire:click="$emit('openUpdateModel',{{$item->id}})"
                                            icon="pencil" primary flat
                                    />
                                @endcan

                                @can('view',$item)
                                    <x-button.circle
                                            wire:click="$emit('openShowModel',{{$item->id}})"
                                            icon="eye" primary flat
                                    />
                                @endcan

                                @can('delete',$item)
                                    <x-button.circle
                                            wire:click="$emit('openDeleteModel',{{$item->id}})"
                                            icon="trash" primary flat
                                    />
                                @endcan
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row class="text-center">
                        <x-table.cell :value="__('app.no data')" colspan="8"/>
                    </x-table.row>
                @endforelse
            </x-table>
        </div>
        @if(!empty($items))
            <div class="px-4 py-3 border-t dark:border-secondary-700 bg-white divide-y dark:divide-secondary-700 dark:bg-secondary-800">
                {!! $items->links() !!}
            </div>
        @endif
    </div>
    <livewire:admin.settings.settings-create :types="$types"/>
    <livewire:admin.settings.settings-update :types="$types"/>
    <livewire:admin.settings.settings-show/>
    <livewire:admin.settings.settings-delete/>
</div>