<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @routes
        @vite(['resources/js/app.js'])
        <title>Integrate-Vue3-Inertia-Bootstrap-with-Laravel9</title>
        @inertiaHead
    </head>

    <body>
        @inertia
    </body>

</html>
