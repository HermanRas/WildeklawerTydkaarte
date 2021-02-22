<?php
if (isset($_GET['ALL'])){
        $sql = "SELECT * from workers";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
}

if (isset($_GET['CN'])){
    $CN = $_GET['CN'];
    $sql = "SELECT * from workers
            WHERE CN = $CN;";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Company</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/print.css">
</head>

<body>


    <!-- Load QR Code rendering Module -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.js"></script>
    <script src="js/jquery-qrcode-0.18.0.min.js"></script>
    <!-- <script src="JS/jquery.qrcode.js"></script> -->
    <!-- <script src="JS/qrcode.js"></script> -->
    <?php 
    if (isset($result)){
        $i = 0;
        $firstrun = true;
        foreach ($result[0] as $row) {

            if ($firstrun) {
    ?>

    <!--############################## START ############################-->
    <div class="page centre">
        <div class="row justify-content-md-center">

            <?php } ?>

            <div class="col bCard">
                <div class="img-box-pic">
                    <img src="<?php echo $row['img_data']?>">
                </div>
                <br>
                <b>Naam:</b><?php echo $row['naam'] . " ".$row['van'];?><br>
                <b>WK:</b><?php echo $row['CN']?><br>
                <b>Skof:</b><?php echo $row['skof']?><br>
                <br>
                <div class="img-box-qr" id="<?php echo $row['CN']?>">
                    <?php //echo "<script>jQuery  ('#".$row['CN']."').qrcode({mode: 3,image: '../Img/admin.png',text:'". $row['CN'] ." : ".$row['naam'] . " ".$row['van']."'});</script>"; ?>
                    <?php echo "<script>jQuery  ('#".$row['CN']."').qrcode({label: 'WK',fontname: 'arial',fontcolor: '#00AB93',mode: 0,text:'". $row['CN'] ." : ".$row['naam'] . " ".$row['van']."'});</script>"; ?>
                </div>
            </div>
            <?php
                if ( is_int(($i+1)/10) ){
            ?>
        </div>
    </div>
    <div class="page-break"></div>
    <!--############################## END ############################-->

    <?php
            }
            $i++;
            $firstrun = false;
            if ( is_int(($i)/10) ){
                $firstrun = true;
            }
        }
    }
    ?>
</body>

</html>