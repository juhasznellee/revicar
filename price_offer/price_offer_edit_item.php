<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../base.css">
  <title>Árajánló - Szerkesztő</title>
</head>
<body>
  <?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
      die("Connection failed: " . $conection->connect_error);
    }

    $id = $_GET['id'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $amount = $_GET['amount'];
    $status = $_GET['status'];
    $todo = $_GET['todo'];
    $labor_fee = $_GET['labor_fee'];
    
  ?>
  <div class="editField">
      <a href="price_offer.php" class="cancel_button">
          <img src="../images/cancel.png" class='cancel' alt="Back">
      </a>
      <form action="" method="POST" class="editor">
          <span class="red">Név:&nbsp;&nbsp; <?php echo $name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Egységár:&nbsp;&nbsp; <?php echo number_format("$price",0,"."," "); ?> Ft </span><br>
          <label for="amount">Mennyiség:</label>&nbsp;&nbsp;
          <input class="numberFieldBlack" type="number" name="amount" value="<?php echo $amount; ?>" autoComplete="off"><br>
          <label for="todo">Munka:</label>&nbsp;&nbsp;
          <input class="txtFieldLongBlack" type="text" name="todo" value="<?php echo $todo; ?>" autoComplete="off"><br>
          <label for="labor_fee">Munkadíj:</label>&nbsp;&nbsp;
          <input class="numberFieldBlack" type="number" name="labor_fee" value="<?php echo number_format("$labor_fee",0,"."," "); ?>" autoComplete="off"> Ft<br>
          <button type="submit" name='update' class="save_button">
              <img src="../images/save.png" class='save' alt="Save">
          </button>  
      </form>
  </div>
  <?php
    if (isset($_POST['update'])) {
        $new_amount = $_POST['amount'];
        $new_todo = $_POST['todo'];
        $new_labor_fee = $_POST['labor_fee'];

        $sql_select1 = "SELECT * FROM `price_offer` WHERE `id` = '$id'";
        $rs = $conection->query($sql_select1);
        $row = $rs->fetch_assoc();
        $old_amount = $row['amount'];

        $sql_select2 = "SELECT * FROM `storage` WHERE `name` = '$name'";
        $rs = $conection->query($sql_select2);
        $row = $rs->fetch_assoc();
        $storage_amount = $row['amount'];

        if($new_amount > $old_amount){
            $t1 = $new_amount - $old_amount;
            $t2 = $storage_amount - $t1;
            $sql_update1 = "UPDATE `storage` SET `amount`='$t2' WHERE `name`='$name'";
            $rs1 = $conection->query($sql_update1);
        }else if ($new_amount < $old_amount){
            $t1 = $old_amount - $new_amount;
            $t2 = $storage_amount + $t1;
            $sql_update1 = "UPDATE `storage` SET `amount`='$t2' WHERE `name`='$name'";
            $rs1 = $conection->query($sql_update1);
        }
        
        $sql_update2 = "UPDATE `price_offer` SET `amount`='$new_amount' WHERE `id`='$id'";
        $rs2 = $conection->query($sql_update2);

        $sql_update3 = "UPDATE `price_offer` SET `todo`='$new_todo' WHERE `id`='$id'";
        $rs3 = $conection->query($sql_update3);

        $sql_update4 = "UPDATE `price_offer` SET `labor_fee`='$new_labor_fee' WHERE `id`='$id'";
        $rs4 = $conection->query($sql_update4);

        if ($rs1 = 1 && $rs2 = 1 && $rs3 = 1 && $rs4 = 1) {
            $conection->close();
            header('Location: price_offer.php');
        }
    }
    $conection->close();
  ?>
</body>
</html>