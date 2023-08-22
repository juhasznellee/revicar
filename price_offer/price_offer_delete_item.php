<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $id = $_GET['id'];
    $name = $_GET['name'];
    $amount = $_GET['amount'];

    $sql_delete = "DELETE FROM `price_offer` WHERE `id`='$id'";
    $result = $conection->query($sql_delete);

    $sql_select = "SELECT * FROM `storage` WHERE `name` = '$name';";
    $rs = $conection->query($sql_select);
    $row = $rs->fetch_assoc();
    $new_amount = $row['amount'] + (int)$amount;

    $sql_update = "UPDATE `storage` SET amount='$new_amount' WHERE `name`='$name';";
    $rs = $conection->query($sql_update);

    if ($result = 1 && $rs = 1) {
        $conection->close();
        header('Location: price_offer.php');
    }
    $conection->close();

?>