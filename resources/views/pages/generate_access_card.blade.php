<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generowanie karty dostępu dla pracowników</title>
    <link rel="stylesheet" href="{{ asset('css/styl.css') }}">
</head>
<body>
    <form method="post" action="/generate_pdf">
    @csrf
    Wybierz pracowników dla których chcesz wygenerować karty dostępu:<br>
    <?php
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="system_bram_i_pracownikow";
    $conn = mysqli_connect($servername,$username,$password,$dbname);
    $sqlWorkers = "SELECT * FROM workers ORDER BY lastName ASC;";
    $resultWorkers = mysqli_query($conn,$sqlWorkers);
    ?>

    
    <?php
    while($rowWorkers = mysqli_fetch_assoc($resultWorkers)){
        echo "<input type='checkbox' name='checkbox[]' id='".$rowWorkers['id']."' value='".$rowWorkers['id']."'>
        <label for='".$rowWorkers['id']."'>".$rowWorkers['firstName']." ".$rowWorkers['lastName']."</label>";
        echo "<br><br>";
    }
    ?>
    <input type="submit" value="Wygeneruj karty dostępu">
    </form>
</body>
</html>