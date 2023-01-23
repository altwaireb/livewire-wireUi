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

        <div class="grid gap-x-3 mb-2 grid-cols-4 md:grid-cols-6 xl:grid-cols-8">
            <div class="col-span-2 md:col-span-2 xl:col-span-3">
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
            <div class="col-span-1 md:col-span-2 xl:col-span-2">
                <x-select
                        :label="__('settings.type')"
                        :placeholder="__('app.select').' '.__('settings.type')"
                        wire:model="typeSearch"
                        :options="$types"
                        :empty-message="__('wireui::messages.empty_options')"
                />
            </div>
            <div class="col-span-1 md:col-span-1 md:col-start-6 md:col-end-6 xl:col-start-8 xl:col-end-8 items-end justify-end">
                <x-select
                        label="{{ __('app.PerPage') }}"
                        :options="[10, 25, 50, 100]"
                        wire:model="perPage"
                        :clearable="false"
                />
            </div>
        </div>

        <div class="flex items-center bg-primary-500 dark:bg-primary-600 text-secondary-50 dark:text-white text-sm rounded-md font-bold px-4 py-4 mt-4">
            <x-icon name="information-circle" class="w-5 h-5 ltr:mr-2 rtl:ml-2" />
{{--            <svg class="fill-current w-4 h-4 ltr:mr-2 rtl:ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>--}}
            <p class="text-sm">{{ __('settings.usage_help') }}  <code class="bg-primary-50 dark:bg-primary-100 p-1 text-secondary-800 dark:text-secondary-700 mx-2">setting('key')</code></p>
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