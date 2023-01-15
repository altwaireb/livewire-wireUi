<!-- Mobile sidebar -->
<!-- Backdrop -->
<div
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed md:hidden inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
></div>
<aside
        class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-secondary-800 md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform ltr:-translate-x-20 rtl:translate-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform ltr:-translate-x-20 rtl:translate-x-20"
        @keydown.escape="isSideMenuOpen = false"
        @mousedown.outside="isSideMenuOpen = false"
>
    <div class="py-4 text-secondary-500 dark:text-secondary-400">
        <a class="flex items-center gap-x-2 ltr:ml-6 rtl:mr-6 text-lg font-bold text-secondary-800 dark:text-secondary-200"
           href="{{ route('admin.index') }}">
            <x-application-mark class="block h-6 w-auto text-primary-600"/>
            <span>{{ setting('site_title') ?? config('app.name', 'Laravel') }}</span>
        </a>
        <ul class="mt-6">
            @include('assets.admin.sidebar.links')
        </ul>
    </div>
</aside>