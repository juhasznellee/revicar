<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $plate_number = '';
    $date = '';
    $time = '';
    $work = '';

    if ($_POST){
        $plate_number = $_POST['plate_number'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $work = $_POST['work'];

        $sql_insert = "INSERT INTO `calendar` (`id`, `car`, `date`, `time`, `work`) VALUES ('0', '$plate_number', '$date', '$time', '$work')";

        $rs = mysqli_query($conection, $sql_insert);

        $conection->close();
        
    }
    header('Location: calendar.php');
?>