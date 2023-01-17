<div>
    <x-modal.card
            title="{{ __('app.update') }} {{ __('setting.setting') }}"
            wire:model.defer="openUpdateModel"
            blur
            hideClose
    >
        <form wire:submit.prevent="edit" autocomplete="off">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input
                        wire:model="key"
                        label="{{ __('setting.key') }}"
                        placeholder="{{ __('setting.key') }}"
                        type="text"
                />
                <x-input
                        wire:model="display_name"
                        label="{{ __('setting.display_name') }}"
                        placeholder="{{ __('setting.display_name') }}"
                        type="text"
                />
                <x-select
                        label="{{ __('setting.type') }}"
                        placeholder="{{ __('setting.type') }}"
                        wire:model="type"
                        :options="$types"
                        :clearable="false"
                >
                </x-select>
                <x-inputs.number
                        wire:model="order"
                        label="{{ __('setting.order') }}"
                        min="1"
                        max="200"
                />
                <div class="col-span-1 sm:col-span-2">
                    @if($type === 'text')
                        <x-input
                                wire:model="value"
                                label="{{ __('setting.value') }}"
                                placeholder="{{ __('setting.value') }}"
                                type="text"
                        />
                    @elseif($type === 'textarea')
                        <x-textarea
                                wire:model="value"
                                label="{{ __('setting.value') }}"
                                placeholder="{{ __('setting.value') }}"
                        />
                    @elseif($type === 'image')
                        <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="relative items-center justify-center w-full"
                        >
                            <label for="dropzone-image"
                                   class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center object-cover pt-5 pb-6">
                                    <x-icon name="cloud-upload" class="w-10 h-10 mb-3 text-gray-400"/>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">{{ __('app.Click to upload') }}</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                        800x400px)</p>
                                </div>
                                <input id="dropzone-image" wire:model="newValue" type="file" accept="image/*"
                                       class="hidden"/>
                            </label>

                            @if(!empty($newValue))
                                <x-card
                                        x-show="isUploading"
                                        color="bg-secondary-100 dark:bg-secondary-700 mt-4"
                                >
                                    <div class="flex flex-row items-center justify-between gap-2">
                                        <div class="h-12 w-12">
                                            <img src="{{ $newValue->temporaryUrl() }}"
                                                 class="w-full h-full object-cover object-center rounded"
                                            >
                                        </div>
                                        <span class="truncate w-3/4">{{ $newValue->getClientOriginalName() }}</span>
                                        <progress max="100" x-bind:value="progress"></progress>
                                        <div class="w-12">
                                            <x-button.circle
                                                    x-on:click="@this.removeUpload('newValue', '{{ $newValue->getFilename() }}')"
                                                    negative icon="x"
                                            />
                                        </div>
                                    </div>
                                </x-card>
                            @elseif(!empty($value))
                                <x-card color="bg-secondary-100 dark:bg-secondary-700 mt-4">
                                    <div class="flex flex-row items-center justify-between gap-2">
                                        <div class="h-12 w-12">
                                            <img src="{{ url('storage/'.$value) }}"
                                                 class="w-full h-full object-cover object-center rounded"
                                            >
                                        </div>
                                        <span class="truncate w-3/4">{{ $value }}</span>
                                        <x-button.circle
                                                wire:click="$set('value', null)"
                                                negative icon="x"
                                        />
                                    </div>
                                </x-card>
                            @endif
                            <x-error name="value" class="block"/>
                            <x-error name="newValue" class="block"/>
                        </div>
                    @elseif($type === 'file')
                        <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="relative items-center justify-center w-full"
                        >
                            <label for="dropzone-image"
                                   class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center object-cover pt-5 pb-6">
                                    <x-icon name="cloud-upload" class="w-10 h-10 mb-3 text-gray-400"/>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">{{ __('app.Click to upload') }}</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC or DOCX (MAX.10MB)</p>
                                </div>
                                <input
                                        wire:model="newValue"
                                        id="dropzone-image"
                                        type="file"
                                        accept="application/msword, application/pdf"
                                        class="hidden"
                                />
                            </label>

                            @if(!empty($newValue))
                                <x-card
                                        x-show="isUploading"
                                        color="bg-secondary-100 dark:bg-secondary-700 mt-4"
                                >
                                    <div class="flex flex-row items-center justify-between gap-2">
                                        <span class="truncate w-3/4">{{ $newValue->getClientOriginalName() }}</span>
                                        <progress max="100" x-bind:value="progress"></progress>
                                        <div class="w-12">
                                            <x-button.circle
                                                    x-on:click="@this.removeUpload('newValue', '{{ $newValue->getFilename() }}')"
                                                    negative icon="x"
                                            />
                                        </div>
                                    </div>
                                </x-card>
                            @elseif(!empty($value))
                                <x-card color="bg-secondary-100 dark:bg-secondary-700 mt-4">
                                    <div class="flex flex-row items-center justify-between gap-2">
                                        <span class="truncate w-3/4">{{ $value }}</span>
                                        <x-button.circle
                                                wire:click="$set('value', null)"
                                                negative icon="x"
                                        />
                                    </div>
                                </x-card>
                            @endif
                            <x-error name="value" class="block"/>
                            <x-error name="newValue" class="block"/>
                        </div>
                    @endif
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
</div>
