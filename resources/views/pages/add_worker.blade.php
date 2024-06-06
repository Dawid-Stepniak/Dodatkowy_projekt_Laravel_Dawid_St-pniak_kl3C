<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawanie pracowników</title>
    <link rel="stylesheet" href="{{ asset('css/styl.css') }}">
</head>
<body>
    <h2>Dodaj pracownika</h2>
    <div>
        <form method="post" action="/worker_form">
            @csrf
            <label for="firstName">Imię</label>
            <br>
            <input type="text" name="firstName" id="firstName"> @error('firstName'){{$message}}@enderror

            <br><br>
            
            <label for="lastName">Nazwisko</label>
            <br>
            <input type="text" name="lastName" id="lastName"> @error('lastName'){{$message}}@enderror

            <br><br>

            Płeć @error('sex'){{$message}}@enderror
            <br>
            <input type="radio" name="sex" id="male" value="male"><label for="male">Mężczyzna</label>
            <br>
            <input type="radio" name="sex" id="female" value="female"><label for="female">Kobieta</label>

            <br><br>

            <label for="email">Email</label>
            <br>
            <input type="email" name="email" id="email"> @error('email'){{$message}}@enderror

            <br><br>

            <label for="departament">Oddział</label>
            <br>
            <input type="text" name="departament" id="departament"> @error('departament'){{$message}}@enderror

            <br><br>

            <label for="authDegree">Poziom uprawnień</label>
            <select name="authDegree" id="authDegree"> @error('authDegree'){{$message}}@enderror
                <option value="1">1</option>
                <option value="2">2</opiton>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <br><br>
            <input type="submit" value="Dodaj pracownika">
        </form>
    </div>
    
    @if(isset($worker))
    <div>
        <br>
        <b>Pomyślnie dodano użytkownika: {{$worker['firstName']}}  {{$worker['lastName']}}</b>
    </div>
    @endif
</body>
</html>