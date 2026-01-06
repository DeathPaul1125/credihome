<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CrediHome') }} - Iniciar Sesión</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900">

    <div class="flex min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            @php
                $configuracion = \App\Models\Configuracion::first();
            @endphp
            @if($configuracion && $configuracion->logo_login)
                <div class="flex justify-center">
                    <img src="{{ Storage::url($configuracion->logo_login) }}" alt="Logo" class="h-16 w-auto">
                </div>
            @else
                <div class="flex justify-center">
                    <svg class="h-16 w-auto text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 7V17C2 19.21 3.79 21 6 21H18C20.21 21 22 19.21 22 17V7L12 2ZM12 4.84L20 8.92V17C20 18.1 19.1 19 18 19H6C4.9 19 4 18.1 4 17V8.92L12 4.84ZM11 11H13V17H11V11ZM11 7H13V9H11V7Z"/>
                    </svg>
                </div>
            @endif
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                Iniciar Sesión
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                O
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                    crear una nueva cuenta
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 dark:bg-gray-800">
                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Correo Electrónico
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" :value="old('email')" required autofocus
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Contraseña
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                Recordarme
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
