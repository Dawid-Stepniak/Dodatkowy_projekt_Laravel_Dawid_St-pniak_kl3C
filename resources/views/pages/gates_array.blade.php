<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista bram</title>
    <link rel="stylesheet" href="{{ asset('css/styl.css') }}">
</head>
<body>
    <div>
        <form method="post" action="/check_gate">
            @csrf
        <label for="selectGate">Wybierz bramę</label><br>
        <select name="selectGate" id="selectGate">
            
            <?php //generowanie opcji w tabeli seletWorker na podstawie pracowników w bazie danych
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname= 'system_bram_i_pracownikow';
            $conn = mysqli_connect($servername,$username,$password,$dbname);

            $sql = 'SELECT id,`name` FROM gates;';
            $result=mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $selected = Session::get('selectedGate') == $row['id'] ? 'selected' : '';//sprawdzamy czy ta brama była poprzednio wybrana, jeżeli tak to do elementu option zostaje dodane "selected"
                echo "<option value='".$row['id']."' ".$selected.">".$row['name']."</option>";
            }
            
            ?>
        </select>
        <br><br>
        <input type="submit" value="Sprawdź">
        </form>
    </div>

    <div>
        @if(isset($gateId))
        <?php
        echo $gateId;
        ?>
        @endif
    </div>

    
    @if(isset($gateId))
    <table>
        <tr>
            <th>Nazwa</th>
            <th>Potrzebny poziom uprawnień</th>
        </tr>
    <?php //wydobywanie wybranej w polu select bramy (a następnie jej id)
    $sqlGate = "SELECT * FROM gates WHERE id LIKE '$gateId';";
    $resultGate = mysqli_query($conn,$sqlGate);
    $rowGate = mysqli_fetch_assoc($resultGate);
    $gateAuthDegreeReq = $rowGate['authDegreeReq'];

    echo <<<HEREDOC
        <tr>
        <td>{$rowGate['name']}</td><td>{$rowGate['authDegreeReq']}</td>
        </tr>
        HEREDOC;
    ?>
    </table>
    
    Pracownicy, którzy mają dostęp do bramy <b>{{$rowGate['name']}}</b>:
    <br><br><br>
    <table>
        <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Poziom autoryzacji</th>
            <th>Oddział</th>
            <th>Email</th>
        </tr>
        <?php //tworzenie wierszy pracowników, którzy mają dostęp do wybranej bramy

        $workers = mysqli_query($conn,"SELECT * FROM workers WHERE authDegree >= '$gateAuthDegreeReq' ORDER BY lastName ASC;");//wybieramy wszystkich pracowników, którzy mają poziom autoryzaji taki sam lub wyższy niż brama
        while($row = mysqli_fetch_assoc($workers)){
            echo <<<HEREDOC
            <tr>
                <td>{$row['firstName']}</td><td>{$row['lastName']}</td><td>{$row['authDegree']}</td><td>{$row['departament']}</td><td>{$row['email']}</td>
            </tr>
            HEREDOC;

        }
        mysqli_close($conn);
        ?>
    </table>
    @endif
    
</body>
</html>