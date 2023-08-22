<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../base.css">
  <title>Raktár - Szerkesztő</title>
</head>
<body>
  <?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
      die("Connection failed: " . $conection->connect_error);
    }

    $name = $_GET['name'];
    $type = $_GET['type'];
    $motor = $_GET['motor'];
    $id_number = $_GET['id_number'];
    $amount = $_GET['amount'];
    $price = $_GET['price'];
    $id = $_GET['id'];
  ?>
  <div class="editField">
    <a href="storage.php" class="cancel_button_storage">
        <img src="../images/cancel.png" class='cancel' alt="Back">
    </a>
    <form action="" method="POST" class="editor">
      <span class="red">Név:&nbsp;&nbsp; <?php echo $name; ?></span> <br>
      <label for="amount">Vásárolt mennyiség:</label>&nbsp;&nbsp;
      <input class="numberFieldBlack" type="number" name="amount" value=0 autoComplete="off"> <br>
      <label for="price">Egységár:</label>&nbsp;&nbsp;
      <input class="numberFieldBlack" type="number" name="price" value="<?php echo $price; ?>" autoComplete="off"> Ft<br>
      <label for="type">Típus:</label>&nbsp;&nbsp;
      <input class="txtFieldShortBlack" type="text" name="type" value="<?php echo $type; ?>" autoComplete="off"> <br>
      <label for="motor">Motor:</label>&nbsp;&nbsp;
      <input class="txtFieldShortBlack" type="text" name="motor" value="<?php echo $motor; ?>" autoComplete="off"> <br>
      <label for="id_number">Cikkszám:</label>&nbsp;&nbsp;
      <input class="txtFieldShortBlack" type="text" name="id_number" value="<?php echo $id_number; ?>" autoComplete="off"> <br>
      <button type="submit" name='update' class="save_button">
          <img src="../images/save.png" class='save' alt="Save">
      </button>  
    </form>
  </div>
  <?php
    if (isset($_POST['update'])) {
      $new_amount = (int)$amount + (int)$_POST['amount'];
      $new_price = $_POST['price'];
      $new_type = $_POST['type'];
      $new_motor = $_POST['motor'];
      $new_id_number = $_POST['id_number'];

      $sql_update1 = "UPDATE `storage` SET `amount`='$new_amount' WHERE `id`='$id'";
      $result1 = $conection->query($sql_update1);

      $sql_update2 = "UPDATE `storage` SET `price`='$new_price' WHERE `id`='$id'";
      $result2 = $conection->query($sql_update2);

      $sql_update3 = "UPDATE `storage` SET `type`='$new_type' WHERE `id`='$id'";
      $result3 = $conection->query($sql_update3);

      $sql_update4 = "UPDATE `storage` SET `motor`='$new_motor' WHERE `id`='$id'";
      $result4 = $conection->query($sql_update4);

      $sql_update5 = "UPDATE `storage` SET `id_number`='$new_id_number' WHERE `id`='$id'";
      $result5 = $conection->query($sql_update5);

      if ($result1 = 1 && $result2 = 1 && $result3 = 1 && $result4 = 1 && $result5 = 1) {
        $conection->close();
        header('Location: storage.php');
      }
    }
    $conection->close();
  ?>
</body>
</html>