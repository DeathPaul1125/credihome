<!-- Header Start -->
<header
    class="sticky top-0 z-999 flex w-full bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-800"
>
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-sm md:px-6 2xl:px-11">
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
            <!-- Hamburger Toggle BTN -->
            <button
                class="z-99999 block rounded-lg border border-gray-200 bg-white p-1.5 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:hidden"
                @click.stop="sidebarToggle = !sidebarToggle"
            >
                <span class="relative block h-5.5 w-5.5 cursor-pointer">
                    <span class="block absolute right-0 h-full w-full">
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-900 delay-[0] duration-200 ease-in-out dark:bg-white"
                            :class="!sidebarToggle && '!w-full delay-300'"
                        ></span>
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-900 delay-150 duration-200 ease-in-out dark:bg-white"
                            :class="!sidebarToggle && '!w-full delay-400'"
                        ></span>
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-900 delay-200 duration-200 ease-in-out dark:bg-white"
                            :class="!sidebarToggle && '!w-full delay-500'"
                        ></span>
                    </span>
                    <span class="absolute right-0 h-full w-full rotate-45">
                        <span
                            class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-gray-900 delay-300 duration-200 ease-in-out dark:bg-white"
                            :class="!sidebarToggle && '!h-0 !delay-[0]'"
                        ></span>
                        <span
                            class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-gray-900 duration-200 ease-in-out dark:bg-white"
                            :class="!sidebarToggle && '!h-0 !delay-200'"
                        ></span>
                    </span>
                </span>
            </button>
        </div>

        <div class="hidden sm:block">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        <div class="flex items-center gap-3 2xsm:gap-7">
            <!-- Dark Mode Toggler -->
            <button
                @click="darkMode = !darkMode"
                class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border border-gray-200 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
            >
                <svg
                    :class="!darkMode && 'hidden'"
                    class="fill-current text-gray-700 dark:text-gray-300"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M10 1.25C5.16844 1.25 1.25 5.16844 1.25 10C1.25 14.8316 5.16844 18.75 10 18.75C14.8316 18.75 18.75 14.8316 18.75 10C18.75 5.16844 14.8316 1.25 10 1.25ZM10 17.1875C6.02812 17.1875 2.8125 13.9719 2.8125 10C2.8125 6.02812 6.02812 2.8125 10 2.8125C13.9719 2.8125 17.1875 6.02812 17.1875 10C17.1875 13.9719 13.9719 17.1875 10 17.1875Z"/>
                    <path d="M10 5C7.23906 5 5 7.23906 5 10C5 12.7609 7.23906 15 10 15V5Z"/>
                </svg>
                <svg
                    :class="darkMode && 'hidden'"
                    class="fill-current text-gray-700"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M10.0527 2.50879C9.87012 2.50879 9.6875 2.59766 9.5957 2.77539C9.5332 2.89453 9.50781 3.04395 9.54883 3.19336C9.97949 4.93359 9.4707 6.82324 8.14844 8.11621C6.82617 9.40918 4.93652 9.88867 3.19629 9.48828C3.04688 9.44727 2.89746 9.47266 2.7832 9.53516C2.60547 9.62695 2.51953 9.8125 2.51953 9.99512C2.51953 13.5283 5.43359 16.4424 8.96973 16.4424C12.5059 16.4424 15.4199 13.5283 15.4199 9.99512C15.4199 5.90137 12.2686 2.50879 10.0527 2.50879ZM8.96973 14.8799C6.29395 14.8799 4.08203 12.668 4.08203 9.99512C4.08203 9.7998 4.10449 9.60449 4.11719 9.40918C6.12305 9.7373 8.28809 9.15527 9.8125 7.65723C11.3369 6.15918 11.9512 4.05176 11.623 2.04004C13.5615 2.75684 15.0488 4.80176 15.0488 9.99512C15.0488 12.668 12.8369 14.8799 10.1602 14.8799H8.96973Z"/>
                </svg>
            </button>

            <!-- Notification -->
            <div x-data="{ notificationOpen: false }" class="relative">
                <button
                    @click="notificationOpen = !notificationOpen"
                    class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border border-gray-200 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                >
                    <span class="absolute -top-0.5 -right-0.5 z-1 h-2 w-2 rounded-full bg-red-500">
                        <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                    </span>
                    <svg class="fill-current text-gray-700 dark:text-gray-300" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1999 14.9343L15.6374 14.0624C15.5249 13.8937 15.4687 13.7249 15.4687 13.528V7.67803C15.4687 6.01865 14.7655 4.47178 13.4718 3.31865C12.4312 2.39053 11.0812 1.7999 9.64678 1.6874V1.1249C9.64678 0.787402 9.36553 0.478027 8.9999 0.478027C8.6624 0.478027 8.35303 0.759277 8.35303 1.1249V1.65928C8.29678 1.65928 8.24053 1.65928 8.18428 1.6874C4.92178 2.05303 2.4749 4.66865 2.4749 7.79053V13.528C2.44678 13.8093 2.39053 13.9499 2.33428 14.0343L1.7999 14.9343C1.63115 15.2155 1.63115 15.553 1.7999 15.8343C1.96865 16.0874 2.2499 16.2562 2.55928 16.2562H8.38115V16.8749C8.38115 17.2124 8.6624 17.5218 9.02803 17.5218C9.36553 17.5218 9.6749 17.2405 9.6749 16.8749V16.2562H15.4687C15.778 16.2562 16.0593 16.0874 16.228 15.8343C16.3968 15.553 16.3968 15.2155 16.1999 14.9343ZM3.23428 14.9905L3.43115 14.653C3.5999 14.3718 3.68428 14.0343 3.74053 13.6405V7.79053C3.74053 5.31553 5.70928 3.23428 8.3249 2.95303C9.92803 2.78428 11.503 3.2624 12.6562 4.2749C13.6687 5.1749 14.2312 6.38428 14.2312 7.67803V13.528C14.2312 13.9499 14.3437 14.3437 14.5968 14.7374L14.7374 14.9905H3.23428Z"/>
                    </svg>
                </button>

                <!-- Notification Dropdown -->
                <div
                    x-show="notificationOpen"
                    @click.outside="notificationOpen = false"
                    class="absolute -right-27 mt-2.5 flex h-90 w-75 flex-col rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-800 dark:bg-gray-900 sm:right-0 sm:w-80"
                >
                    <div class="px-4.5 py-3 border-b border-gray-200 dark:border-gray-800">
                        <h5 class="text-sm font-medium text-gray-900 dark:text-white">Notificaciones</h5>
                    </div>

                    <div class="flex h-auto flex-col overflow-y-auto">
                        <div class="flex flex-col gap-2.5 border-t border-gray-200 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Bienvenido a TailAdmin Dashboard
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Hace 12 min</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Area -->
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button
                    @click="dropdownOpen = !dropdownOpen"
                    class="flex items-center gap-4"
                >
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">
                            {{ Auth::user()->email }}
                        </span>
                    </span>

                    <span class="h-10 w-10 rounded-full overflow-hidden">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover" />
                    </span>

                    <svg
                        class="hidden fill-current sm:block text-gray-700 dark:text-gray-300"
                        width="12"
                        height="8"
                        viewBox="0 0 12 8"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div
                    x-show="dropdownOpen"
                    @click.outside="dropdownOpen = false"
                    class="absolute right-0 mt-4 flex w-62.5 flex-col rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-800 dark:bg-gray-900"
                >
                    <div class="px-4.5 py-3 border-b border-gray-200 dark:border-gray-800">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            {{ Auth::user()->email }}
                        </span>
                    </div>

                    <ul class="flex flex-col gap-1 border-b border-gray-200 px-4.5 py-3 dark:border-gray-800">
                        <li>
                            <a
                                href="{{ route('profile.show') }}"
                                class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-brand-500 lg:text-base"
                            >
                                <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.28125 2.16562 7.90625 3.50624 7.90625 5.12187C7.90625 6.73749 9.28125 8.07812 11 8.07812C12.7188 8.07812 14.0938 6.73749 14.0938 5.12187C14.0938 3.50624 12.7188 2.16562 11 2.16562Z"/>
                                    <path d="M17.7719 21.4156H4.22813C3.28125 21.4156 2.40625 20.8969 2.06563 20.0469C1.76563 19.2656 1.86563 18.3469 2.38125 17.5656C4.01563 15.1469 6.91563 13.7906 10.0469 13.7906C13.1781 13.7906 16.0781 15.1469 17.7125 17.5656C18.2281 18.3469 18.3281 19.2656 18.0281 20.0469C17.6875 20.8969 16.8125 21.4156 17.7719 21.4156ZM10.0469 15.2656C7.40625 15.2656 4.98438 16.3469 3.59375 18.3469C3.25313 18.8469 3.18125 19.3469 3.35938 19.7781C3.53125 20.2094 3.88125 20.4719 4.36563 20.4719H17.9094C18.3938 20.4719 18.7438 20.2094 18.9156 19.7781C19.0938 19.3469 19.0219 18.8469 18.6813 18.3469C17.2906 16.3469 14.8688 15.2656 10.0469 15.2656Z"/>
                                </svg>
                                Mi Perfil
                            </a>
                        </li>
                    </ul>

                    <div class="px-4.5 py-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-brand-500 lg:text-base"
                            >
                                <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5375 0.618744H11.6531C10.7594 0.618744 10.0031 1.37499 10.0031 2.26874V4.64062C10.0031 5.05312 10.3469 5.39687 10.7594 5.39687C11.1719 5.39687 11.55 5.05312 11.55 4.64062V2.23437C11.55 2.16562 11.5844 2.13124 11.6531 2.13124H15.5375C16.3625 2.13124 17.0156 2.78437 17.0156 3.60937V18.3562C17.0156 19.1812 16.3625 19.8344 15.5375 19.8344H11.6531C11.5844 19.8344 11.55 19.8 11.55 19.7312V17.3594C11.55 16.9469 11.2062 16.6031 10.7594 16.6031C10.3125 16.6031 10.0031 16.9469 10.0031 17.3594V19.7312C10.0031 20.625 10.7594 21.3812 11.6531 21.3812H15.5375C17.2219 21.3812 18.5625 20.0062 18.5625 18.3562V3.64374C18.5625 1.95937 17.1875 0.618744 15.5375 0.618744Z"/>
                                    <path d="M6.05001 11.7563H12.2031C12.6156 11.7563 12.9594 11.4125 12.9594 11C12.9594 10.5875 12.6156 10.2438 12.2031 10.2438H6.08439L8.21564 8.07813C8.52501 7.76875 8.52501 7.2875 8.21564 6.97812C7.90626 6.66875 7.42501 6.66875 7.11564 6.97812L3.67814 10.4844C3.36876 10.7938 3.36876 11.275 3.67814 11.5844L7.11564 15.0906C7.25314 15.2281 7.45939 15.3312 7.66564 15.3312C7.87189 15.3312 8.04376 15.2625 8.21564 15.125C8.52501 14.8156 8.52501 14.3344 8.21564 14.025L6.05001 11.7563Z"/>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->
