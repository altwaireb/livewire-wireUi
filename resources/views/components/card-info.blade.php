@props([
'value',
'title',
'icon',
'iconClasses' => '',
'titleClasses' => '',
'valueClasses' => '',
])
<div  {{ $attributes->merge(['class' => 'flex items-center p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800']) }}>
    <div class="p-3 ltr:mr-4 rtl:ml-4 text-primary-500 bg-primary-100 rounded-full dark:text-primary-100 dark:bg-primary-500 {{ $iconClasses }}">
        @if(isset($icon))
            <x-icon name="{{$icon}}" class="w-5 h-5" solid/>
        @endif
    </div>
    <div>
        @if(isset($title))
        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 {{ $titleClasses }}">
            {{ $title }}
        </p>
        @endif
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 {{ $valueClasses }}">
            {{ $value ?? $slot }}
        </p>
    </div>
</div>
