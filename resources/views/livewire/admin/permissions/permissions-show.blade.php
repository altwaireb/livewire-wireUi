<div>
    @if($openShowModel)
        <x-modal.card
                title="{{ __('app.show') }} {{ __('permissions.permission') }}"
                wire:model.defer="openShowModel"
                blur
                hideClose
                max-width="lg"
        >
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-4">

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('permissions.name')"
                            :value="$item->name"
                    />
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('permissions.key')"
                            :value="$item->key"
                    />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label :label="__('permissions.table_name')">
                        <div class="h-6">
                            <span>{{ $item->table_name }}</span>
                        </div>
                    </x-item-with-label>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('permissions.roles_count')"
                            :value="$item->roles_count"
                    />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('app.created_at')"
                            :value="$item->created_at"
                    />
                </div>

                @if(!empty($item->updated_at) && $item->created_at != $item->updated_at)
                    <div class="col-span-1 md:col-span-2">
                        <x-item-with-label
                                :label="__('app.updated_at')"
                                :value="$item->updated_at"
                        />
                    </div>
                @endif

            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <div class="flex gap-x-4">
                        <x-button
                                wire:click="closeShowModel"
                                wire:target="closeShowModel"
                                wire:loading.class="disabled"
                                :label="__('app.close')"
                                spinner="closeShowModel"
                                flat
                        />
                    </div>
                </div>
            </x-slot>
        </x-modal.card>
    @endif
</div>
