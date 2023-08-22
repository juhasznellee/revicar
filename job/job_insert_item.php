<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $txtName = '';

    if ($_POST){
        $txtName = $_POST['txtName'];

        $sql_insert = "INSERT INTO `job` (`id`, `name`) VALUES ('0', '$txtName')";

        $rs = mysqli_query($conection, $sql_insert);

        $conection->close();
    }
    header('Location: job.php');
?>