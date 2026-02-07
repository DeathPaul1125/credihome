<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - CREDIHOME Portal de Clientes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-blue-900 mb-2">🏦 CREDIHOME</h1>
                <p class="text-gray-600">Portal de Clientes</p>
            </div>

            <!-- Card de Login -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Iniciar Sesión</h2>

                @if(session('status'))
                    <div class="mb-4 p-4 text-sm text-green-800 bg-green-50 rounded-lg" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-800 bg-red-50 rounded-lg" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                            Usuario
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="tu-email@credihome.gt" required autofocus>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                            Contraseña
                        </label>
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="••••••••" required>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="remember" class="ml-2 text-sm font-medium text-gray-900">
                                Recordarme
                            </label>
                        </div>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Ingresar al Portal
                    </button>
                </form>

                <!-- Información adicional -->
                <div class="mt-6 border-t pt-6">
                    <p class="text-xs text-gray-600 text-center">
                        📱 Si no tienes acceso al portal, contacta a tu asesor o comunícate con nosotros.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-600">
                    © {{ date('Y') }} CREDIHOME. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>
