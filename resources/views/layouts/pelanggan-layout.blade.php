<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ajeng Laundry' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 font-poppins min-h-screen text-gray-800">

    <x-navbar-pelanggan />

    <main>
        {{ $slot }}
    </main>

</body>
</html>