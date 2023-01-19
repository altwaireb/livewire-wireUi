<x-list-sidebar
        :title="__('app.admin index')"
        routeName="admin.index"
        icon="home"
/>
<x-list-sidebar
        :title="__('users.users')"
        routeName="admin.users.index"
        icon="user-group"
/>
<x-list-sidebar
        :title="__('roles.roles')"
        routeName="admin.roles.index"
        icon="adjustments"
/>
<x-list-sidebar
        :title="__('settings.settings')"
        routeName="admin.settings.index"
        icon="cog"
/>
<li class="relative px-6 py-3" x-data="{ isPagesMenuOpen : false }">
    <button
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            @click="isPagesMenuOpen = !isPagesMenuOpen"
            aria-haspopup="true"
    >
                <span class="inline-flex items-center">
                    <x-icon name="template" class="w-5 h-5"/>
                  <span class="ltr:ml-4 rtl:mr-4">Pages</span>
                </span>
        <x-icon name="chevron-down" class="w-4 h-4"/>
    </button>
    <template x-if="isPagesMenuOpen">
        <ul
                x-transition:enter="transition-all ease-in-out duration-300"
                x-transition:enter-start="opacity-25 max-h-0"
                x-transition:enter-end="opacity-100 max-h-xl"
                x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl"
                x-transition:leave-end="opacity-0 max-h-0"
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-secondary-500 rounded-md shadow-inner bg-secondary-50 dark:text-secondary-400 dark:bg-secondary-900"
                aria-label="submenu"
        >
            <li
                    class="px-2 py-1 transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            >
                <a class="w-full" href="pages/login.html">Login</a>
            </li>
            <li
                    class="px-2 py-1 transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            >
                <a class="w-full" href="pages/create-account.html">
                    Create account
                </a>
            </li>
            <li
                    class="px-2 py-1 transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            >
                <a class="w-full" href="pages/forgot-password.html">
                    Forgot password
                </a>
            </li>
            <li
                    class="px-2 py-1 transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            >
                <a class="w-full" href="pages/404.html">404</a>
            </li>
            <li
                    class="px-2 py-1 transition-colors duration-150 hover:text-secondary-800 dark:hover:text-secondary-200"
            >
                <a class="w-full" href="pages/blank.html">Blank</a>
            </li>
        </ul>
    </template>
</li>
