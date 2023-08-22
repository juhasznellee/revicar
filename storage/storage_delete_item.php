<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $id = $_GET['id'];

    $sql_delete = "DELETE FROM `storage` WHERE `id`='$id'";
    $result = $conection->query($sql_delete);

    if ($result = 1) {
        $conection->close();
        header('Location: storage.php');
    }
    $conection->close();

?>