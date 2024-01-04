<?php
    $conection = mysqli_connect('localhost', 'root', '','revicar');

    if ($conection->connect_error) {
        die("Connection failed: " . $conection->connect_error);
    }
    $sql_select = "SELECT * FROM `plate` WHERE 1;";
    $result = $conection->query($sql_select);
    $row = $result->fetch_assoc();
    $plate_number = $row['plate_number'];
    $type = $row['type'];
    $motor = $row['motor'];
    $date = date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../base.css">
    <link rel="stylesheet" media="print" href="../print.css" />
    <title>Árajánlat</title>
</head>
<body>
    <div class="watermark">
        <img src="../images/watermark.png" alt="...">
    </div>
    <a href="https://revicar.hu/" class="thickener">
        <img src="../images/revicar_logo.png" class='revicarLogo' alt="Revicar">
        <div class="plate_number"><?php echo $plate_number; ?></div>
        <div class="page_code">Kelt: <?php echo date("Y.m.d"); ?></div>
    </a>
    <div class="menu">
        <ul>
            <li><h2><a href = "../storage/storage.php">Raktár</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../status/status.php">Státuszok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../template/template.php">Sablonok</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../job/job.php">Munkák</a></h2></li>
            <li class='horizontalLine'>|</li>
            <li><h2><a href = "../calendar/calendar.php">Naptár</a></h2></li>
        </ul>
    </div>
    
    <form method="post" class="finder" action="insert_plate_number.php">
        <div>
            <h3>Rendszám:&nbsp;&nbsp;
                <input class="txtFieldShort" type="text" name="plate_number" id="plate_number" value="<?php echo $plate_number; ?>" autoComplete="off"></input>
                Típus:&nbsp;&nbsp;
                <input class="txtFieldShort" type="text" name="type" id="type" value="<?php echo $type; ?>" autoComplete="off"></input>
                Motor:&nbsp;&nbsp;
                <input class="txtFieldShort" type="text" name="motor" id="motor" value="<?php echo $motor; ?>" autoComplete="off"></input>
                <button type="submit">
                    <img class='search' src="../images/search_f.png" alt="Search">
                </button>
            </h3>
        </div>
    </form>
    <form method="post" class="templates" action="insert_template_to_price_offer.php">
        <h3>Sablon:&nbsp;&nbsp;
            <select class="txtField" id="template" name='template' action="<?php echo $PHP_SELF; ?>"> 
                <option selected disabled hidden>-------- Válassz --------</option>";
                <?php
                    $sql_select = "SELECT * FROM `all_template`";
                    $result = $conection->query($sql_select);

                    $select = '';
                    if (isset ($select)){  
                        $select=$_POST ['template'];  
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
            <button type="submit">
                <img class='add' src="../images/add_f.png" alt="Add">
            </button>
        </h3>
    </form>
    <form method="post" action="price_offer_insert_item.php">
        <table class="priceOffer">
            <tr>
                <th>Alkatrész</th>
                <th>Mennyiség</th>
                <th>Állapot</th>
                <th>Munka</th>
                <th>Munkadíj</th>
            </tr>
            <tr>
                <td>
                    <select class="txtField" id="selectedName" name='selectedName' action="<?php echo $PHP_SELF; ?>"> 
                        <option selected disabled hidden>-------- Válassz --------</option>";
                        <?php
                            $where = "";

                            if(strlen($type) > 0 && strlen($motor) == 0){
                                $where = "WHERE `type` IN ('$type', '')";
                            }else if(strlen($motor) > 0 && strlen($type) == 0){
                                $where = "WHERE `motor` IN ('$motor', '')";
                            }else if(strlen($type) > 0 && strlen($motor) > 0){
                                $where = "WHERE `type` IN ('$type', '') AND `motor` IN ('$motor', '')";
                            }else{
                                $where = "";
                            }
                            $sql_select = "SELECT * FROM `storage`". $where;
                            $result = $conection->query($sql_select);

                            $select = '';
                            if (isset ($select)){  
                                $select=$_POST ['selectedName'];  
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
                                $select=$_POST ['partStatus'];  
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
            $sql_select = "SELECT * FROM `price_offer` WHERE `plate_number` = '$plate_number'";
            $result = $conection->query($sql_select);

            if($result->num_rows > 0){
                echo "<tr><th class='p_red'>Alkatrész</th><th class='p_red'>Egységár</th><th class='p_blue'>Mennyiség</th><th class='p_blue'>Alkatrész ár</th><th class='p_blue'>Állapot</th><th class='p_blue'>Munka</th><th class='p_blue'>Munkadíj</th><th class='p_blue'>Összeg</th><th class='disabled'>Szerkesztés</th><th class='disabled'>Törlés</th></tr>";
                while($row = $result->fetch_assoc()){ ?>
                    <tr class="hoveredTr">
                        <td><?php echo $row['name']; ?></td>
                        <td><?php $p=$row['price']; echo number_format("$p",0,"."," "); ?> Ft</td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php $s=($row['price'] * $row['amount']); echo number_format("$s",0,"."," ");?> Ft</td>
                        <td><?php echo $row['status']; ?></td>
                        <td width="250px"><?php echo $row['todo']; ?></td>
                        <td><?php $l=$row['labor_fee']; echo number_format("$l",0,"."," ");?> Ft</td>
                        <td><?php $t=(($row['price'] * $row['amount']) + $row['labor_fee']); echo number_format("$t",0,"."," ");?> Ft</td>
                        <td class="disabled"><a href="price_offer_edit_item.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>&price=<?php echo $row['price']; ?>&amount=<?php echo $row['amount']; ?>&status=<?php echo $row['status']; ?>&todo=<?php echo $row['todo']; ?>&labor_fee=<?php echo $row['labor_fee']; ?>"><img class='edit' src="../images/edit.png" alt="Edit"></a></td>
                        <td class="disabled"><a href="price_offer_delete_item.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>&amount=<?php echo $row['amount']; ?>"><img class='delete' src="../images/delete.png" alt="Delete"></a></td>
                    </tr>
                <?php }
                $result->free();
            }
        ?>
    </table>
    <div class="label_print">
        <img src="../images/seperator_20.png" alt="Car" class='seperator'>
    </div>
    <div class="newItem">
        <form method="post" action="price_offer_calculate.php">
            <label for="discount" class="thick">Kedvezmény: </label>
            <input class="numberField" type="number" name="discount" id="discount" autoComplete="off"> %
            &nbsp; &nbsp;
            <label for="deposit" class="thick">Előleg: </label>
            <input class="numberField" type="number" name="deposit" id="deposit" autoComplete="off"> Ft
            &nbsp; &nbsp;
            <button type="submit">
                <img class='calculate' src="../images/calculate_f.png" alt="Calculate">
            </button>
        </form>
    </div>
    <div class="print_label2">Összegezve</div>
    <table class="sumTable">
        <?php
            $sql_select = "SELECT * FROM `calculated` WHERE `plate_number` = '$plate_number'";
            $result = $conection->query($sql_select);

            if($result->num_rows > 0){
                echo "<tr><th class='p_red'>Alkatrész összeg</th><th class='p_red'>Munkadíj összeg</th><th class='p_blue'>Összeg</th><th class='p_blue'>Kedv.</th><th class='p_blue'>Kedv. alkatrész ár</th><th class='p_blue'>Fizetendő</th><th class='p_blue'>Előleg</th><th class='p_blue'>Hátralévő összeg</th><th class='disabled'>Megtakarítás</th></tr>";
                while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php $t1=$row['sum_parts']; echo number_format("$t1",0,"."," ");?> Ft</td>
                        <td><?php $t2=$row['sum_job']; echo number_format("$t2",0,"."," ");?> Ft</td>
                        <td><?php $t3=$row['sum_all']; echo number_format("$t3",0,"."," ");?> Ft</td>
                        <td><?php echo $row['discount']; ?> %</td>
                        <td><?php $t4=$row['discount_sum']; echo number_format("$t4",0,"."," ");?> Ft</td>
                        <td><?php $t5=$row['owing']; echo number_format("$t5",0,"."," ");?> Ft</td>
                        <td><?php $t6=$row['deposit']; echo number_format("$t6",0,"."," ");?> Ft</td>
                        <td><?php $t7=$row['remainer']; echo number_format("$t7",0,"."," ");?> Ft</td>
                        <td class="disabled"><?php $t8=$row['savings']; echo number_format("$t8",0,"."," ");?> Ft</td>
                    </tr>
                <?php }
                $result->free();
            }
        ?>
    </table>
</body>
</html>