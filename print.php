<?php
if (isset($_GET['ALL'])){
        $sql = "SELECT * from Workers";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
}

if (isset($_GET['CN'])){
    $CN = $_GET['CN'];
    $sql = "SELECT * from Workers
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
    <script type="module">
    import QrCode from './js/qr-code.min.js';

    function readSettings() {
        let settings = {};
        settings.radius = '0';
        settings.ecLevel = 'H';
        settings.fill = '#000000';
        settings.background = null;
        settings.size = 250;
        settings.text = document.getElementById('QrID').innerText;
        return settings;
    }

    function renderQrCode() {
        let time = new Date(),
            container = document.querySelector('#qr-code'),
            settings = readSettings();
        container.innerHTML = '';
        QrCode.render(settings, container);
    }
    for (let input of document.querySelectorAll('input, select')) {
        input.addEventListener('change', renderQrCode);
    }
    renderQrCode();
    </script>

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
                <div class="img-box-qr">
                    <img src="Img/qr-temp.png">
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