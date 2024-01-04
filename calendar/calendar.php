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
    <title>Naptár</title>
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
            <li><h2><a href = "../job/job.php">Munkák</a></h2></li>
        </ul>
    </div>
    <form method="post" action="calendar_insert_item.php">
        <table class="calendar">
            <tr>
                <th>Rendszám</th>
                <th>Dátum</th>
                <th>Időpont</th>
                <th>Látogatás oka</th>
            </tr>
            <tr>
                <td>
                <input class="txtFieldShort" type="text" name="plate_number" id="plate_number" value="" autoComplete="off">
                </td>
                
                <td>
                    <input class="txtDate" name="date" id="date" type="date" value="<?= date('Y-m-d') ?>">
                </td>

                <td>
                    <input class="txtTime" name="time" id="time" type="time" value="00:00">
                </td>
                
                <td>
                    <input class="txtFieldLong" type="text" name="work" id="work" autoComplete="off">
                </td>

                <td>
                    <button type="submit">
                        <img class='add' src="../images/add_f.png" alt="Add">
                    </button>
                </td>
            </tr>
        </table>
    </form>

    <div class="row">
        <div class="column_1">
            <h2 class = "calendarTitle"><?= date('Y. m. d') ?></h2>
            <div class="label">
                <img src="../images/seperator_20.png" alt="Car" class='seperator'>
            </div>
            <ul>
                <?php
                    $sql_select = "SELECT * FROM `calendar` WHERE `date` = date(now())";
                    $result = $conection->query($sql_select);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){ ?>
                            <li>
                                <?php echo $row['car']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php $time = new DateTimeImmutable($row['time']); echo $time ->format("H:i"); ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row['work']; ?>
                            </li>
                            
                        <?php }
                        $result->free();
                    }
                ?>
            </ul>
        </div>
        <div class="column_2">
            <h2 class = "calendarTitle">Naptár</h2>
        </div>
    </div>
    

</body>
</html>