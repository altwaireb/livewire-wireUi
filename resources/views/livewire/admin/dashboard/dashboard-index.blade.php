<div class="px-5 pt-10">
   @section('page-title')
      {{ __('Dashboard') }}
   @endsection
   <x-button wire:click="openModal" color="primary" label="Primary" />

   <x-modal.card title="Edit Customer" blur wire:model.defer="simpleModal"
                 x-on:open="console.log('open')"
                 x-on:close="$wire.closeModal()"
   >
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
         <x-input label="Name" placeholder="Your full name" />
         <x-datetime-picker
                 label="Appointment Date"
                 placeholder="Appointment Date"
                 display-format="YYYY-MM-DD"
                 wire:model.defer="date"
                 without-time="true"
         />

         <div class="col-span-1 sm:col-span-2">
            <x-input label="Email" placeholder="example@mail.com" />
         </div>

         <div class="col-span-1 sm:col-span-2 cursor-pointer bg-gray-100 rounded-xl shadow-md h-72 flex items-center justify-center">
            <div class="flex flex-col items-center justify-center">
               <x-icon name="cloud-upload" class="w-16 h-16 text-blue-600" />
               <p class="text-blue-600">Click or drop files here</p>
            </div>
         </div>
      </div>

      <x-slot name="footer">
         <div class="flex justify-between gap-x-4">
            <x-button flat negative label="Delete" wire:click="delete" />

            <div class="flex">
               <x-button flat label="Cancel" x-on:click="$wire.closeModal()" />
               <x-button primary label="Save" wire:click="save" />
            </div>
         </div>
      </x-slot>
   </x-modal.card>

</div>
