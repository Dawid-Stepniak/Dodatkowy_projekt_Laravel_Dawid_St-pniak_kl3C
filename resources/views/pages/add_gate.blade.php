<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawanie bram</title>
    <link rel="stylesheet" href="{{ asset('css/styl.css') }}">
</head>
<body>
    <h2>Dodaj bramę</h2>
    <div>
        <form method="post" action="/gate_form">
            @csrf
            <label for="gateName">Nazwa bramy</label>
            <br>
            <input type="text" name="gateName" id="gateName"> @error('gateName'){{$message}}@enderror
            <br><br>
            <label for="authDegreeRequired">Wymagany poziom uprawnień</label>
            <br>
            <select name="authDegreeRequired" id="authDegreeRequired"> @error('authDegreeRequired'){{$message}}@enderror
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</opiton>
                <option value="4">4</option>
            </select>
            <br><br>
            <input type="submit" value="Dodaj bramę">
        </form>
    </div>
    <div>
        @if(isset($gate))
        <br>
        <b>Pomyślnie dodano bramę: {{$gate['gateName']}}, z wymaganym poziomem uprawnień: {{$gate['authDegreeRequired']}}</b>
        @endif
    </div>
    <a href="/">Powrót do strony głównej</a>
</body>
</html>