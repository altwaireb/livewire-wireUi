<div>
    <x-modal.card
            title="{{ __('app.create') }} {{ __('roles.role') }}"
            wire:model.defer="openCreateModel"
            blur
            hideClose
    >
        <form wire:submit.prevent="create" autocomplete="off">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="col-span-1 md:col-span-3">
                    <x-input
                            wire:model.defer="name"
                            label="{{ __('roles.name') }}"
                            placeholder="{{ __('roles.name') }}"
                            type="text"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-input
                            wire:model.defer="key"
                            label="{{ __('roles.key') }}"
                            placeholder="{{ __('roles.key') }}"
                            type="text"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label :label="__('roles.default')">
                        <div class="flex flex-row gap-x-4">
                            <x-radio
                                    wire:model.defer="default"
                                    :label="__('app.true')"
                                    value="1"
                                    id="default-true"
                            />
                            <x-radio
                                    wire:model.defer="default"
                                    :label="__('app.false')"
                                    value="0"
                                    id="default-false"
                            />
                        </div>
                    </x-item-with-label>
                </div>
                <div class="col-span-1 md:col-span-3">

                    <x-color-picker
                            wire:model="color"
                            label="{{ __('roles.color') }}"
                            placeholder="{{ __('roles.key') }}"
                    />
                </div>
                <div class="col-span-1 md:col-span-6">
                    <x-item-with-label :label="__('app.preview')">
                        <div class="flex flex-row gap-x-3">
                            <div class="w-1/2 text-center bg-secondary-50 p-2 rounded drop-shadow">
                                <span class="text-xs text-secondary-600 dark:text-secondary-600 block pb-0.5">Light mode</span>
                                <x-badge-role-user
                                        color="{{ !empty($color) ? $color : '#000' }}"
                                        label="{{ !empty($name) ? $name : 'text' }}"
                                />
                            </div>
                            <div class="w-1/2 text-center bg-secondary-800 dark:bg-secondary-900/40 p-2 rounded drop-shadow">
                                <span class="text-xs text-secondary-300 dark:text-secondary-400 block pb-0.5">Dark mode</span>
                                <x-badge-role-user
                                        color="{{ !empty($color) ? $color : '#000' }}"
                                        label="{{ !empty($name) ? $name : 'text' }}"
                                />
                            </div>
                        </div>
                    </x-item-with-label>
                </div>
                <div class="col-span-1 md:col-span-6">
                    <x-item-with-label :label="__('roles.permissions')">
                        <div class="overflow-y-auto scroll-smooth h-48">
                            @forelse($permissions->unique('table_name')->pluck('table_name') as $key => $value)
                                <div class="pt-4">
                                    <x-item-with-label
                                            label="{{ !empty($value) ? __(''.$value.'.'.$value.'')  : __('app.general') }}"
                                    >
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($permissions as $permission)
                                                @if($permission->table_name === $value)
                                                    <x-checkbox
                                                            wire:model.defer="permission"
                                                            :value="$permission->id"
                                                            :id="'permissionCreate.'.$permission->id"
                                                            label="{{ !empty($value) ? __(''.$value.'.'.$permission->name.'')  :  __('app.'.$permission->name.'') }}"
                                                    />
                                                @endif
                                            @endforeach
                                        </div>
                                    </x-item-with-label>
                                </div>
                            @empty
                                <div class="text-red-700">{{ __('app.No Data') }}</div>
                            @endforelse
                        </div>
                    </x-item-with-label>
                </div>
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <div class="flex gap-x-4">
                        <x-button
                                wire:click="closeCreateModel"
                                wire:target="closeCreateModel"
                                wire:loading.class="disabled"
                                :label="__('app.close')"
                                spinner="closeCreateModel"
                                flat
                        />
                        <x-button
                                wire:click="create"
                                wire:target="create"
                                wire:loading.class="disabled"
                                type="submit"
                                :label="__('app.save')"
                                spinner="create"
                                primary
                        />
                    </div>
                </div>
            </x-slot>
        </form>
    </x-modal.card>
</div>
