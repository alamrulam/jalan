<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-G">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            @if (session('success'))
                                <div
                                    class="mb-4 font-medium text-sm text-green-600 bg-green-100 border border-green-400 p-3 rounded">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div
                                    class="mb-4 font-medium text-sm text-red-600 bg-red-100 border border-red-400 p-3 rounded">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
