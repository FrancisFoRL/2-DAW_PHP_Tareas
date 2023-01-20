<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Tailwind CSS-->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--Sweet Alert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>@yield('titulo')</title>
</head>

<body style="background-color:aquamarine">
    <h3 class="my-2 text-center text-lg">@yield('cabecera')</h3>
    <div class="container mx-auto">
        @yield('contenido')
    </div>
    @yield('js')
</body>

</html>
