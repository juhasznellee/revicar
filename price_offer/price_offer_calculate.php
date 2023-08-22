<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }

    $discount = '';
    $deposit = '';

    if ($_POST){
        $sql_delete = "DELETE FROM `calculated`";
        $result = $conection->query($sql_delete);

        $discount = $_POST['discount'];
        $deposit = $_POST['deposit'];

        $sql_select = "SELECT * FROM `plate` WHERE 1;";
        $result = $conection->query($sql_select);
        $row = $result->fetch_assoc();
        $plate_number = $row['plate_number'];
    
        $sql_select = "SELECT * FROM `price_offer` WHERE `plate_number` = '$plate_number'";
        $result = $conection->query($sql_select);
    
        $sum_parts = 0;
        $sum_job = 0;
        $sum_all = 0;
        $discount_parts_sum = 0;
        $owing = 0;
        $remainer = 0;
        $savings = 0;
    
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $price = $row['price'];
                $amount = $row['amount'];
                $labor_fee = $row['labor_fee'];
                $sum_parts = (int)$sum_parts + ((int)$price * (int)$amount);
                $sum_job = (int)$sum_job + (int)$labor_fee;
            }
            $result->free();
        }
        $sum_all = (int)$sum_parts + (int)$sum_job;
        $discount_parts_sum = (int)$sum_parts * (1 - ((int)$discount / 100));
        $owing = (int)$discount_parts_sum + (int)$sum_job;
        $remainer = (int)$owing - (int)$deposit;
        $savings = (int)$sum_parts - (int)$discount_parts_sum;


        $sql_insert = "INSERT INTO `calculated` (`id`, `discount`, `deposit`, `sum_parts`, `sum_job`, `sum_all`, `discount_sum`, `owing`, `remainer`, `savings`, `plate_number`) VALUES ('0', '$discount', '$deposit', '$sum_parts', '$sum_job', '$sum_all', '$discount_parts_sum', '$owing', '$remainer', '$savings', '$plate_number')";
        $rs = mysqli_query($conection, $sql_insert);
        $conection->close();
    }
    header('Location: price_offer.php');

?>  