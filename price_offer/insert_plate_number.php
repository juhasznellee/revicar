<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $plate_number = '';
    $type = '';
    $motor = '';

    if ($_POST){
        $sql_delete = "DELETE FROM `plate`";
        $result = $conection->query($sql_delete);

        $plate_number = $_POST['plate_number'];
        $type = $_POST['type'];
        $motor = $_POST['motor'];
        $sql_insert = "INSERT INTO `plate` (`id`, `plate_number`, `type`, `motor`) VALUES ('0', '$plate_number', '$type', '$motor')";

        $rs = mysqli_query($conection, $sql_insert);

        $conection->close();
    }
    header('Location: price_offer.php');
?>