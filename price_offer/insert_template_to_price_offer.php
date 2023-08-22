<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $template = '';
    $templateName = '';
    $plate_number = '';

    if ($_POST){
        $sql_select = "SELECT * FROM `plate` WHERE 1;";
        $result = $conection->query($sql_select);
        $row = $result->fetch_assoc();
        $plate_number = $row['plate_number'];

        $template = $_POST['template'];
        $sql_select = "SELECT * FROM `all_template` WHERE `id` = '$template';";
        $result = $conection->query($sql_select);
        $row = $result->fetch_assoc();
        $templateName = $row['name'];

        $sql_select = "SELECT * FROM `template_info` WHERE `template` = '$templateName';";
        $result = $conection->query($sql_select);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $name = $row['name'];
                $price = $row['price'];
                $amount = $row['amount'];
                $status = $row['status'];
                $todo = $row['todo'];
                $laborFee = $row['labor_fee'];

                $sql_select2 = "SELECT * FROM `storage` WHERE `name` = '$name';";
                $rs = $conection->query($sql_select2);
                $row2 = $rs->fetch_assoc();
                $new_amount = (int)$row2['amount'] - (int)$amount;

                $sql_update = "UPDATE `storage` SET `amount` = '$new_amount' WHERE `name`='$name'";
                $rs = $conection->query($sql_update);
                
                $sql_insert = "INSERT INTO `price_offer` (`id`, `name`, `price`, `amount`, `status`, `todo`, `labor_fee`, `plate_number`) VALUES ('0', '$name', '$price', '$amount', '$status', '$todo', '$laborFee', '$plate_number')";
                $rs = mysqli_query($conection, $sql_insert);
            }
            $result->free();
        }
        $conection->close();
        
    }
    header('Location: price_offer.php');
?>