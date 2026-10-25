<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moesika Lashes by Tania</title>
    <meta name="description" content="Custom lash extensions, permanent makeup and accredited lash training by Tania Collins, from a private home studio.">
    <meta name="theme-color" content="#6E7C61">

    <link rel="icon" type="image/png" href="{{ asset('images/logo_short.png') }}">

    <script>document.documentElement.classList.add('js')</script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Montserrat+Alternates:wght@300;400;500&display=swap" rel="stylesheet">

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
