<!-- Desktop sidebar -->
<aside
        class="z-20 hidden w-60 overflow-y-auto bg-white dark:bg-secondary-800 md:block flex-shrink-0"
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