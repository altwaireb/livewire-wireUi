@props(['image','title','subtitle','active' => null])

@php
if (isset($active)){
    $isActive = 'bg-green-400 dark:border-gray-800';
    $notActive = 'bg-red-400 dark:border-gray-800';
    $classActive = $active === true ? $isActive : $notActive;
}
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center text-sm']) }}>
    @if(isset($image))
        <div class="relative hidden w-8 h-8 ltr:mr-3 rtl:ml-3 rounded-full md:block">
            <img class="object-cover w-full h-full rounded-full"
                 src="{{ $image }}"
                 alt="">
            @if(isset($active))
                <span class=" {{ $classActive }} bottom-0 ltr:-left-1 rtl:-right-1 absolute w-3.5 h-3.5 border-2 border-white rounded-full"></span>
            @endif
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
        </div>
    @endif
    <div>
        <p class="font-semibold">{{ $title ?? $slot }}</p>
        @if(isset($subtitle))
            <p class="text-xs text-secondary-600 dark:text-secondary-400">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</div>
