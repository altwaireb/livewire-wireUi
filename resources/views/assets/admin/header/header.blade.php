<div
        class="container flex items-center justify-between md:justify-end h-full px-6 mx-auto text-primary-600 dark:text-primary-300"
>
    <!-- Mobile hamburger -->
    <button
            x-show="isSideMenuOpen === false"
            class="p-1 ltr:mr-5 ltr:-ml-1 rtl:ml-5 rtl:-mr-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-primary"
            x-on:click="isSideMenuOpen = true"
            aria-label="Menu"
    >
        <x-icon name="menu" class="w-6 h-6" solid/>
    </button>
    <button
            x-show="isSideMenuOpen === true"
            class="p-1 ltr:mr-5 ltr:-ml-1 rtl:ml-5 rtl:-mr-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-primary"
            x-on:click="isSideMenuOpen = false"
            aria-label="Menu"
    >
        <x-icon name="x-circle" class="w-6 h-6"/>
    </button>

    <ul class="flex items-center flex-shrink-0 space-x-6">
        <!-- Theme toggler -->
        <li class="flex px-4">
            <!-- Button darkMode -->
            <x-button-darkMode/>
        </li>
        <!-- Notifications menu -->
    @include('assets.admin.header.notifications-menu')
    <!-- Profile menu -->
        @include('assets.admin.header.profile-menu')
    </ul>
</div>
