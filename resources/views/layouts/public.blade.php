<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $trabalho->nome ?? 'Visualização de Trabalho' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: #f9f9f9; text-align: center;">
    <div class="container mt-5">
        @yield('content')
    </div>
</body>
</html>
