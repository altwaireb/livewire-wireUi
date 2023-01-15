@props([
'routeName',
'title',
'icon'
])

<li class="relative px-6 py-3">
    @if(request()->routeIs($routeName))
        <span
                class="absolute inset-y-0 ltr:left-0 rtl:right-0 w-1 bg-primary-600 ltr:rounded-tr-lg ltr:rounded-br-lg rtl:rounded-tl-lg rtl:rounded-bl-lg"
                aria-hidden="true"
        ></span>
    @endif
    <a
            class="inline-flex items-center {{ request()->routeIs($routeName) === true ? 'text-secondary-800 dark:text-secondary-100' : '' }} w-full text-sm font-semibold transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            href="{{ route($routeName) }}"
    >
        @if(isset($icon))
            <x-icon name="{{$icon}}" class="w-5 h-5"/>
        @endif
        <span class="ltr:ml-4 rtl:mr-4">{{ $title }}</span>
    </a>
</li>