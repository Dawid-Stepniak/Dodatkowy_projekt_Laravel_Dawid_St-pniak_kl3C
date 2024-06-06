<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista pracowników</title>
    <link rel="stylesheet" href="{{ asset('css/styl.css') }}">
</head>
<body>
    <div>
        <form method="post" action="/check_worker">
            @csrf
        <label for="selectWorker">Wybierz pracownika</label><br>
        <select name="selectWorker" id="selectWorker">
            
            <?php //generowanie opcji w tabeli seletWorker na podstawie pracowników w bazie danych
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname= 'system_bram_i_pracownikow';
            $conn = mysqli_connect($servername,$username,$password,$dbname);

            $sql = 'SELECT id,firstName, lastName FROM workers;';
            $result=mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $selected = Session::get('selectedWorker') == $row['id'] ? 'selected' : '';//sprawdzamy czy ten pracownik był poprzednio wybrany, jeżeli tak to do elementu option zostaje dodane "selected"
                echo "<option value='".$row['id']."' ".$selected.">".$row['firstName']." ".$row['lastName']."</option>";
            }
            
            ?>
        </select>
        <br><br>
        <input type="submit" value="Sprawdź">
        </form>
    </div>

    <div>
        @if(isset($workerId))
        <?php
        echo $workerId;
        ?>
        @endif
    </div>

    
    @if(isset($workerId))
    <table>
        <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Oddział</th>
            <th>Email</th>
        </tr>
    <?php //wydobywanie wybranego w polu select pracownika (a następnie jego id)
    $sqlWorker = "SELECT * FROM workers WHERE id LIKE '$workerId';";
    $resultWorker = mysqli_query($conn,$sqlWorker);
    $rowWorker = mysqli_fetch_assoc($resultWorker);
    $workerAuthDegree = $rowWorker['authDegree'];

    echo <<<HEREDOC
        <tr>
        <td>{$rowWorker['firstName']}</td><td>{$rowWorker['lastName']}</td><td>{$rowWorker['departament']}</td><td>{$rowWorker['email']}</td>
        </tr>
        HEREDOC;
    ?>
    </table>
    
    Bramy do których ma dostęp pracownik <b>{{$rowWorker['firstName']}} {{$rowWorker['lastName']}}</b>:
    <br><br><br>
    <table>
        <tr>
            <th>ID bramy</th>
            <th>Nazwa bramy</th>
            <th>Potrzebny poziom uprawnień</th>
        </tr>
        <?php //tworzenie wierszy tabeli z bramami do których wybrany pracownik ma dostęp

        $gates = mysqli_query($conn,"SELECT * FROM gates WHERE authDegreeReq <= '$workerAuthDegree' ORDER BY authDegreeReq ASC;");//wybieramy wszystkie bramy, których poziom autoryzacji jest taki sam lub niższy niż pracownika
        while($row = mysqli_fetch_assoc($gates)){
            echo <<<HEREDOC
            <tr>
                <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['authDegreeReq']}</td>
            </tr>
            HEREDOC;

        }
        mysqli_close($conn);
        ?>
    </table>
    @endif
    
</body>
</html>