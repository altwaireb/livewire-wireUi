<div>
    <x-modal.card
            title="{{ __('app.create') }} {{ __('setting.setting') }}"
            wire:model.defer="openCreateModel"
            blur
            hideClose
    >
        <form wire:submit.prevent="create" autocomplete="off">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input wire:model="key" type="text" label="Key" placeholder="Key"/>
                <x-input wire:model="display_name" type="text" label="Display Name" placeholder="Display Name"/>
                <x-select
                        label="Select Type"
                        placeholder="Select Type"
                        wire:model="type"
                        :options="$types"
                        :clearable="false"
                >
                </x-select>
                <x-inputs.number wire:model="order" min="1" max="200" label="Order"/>
                <div class="col-span-1 sm:col-span-2">
                    @if($type === 'text')
                        <x-input wire:model="value" type="text" label="Value" placeholder="Add Value"/>
                    @elseif($type === 'textarea')
                        <x-textarea wire:model="value" label="Value" placeholder="Add Value"/>
                    @elseif($type === 'image')
                        <div class="relative items-center justify-center w-full">
                            <label for="dropzone-image"
                                   class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center object-cover pt-5 pb-6">
                                    @if(!empty($value))
                                        <x-button.circle
                                                class="absolute bottom-5 rtl:left-5 ltr:right-5"
                                                x-on:click="@this.removeUpload('value', '{{ $value->getFilename() }}')"
                                                negative icon="x"
                                        />
                                        <img src="{{ $value->temporaryUrl() }}"
                                             class="object-scale-down h-60 max-h-full max-w-full">
                                    @else
                                        <x-icon name="cloud-upload" class="w-10 h-10 mb-3 text-gray-400"/>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                            800x400px)</p>
                                    @endif
                                </div>
                                <input id="dropzone-image" wire:model="value" type="file" accept="image/*"
                                       class="hidden"/>
                            </label>
                            <x-error name="value" class="block"/>
                        </div>
                    @elseif($type === 'file')
                        <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
{{--                                x-on:livewire-upload-finish="isUploading = false"--}}
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"

                                class="relative items-center justify-center w-full">
                            <label for="dropzone-file"
                                   class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center object-cover pt-5 pb-6">

                                    <x-icon name="cloud-upload" class="w-10 h-10 mb-3 text-gray-400"/>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF, PNG, JPG or GIF (MAX.
                                        800x400px)</p>
                                </div>
                                <input id="dropzone-file" wire:model="value" type="file"
                                       accept="application/msword, application/pdf"
                                       class="hidden"/>
                            </label>
                            <div x-show="isUploading"
                                 class="flex justify-items-center gap-4 mt-4 p-4 bg-gray-700 rounded-lg"
                            >
                                @if(!empty($value))
                                    <div class="flex-auto basis-3/6">
                                        <small>{{ $value->getClientOriginalName() }}</small>
                                    </div>

                                    <div class="flex-1 basis-2/6">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>

                                    <div class="flex-none w-14">
                                        <x-button.circle
                                                x-on:click="@this.removeUpload('value', '{{ $value->getFilename() }}'),isUploading = false"
                                                negative
                                                icon="x"
                                        />
                                    </div>
                                @endif
                            </div>
                            <x-error name="value" class="block"/>
                        </div>
                    @endif
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