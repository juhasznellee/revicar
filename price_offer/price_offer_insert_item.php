<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $selectedName = '';
    $amount = '';
    $partStatus = '';
    $todo = '';
    $laborFee = '';
    $plate_number = '';
    $name = '';
    $status = '';
    $price = '';
    $job = '';

    if ($_POST){
        $selectedName = $_POST['selectedName'];
        $amount = $_POST['amount'];
        $partStatus = $_POST['partStatus'];
        $todo = $_POST['todo'];
        $job = $_POST['job'];
        $laborFee = $_POST['laborFee'];

        $sql_select = "SELECT * FROM `plate` WHERE 1;";
        $result = $conection->query($sql_select);
        $row = $result->fetch_assoc();
        $plate_number = $row['plate_number'];
        
        $sql_select = "SELECT * FROM `status` WHERE `id` = '$partStatus';";
        $result = $conection->query($sql_select);
        $row = $result->fetch_assoc();
        $status = $row['name'];

        if($todo == ''){
            $job = 'Csere';
        }else{
            $sql_select = "SELECT * FROM `job` WHERE `id` = '$todo';";
            $result = $conection->query($sql_select);
            $row = $result->fetch_assoc();
            $job = $row['name'];
        }

        $sql_select = "SELECT * FROM `storage` WHERE `id` = '$selectedName';";
        $result = $conection->query($sql_select);
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $price = $row['price'];
        $new_amount = $row['amount'] - (int)$amount;

        $sql_update = "UPDATE `storage` SET amount='$new_amount' WHERE `id`='$selectedName'";
        $result = $conection->query($sql_update);
        
        $sql_insert = "INSERT INTO `price_offer` (`id`, `name`, `price`, `amount`, `status`, `todo`, `labor_fee`, `plate_number`) VALUES ('0', '$name', '$price', '$amount', '$status', '$job', '$laborFee', '$plate_number')";

        $rs = mysqli_query($conection, $sql_insert);

        $conection->close();
        
    }
    header('Location: price_offer.php');
?>