<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../base.css">
    <title>Raktár</title>
</head>
<body>
    <a href="https://revicar.hu/" class="thickener">
        <img src="../images/revicar_logo.png" class='revicarLogo' alt="Revicar">
    </a>
    <div class="menu">
        <ul>
            <li><h2><a href = "../price_offer/price_offer.php">Árajánlat</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../status/status.php">Státuszok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../template/template.php">Sablonok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../job/job.php">Munkák</a></h2></li>
        </ul>
    </div>
    
    <div class="newItem">
        <form name="newItem" method="post" action="storage_insert_item.php">
            <label for="txtName" class="thick">Megnevezés: </label>
            <input class="txtFieldShort" type="text" name="txtName" id="txtName" autoComplete="off">
            &nbsp; &nbsp;
            <label for="type" class="thick">Típus: </label>
            <input class="txtFieldShort" type="text" name="type" id="type" autoComplete="off">
            &nbsp; &nbsp;
            <label for="motor" class="thick">Motor: </label>
            <input class="txtFieldShort" type="text" name="motor" id="motor" autoComplete="off">
            &nbsp; &nbsp;
            <label for="idNumber" class="thick">Cikkszám: </label>
            <input class="txtFieldShort" type="text" name="idNumber" id="idNumber" autoComplete="off">
            &nbsp; &nbsp;
            <label for="numbAmount" class="thick">Mennyiség: </label>
            <input class="numberField" type="number" name="numbAmount" id="numbAmount" autoComplete="off">
            &nbsp; &nbsp;
            <label for="numbPrice" class="thick">Egységár: </label>
            <input class="numberField" type="number" name="numbPrice" id="numbPrice" autoComplete="off"> Ft
            &nbsp; &nbsp;
            <button type="submit" >
                <img src="../images/add_f.png" class='add' alt="Add">
            </button>
        </form>
    </div>
    <div class="label">
        <img src="../images/seperator_20.png" alt="Car" class='seperator'>
    </div>
    <table class="selectedTable">
        <?php
            $sql_select = "SELECT * FROM `storage`";

            $result = $conection->query($sql_select);
            if($result->num_rows > 0){
                echo "<tr><th>Megnevezés</th><th>Típus</th><th>Motor</th><th>Cikkszám</th><th>Mennyiség</th><th>Egységár</th><th>Szerkesztés</th><th>Törlés</th></tr>";
                while($row = $result->fetch_assoc()){ ?>
                    <tr class="hoveredTr">
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['motor']; ?></td>
                        <td><?php echo $row['id_number']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php $t=$row['price']; echo number_format("$t",0,"."," ");?></td>
                        <td><a href="storage_edit_item.php?name=<?php echo $row['name']; ?>&type=<?php echo $row['type']; ?>&motor=<?php echo $row['motor']; ?>&id_number=<?php echo $row['id_number']; ?>&amount=<?php echo $row['amount']; ?>&price=<?php echo $row['price']; ?>&id=<?php echo $row['id']; ?>"><img src="../images/edit.png" class='edit' alt="Edit"></a></td>  
                        <td><a href="storage_delete_item.php?id=<?php echo $row['id']; ?>"><img src="../images/delete.png" class='delete' alt="Delete"></a></td>
                    </tr>
                <?php }
                $result->free();
            }
        ?>
    </table>
</body>
</html>