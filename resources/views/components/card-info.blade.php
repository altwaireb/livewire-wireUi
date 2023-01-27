@props([
'value',
'title',
'icon',
'iconClasses' => '',
'titleClasses' => '',
'valueClasses' => '',
])
<div {{ $attributes->merge(['class' => 'flex items-center p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800']) }}>
    @if(isset($icon))
        <div class="p-3 ltr:mr-4 rtl:ml-4 rounded-full text-primary-50 bg-primary-600 {{ $iconClasses }}">
            <x-icon name="{{$icon}}" class="w-5 h-5" solid/>
        </div>
    @endif

    <div>
        @if(isset($title))
            <span class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 {{ $titleClasses }}">
                {{ $title }}
            </span>
        @endif
        <span class="block text-lg font-semibold text-gray-700 dark:text-gray-200 {{ $valueClasses }}">
            {{ $value ?? $slot }}
        </span>
    </div>
</div>
