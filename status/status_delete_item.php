<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $name = $_GET['name'];
    $id = $_GET['id'];

    $sql_update = "DELETE FROM `status` WHERE `id`='$id'";
    $result = $conection->query($sql_update);

    if ($result = 1) {
        $conection->close();
        header('Location: status.php');
    }
    $conection->close();

?>