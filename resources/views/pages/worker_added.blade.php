<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodano pracownika</title>
    <link rel="stylesheet" href="{{ asset('css/styl.css') }}">
</head>
<body>
    Dodano pracownika {{$worker['firstName']}} {{$worker['lastName']}}<br><br>
    <a href="/add_worker">Dodaj kolejnego pracownika</a><br><br>
    <a href="/">Powrót do strony głównej</a>
</body>
</html>