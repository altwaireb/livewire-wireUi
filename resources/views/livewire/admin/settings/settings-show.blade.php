<div>
    @if($openShowModel)
        <x-modal.card
                title="{{ __('app.show') }} {{ __('setting.setting') }}"
                wire:model.defer="openShowModel"
                blur
                hideClose

        >
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 px-4">

                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('setting.key')"
                            :value="$item->key"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('setting.display_name')"
                            :value="$item->display_name"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('setting.type')"
                            :value="$item->type"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('setting.order')"
                            :value="$item->order"
                    />
                </div>
                <div class="col-span-2 md:col-span-6">
                    <x-item-with-label class="items-center" :label="__('setting.value')">
                        @if(!empty($item->value))
                            @if($item->type === 'image')
                                <div class="items-center">
                                    <img src="{{ url('storage/'.$item->value) }}"
                                         class="h-32 object-cover object-center rounded"
                                    >
                                </div>
                            @elseif($item->type === 'file')
                                <a href="{{ url('storage/'.$item->value) }}" target="_blank">{{ __('app.show') }}</a>
                            @else
                                <p>{{ $item->value }}</p>
                            @endif
                        @endif
                    </x-item-with-label>
                </div>

                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('app.created_at')"
                            :value="$item->created_at"
                    />
                </div>

                @if(!empty($item->updated_at) && $item->created_at != $item->updated_at)
                    <div class="col-span-1 md:col-span-3">
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


