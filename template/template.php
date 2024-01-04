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
    <title>Sablonok</title>
</head>
<body>
    <a href="https://revicar.hu/" class="thickener">
        <img src="../images/revicar_logo.png" class='revicarLogo' alt="Revicar">
    </a>
    <div class="menu">
        <ul>
            <li><h2><a href = "../storage/storage.php">Raktár</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../status/status.php">Státuszok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../price_offer/price_offer.php">Árajánlat</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../job/job.php">Munkák</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../calendar/calendar.php">Naptár</a></h2></li>
        </ul>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Sablonok</button>
        <div class="dropdown-content">
            <?php
                $sql_select = "SELECT * FROM `all_template`";
                $result = $conection->query($sql_select);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){ ?>
                        <p><?php echo $row['name']; ?></p>
                    <?php }
                    $result->free();
                }
            ?>
        </div>
    </div>
    <form method="post" class="finder_middle" action="insert_template_name.php">
        <?php 
            $sql_select = "SELECT * FROM `template` WHERE 1;";
            $result = $conection->query($sql_select);

            $row = $result->fetch_assoc();
            $template = $row['name'];
        ?>
        <div>
            <h3>Sablon:&nbsp;&nbsp;
                <input class="txtFieldLong" type="text" name="template" id="template" value="<?php echo $template; ?>" autoComplete="off"></input>
                <button type="submit">
                    <img class='search' src="../images/search_f.png" alt="Search">
                </button>
            </h3>
        </div>
    </form>
    <form method="post" action="template_insert_item.php">
        <table class="templateCreater">
            <tr>
                <th>Alkatrész</th>
                <th>Mennyiség</th>
                <th>Állapot</th>
                <th>Munka</th>
                <th>Munkadíj</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <select class="txtField" id="selectedName" name='selectedName' action="<?php echo $PHP_SELF; ?>"> 
                        <option selected disabled hidden>-------- Válassz --------</option>";
                        <?php
                            $sql_select = "SELECT * FROM `storage`";
                            $result = $conection->query($sql_select);

                            $select = '';
                            if (isset ($select)){  
                                $select=$_POST ['selectedName'];  
                            }  
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$select){ echo "selected"; $description = $row['name']; } ?>>
                                        <?php echo ($row['name'] . "/" . $row['type'] . "/" . $row['motor']); ?>
                                    </option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </td>
                <td>
                    <input class="numberField" autoComplete="off" name="amount" id="amount" type="number" value="1">
                </td>
                
                <td>
                    <select class="txtField" id="partStatus" name='partStatus' action="<?php echo $PHP_SELF; ?>"> 
                        <option selected disabled hidden>-------- Válassz --------</option>";
                        <?php
                            $sql_select = "SELECT `id`, `name` FROM `status`";
                            $result = $conection->query($sql_select);
                            $select = '';
                            if (isset ($select)){  
                                $select=$_POST ['selectedStatus'];  
                            }  
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $select) {
                                    echo "selected";
                                    $partStatus = $row['name']; } ?>>
                                        <?php echo $row['name']; ?>
                                    </option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </td>
                <td>
                    <select class="txtField" id="todo" name='todo' action="<?php echo $PHP_SELF; ?>"> 
                        <option selected disabled hidden>Csere</option>";
                        <?php
                            $sql_select = "SELECT * FROM `job`";
                            $result = $conection->query($sql_select);

                            $select = '';
                            if (isset ($select)){  
                                $select=$_POST ['name'];  
                            }  
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$select){ echo "selected"; $description = $row['name']; } ?>>
                                        <?php echo $row['name']; ?>
                                    </option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </td>
                <td class="white">
                    <input class="numberField" autoComplete="off" name="laborFee" id="laborFee" type="number" value="0"> Ft
                </td>
                <td>
                    <button type="submit">
                        <img class='add' src="../images/add_f.png" alt="Add">
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <div class="label">
        <img src="../images/seperator_20.png" alt="Car" class='seperator'>
    </div>
    <table class="selectedTable">
        <?php
            $sql_select = "SELECT * FROM `template_info` WHERE `template` = '$template'";
            $result = $conection->query($sql_select);

            if($result->num_rows > 0){
                echo "<tr><th>Alkatrész</th><th>Egységár</th><th>Mennyiség</th><th>Állapot</th><th>Munka</th><th>Munkadíj</th><th>Összeg</th><th>Szerkesztés</th><th>Törlés</th></tr>";
                while($row = $result->fetch_assoc()){ ?>
                    <tr class="hoveredTr">
                        <td><?php echo $row['name']; ?></td>
                        <td><?php $p=$row['price']; echo number_format("$p",0,"."," "); ?> Ft</td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td width="250px"><?php echo $row['todo']; ?></td>
                        <td><?php $l=$row['labor_fee']; echo number_format("$l",0,"."," ");?> Ft</td>
                        <td><?php $t=(($row['price'] * $row['amount']) + $row['labor_fee']); echo number_format("$t",0,"."," ");?> Ft</td>
                        <td><a href="template_edit_item.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>&price=<?php echo $row['price']; ?>&amount=<?php echo $row['amount']; ?>&status=<?php echo $row['status']; ?>&todo=<?php echo $row['todo']; ?>&labor_fee=<?php echo $row['labor_fee']; ?>"><img class='edit' src="../images/edit.png" alt="Edit"></a></td>
                        <td><a href="template_delete_item.php?id=<?php echo $row['id']; ?>"><img class='delete' src="../images/delete.png" alt="Delete"></a></td>
                    </tr>
                <?php }
                $result->free();
            }
        ?>
    </table>
</body>
</html>