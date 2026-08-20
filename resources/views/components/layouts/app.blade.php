<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moesika Lashes by Tania</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('partials.header')

<main>
    {{ $slot }}
</main>

@include('partials.footer')
</body>
</html>
