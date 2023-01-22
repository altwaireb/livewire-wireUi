<div class="space-y-6">
    @section('page-title', __('permissions.permissions'))

    <x-card cardClasses="my-6" title="{{ __('permissions.permissions') }}">
        <x-slot:action class="items-center justify-center">
            @can('create',\App\Models\Permission::class)
                <x-button
                        wire:click="$emit('openCreateModel')"
                        label="{{ __('app.create') .' '. __('permissions.permission') }}"
                        wire:loading.class="disabled"
                        icon="plus" primary
                />
            @endcan
        </x-slot:action>

        <div class="grid gap-x-3 mb-2 grid-cols-2 md:grid-cols-4 xl:grid-cols-8">
            <div class="md:col-span-2 xl:col-span-3">
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

            <div class="col-span-1 md:col-span-1 xl:col-span-2">
                <x-select
                        :label="__('app.search by').' '.__('permissions.table_name')"
                        :placeholder="__('app.select').' '.__('permissions.table_name')"
                        wire:model="tableNameSearch"
                        :empty-message="__('wireui::messages.empty_options')"
                >
                    @foreach($tableNames as $key => $value)
                        <x-select.option
                                label="{{ !empty($value->table_name) ? __(''.$value->table_name.'.'.$value->table_name.'')  :  __('app.general') }}"
                                value="{{ empty($value->table_name) ? 'NULL' : $value->table_name}}"
                        />
                    @endforeach
                </x-select>
            </div>

            <div class="col-span-1 md:col-span-1 xl:col-start-8 xl:col-end-8 items-end justify-end">
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
                            :value="__('permissions.name').' / '.__('permissions.translate')"
                            wire:click="sortBy('name')"
                            :direction="$sortBy === 'name' ? $sortDirection : null"
                            class="ltr:text-left rtl:text-right"
                    />
                    <x-table.heading
                            sortable
                            :value="__('permissions.key')"
                            wire:click="sortBy('key')"
                            :direction="$sortBy === 'key' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('permissions.table_name').' / '.__('permissions.translate')"
                            wire:click="sortBy('table_name')"
                            :direction="$sortBy === 'table_name' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('permissions.roles_count')"
                            wire:click="sortBy('roles_count')"
                            :direction="$sortBy === 'roles_count' ? $sortDirection : null"
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
                        <x-table.cell class="text-center">
                            <span class="text-sm block">{{ $item->name }}</span>
                            @if(app()->getLocale() != 'en')
                                <span class="text-xs opacity-90">{{ !empty($item->table_name) ? __(''.$item->table_name.'.'.$item->name.'')  :  __('app.'.$item->name.'') }}</span>
                            @endif
                        </x-table.cell>
                        <x-table.cell :value="$item->key" class="text-center"/>
                        <x-table.cell class="text-center">
                            <span class="text-sm block">{{ $item->table_name }}</span>
                            @if(app()->getLocale() != 'en')
                                <span class="text-xs opacity-90">{{ !empty($item->table_name) ? __(''.$item->table_name.'.'.$item->table_name.'')  :  __('app.general') }}</span>
                            @endif
                        </x-table.cell>
                        <x-table.cell :value="$item->roles_count" class="text-center"/>
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
                        <x-table.cell :value="__('app.no data')" colspan="7"/>
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

    <livewire:admin.permissions.permissions-create/>
    <livewire:admin.permissions.permissions-update/>
    <livewire:admin.permissions.permissions-show/>
    <livewire:admin.permissions.permissions-delete/>
</div>