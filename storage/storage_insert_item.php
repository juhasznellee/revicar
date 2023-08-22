<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $txtName = '';
    $type = '';
    $motor = '';
    $id_number = '';
    $numbAmount = '';
    $numbPrice = '';

    if ($_POST){
        $txtName = $_POST['txtName'];
        $type = $_POST['type'];
        $motor = $_POST['motor'];
        $id_number = $_POST['idNumber'];
        $numbAmount = $_POST['numbAmount'];
        $numbPrice = $_POST['numbPrice'];

        $sql_insert = "INSERT INTO `storage` (`id`, `name`, `type`, `motor`, `id_number`, `amount`, `price`) VALUES ('0', '$txtName', '$type', '$motor', '$id_number', '$numbAmount', '$numbPrice')";

        $rs = mysqli_query($conection, $sql_insert);

        $conection->close();
    }
    header('Location: storage.php');
?>