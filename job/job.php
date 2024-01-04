<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../base.css">
    <title>Munkák</title>
</head>
<body>
    <a href="https://revicar.hu/" class="thickener">
        <img src="../images/revicar_logo.png" class='revicarLogo' alt="Revicar">
    </a>
    <div class="menu">
        <ul>
            <li><h2><a href = "../storage/storage.php">Raktár</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../price_offer/price_offer.php">Árajánlat</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../template/template.php">Sablonok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../status/status.php">Státuszok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../calendar/calendar.php">Naptár</a></h2></li>
        </ul>
    </div>

    <div class="newItem">
        <form method="post" action="job_insert_item.php">
            <label for="Name" class="thick">Megnevezés: </label>
            <input class="txtFieldLong" type="text" name="txtName" id="txtName" autoComplete="off">
            <button type="submit">
                <img class='add' src="../images/add_f.png" alt="Add">
            </button>
        </form>
    </div>
    <table class="selectedTable">
        <?php
            $sql_select = "SELECT `id`, `name` FROM `job`";

            $result = $conection->query($sql_select);
            if($result->num_rows > 0){
                echo "<tr><th>Megnevezés</th><th>Törlés</th></tr>";
                while($row = $result->fetch_assoc()){ ?>
                    <tr class="hoveredTr">
                        <td><?php echo $row['name']; ?></td>
                        <td><a href="job_delete_item.php?name=<?php echo $row['name']; ?>&id=<?php echo $row['id']; ?>"><img class='delete' src="../images/delete.png" alt="Delete"></a></td>
                    </tr>
                <?php }
                $result->free();
            }
        ?>
    </table>
</body>
</html>