<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $template = '';
    
    if ($_POST){
        $insert = true;
        $sql_delete = "DELETE FROM `template`";
        $result = $conection->query($sql_delete);

        $template = $_POST['template'];
        $sql_insert = "INSERT INTO `template` (`id`, `name`) VALUES ('0', '$template')";
        $rs = mysqli_query($conection, $sql_insert);

        $sql_select = "SELECT * FROM `all_template`";
        $result = $conection->query($sql_select);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row['name'] == $template){
                    $insert = false;
                }
            }
            $result->free();
        }

        if ($insert == true){
            $sql_insert = "INSERT INTO `all_template` (`id`, `name`) VALUES ('0', '$template')";
            $rs = mysqli_query($conection, $sql_insert);
        }

        $conection->close();
    }
    header('Location: template.php');
?>