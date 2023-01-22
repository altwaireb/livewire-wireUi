<div>
    @if($openUpdateModel)
        <x-modal.card
                title="{{ __('app.update') }} {{ __('permissions.permission') }}"
                wire:model.defer="openUpdateModel"
                blur
                hideClose
                max-width="sm"
        >
            <form wire:submit.prevent="edit" autocomplete="off">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-2">
                    <div class="col-span-1 md:col-span-4">
                        <x-input
                                wire:model.defer="name"
                                label="{{ __('permissions.name') }}"
                                placeholder="{{ __('permissions.name') }}"
                                type="text"
                        />
                    </div>
                    <div class="col-span-1 md:col-span-4">
                        <x-input
                                wire:model.defer="key"
                                label="{{ __('permissions.key') }}"
                                placeholder="{{ __('permissions.key') }}"
                                type="text"
                        />
                    </div>
                    <div class="col-span-1 md:col-span-4">
                        <x-input
                                wire:model.defer="table_name"
                                label="{{ __('permissions.table_name') }}"
                                placeholder="{{ __('permissions.table_name') }}"
                                type="text"
                        />
                    </div>
                </div>
                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <div class="flex gap-x-4">
                            <x-button
                                    wire:click="closeUpdateModel"
                                    wire:target="closeUpdateModel"
                                    wire:loading.class="disabled"
                                    :label="__('app.close')"
                                    spinner="closeUpdateModel"
                                    flat
                            />
                            <x-button
                                    wire:click="edit"
                                    wire:target="edit"
                                    wire:loading.class="disabled"
                                    type="submit"
                                    :label="__('app.update')"
                                    spinner="edit"
                                    primary
                            />
                        </div>
                    </div>
                </x-slot>
            </form>
        </x-modal.card>
    @endif
</div>
