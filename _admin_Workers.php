<?PHP
//ini_set('memory_limit','128M');
//var_dump($_POST);
///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['action'])){

    //do actions update
    if ($_POST['action']== 'update'){
        $uid = $_POST['uid'];
        $naam = $_POST['Naam'];
        $van = $_POST['Van'];
        $CN = $_POST['CN'];
        $img = $_POST['img_data'];
        $Area = $_POST['Area'];
        $skof = $_POST['Skof'];
        $KDatum = $_POST['KDatum'];
        $sql = "update workers set naam='$naam',van='$van',CN='$CN',img_data='$img',skof='$skof',area='$Area',contract_end='$KDatum' where id = '$uid'";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Workers.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $naam = $_POST['Naam'];
        $van = $_POST['Van'];
        $CN = $_POST['CN'];
        $img = $_POST['img_data'];
        $Area = $_POST['Area'];
        $skof = $_POST['Skof'];
        $KDatum = $_POST['KDatum'];
        $sql = "insert into workers (naam,van,CN,img_data,area,skof,contract_end) values('$naam','$van','$CN','$img','$Area','$skof','$KDatum');";

        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Workers.php?notice=add"); </script>';
    }
}

//do actions delete
if (isset($_GET['delete'])){
    //delete farm with uid
    $uid = $_GET['delete'];

    $sql = "delete from workers where id = '$uid'";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo '<script>  window.location.replace("admin_Workers.php?notice=delete"); </script>';
}
?>

<script src="JS/workerAction.js">
///////////////////////////////////////////////////////////////////////////////////
//   Do onchange Actions
///////////////////////////////////////////////////////////////////////////////////
</script>


<div class="container">
    <?php

    if (isset($_GET['notice'])){
        
        //if delete
        if ($_GET['notice']=='delete'){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Werker Verwyder !
            </div>';
        }

        //if update
        if ($_GET['notice']=='update'){
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Werker Opgedateer !
            </div>';
        }

        //if add
        if ($_GET['notice']=='add'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Werker Bygevoeg !
            </div>';
        }
    }

    //if no add or update show form
    if ((!isset($_GET['add']))&&(!isset($_GET['name']))){
        $sql = "select id,naam,van from workers order by naam;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQueryEmulate($sql, $sqlargs);
    ?>
    <div class="form-group">
        <label for="worker">Werker:</label>
        <select class="form-control" id="worker" onchange="updateAction()">
            <option value="">Kies Werker</option>
            <option value="addWorker">+Nuwe Werker</option>
            <?php
                foreach ($result[0] as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] .' '. $row['van'] .'</option>';
                }
            ?>
        </select>
        <br>
        <br>
        <a class="btn btn-info" target="_blank" href="print.php?ALL">QR KODE VIR ALMAL</a>
        <a class="btn btn-info" target="_blank" href="admin_PrintSelect.php">QR KODE VIR SELEKSIE</a>
    </div>
    <?php
    }
    ?>

    <?php
    //if add new
    if (isset($_GET['add'])){
    ?>

    <video id="player" width=320 height=240 autoplay></video>
    <br>
    <button class="btn btn-primary" id="capture">Stoor Foto</button>
    <button class="btn btn-secondary" id="flip">↻</button>
    <canvas id="canvas" style="display: none;"></canvas>
    <script>
    const player = document.getElementById('player');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const captureButton = document.getElementById('capture');

    const constraints = {
        video: {
            facingMode: {
                exact: "environment"
            }
        }
    };
    const JustVConstraints = {
        video: true,
    };

    captureButton.addEventListener('click', () => {
        context.drawImage(player, 0, 0, canvas.width, canvas.height);
        const dataURL = canvas.toDataURL();
        document.getElementById('img_pic').src = dataURL;
        document.getElementById('img_data').value = dataURL;
    });

    navigator.mediaDevices.getUserMedia(JustVConstraints)
        .then((stream) => {
            player.srcObject = stream;
        });

    navigator.mediaDevices.getUserMedia(constraints)
        .then((stream) => {
            // Attach the video stream to the video element and autoplay.
            player.srcObject = stream;
        });
    </script>

    <form method="POST" id="frmAdd" enctype="multipart/form-data">
        <div class="form-group">
            <label for="farmName">Naam:</label>
            <input type="text" class="form-control" value="" name="Naam" id="farmName" placeholder="Naam">
            <label for="van">Van:</label>
            <input type="text" class="form-control" value="" name="Van" id="van" placeholder="Van">

            <label for="Area">Woon Area:</label>
            <input type="text" class="form-control" value="" name="Area" id="Area" placeholder="Woon Area">
            <label for="Skof">Werker Skof:</label>
            <select class="form-control" name="Skof" id="Skof">
                <option value="">Kies Skof</option>
                <option value="Dag">Dag</option>
                <option value="Nag">Nag</option>
            </select>

            <label for="KDatum">Kontrak Datum:</label>
            <input type="date" class="form-control" value="<?php echo $KDatum; ?>" name="KDatum" id="KDatum">
            <script>
            document.getElementById('KDatum').valueAsDate = new Date();
            </script>

            <label for="CN">Werker Nommer:</label>
            <input type="text" class="form-control" value="" name="CN" id="CN" placeholder="Werker Nommer" required>
            <input type="hidden" name="action" value="add">
        </div>
        <label for="img_data">Werker foto:</label>
        <div class="bg-white p-1 border rounded">
            <img width="320px" height="240px" id="img_pic" src="Img/favicon.png" />
            <input type="hidden" name="img_data" id="img_data" value="Img/favicon.png" />
        </div>
        <button type="button" class="btn btn-success" onclick="frmAdd.submit()">Voeg By</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Workers.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>

    <?php
    //update current
    if (isset($_GET['name'])){
        $uid = $_GET['name'];
        $sql = "select * from workers where id = '$uid' limit 1;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQueryEmulate($sql, $sqlargs);
        $img_data = 'Img/favicon.png';
        foreach ($result[0] as $row) {
            $naam = $row['naam'];
            $van = $row['van'];
            $CN = $row['CN'];
            $img_data = $row['img_data'];
            $Area = $row['area'];
            $skof = $row['skof'];
            $KDatum = $row['contract_end'];
        }
    ?>

    <video id="player" width=320 height=240 autoplay></video>
    <br>
    <button class="btn btn-primary" id="capture">Stoor Foto</button>
    <button class="btn btn-info" id="flip">↻</button>
    <canvas id="canvas" style="display: none;"></canvas>

    <script>
    const player = document.getElementById('player');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const captureButton = document.getElementById('capture');
    const flipButton = document.getElementById('flip');

    const constraints = {
        video: {
            facingMode: {
                exact: "environment"
            }
        }
    };
    const JustVConstraints = {
        video: true,
    };

    let face = 0;
    let stream1;
    let stream2;

    captureButton.addEventListener('click', () => {
        context.drawImage(player, 0, 0, canvas.width, canvas.height);
        const dataURL = canvas.toDataURL();
        document.getElementById('img_pic').src = dataURL;
        document.getElementById('img_data').value = dataURL;
    });

    flipButton.addEventListener('click', () => {
        if (face === 0) {
            face = 1;
            player.srcObject = null;
            navigator.mediaDevices.getUserMedia(JustVConstraints)
                .then((stream) => {
                    player.srcObject = stream;
                }).catch(function(err) {});
        } else {
            face = 0;
            player.srcObject = null;
            navigator.mediaDevices.getUserMedia(constraints)
                .then((stream) => {
                    // Attach the video stream to the video element and autoplay.
                    player.srcObject = stream;
                }).catch(function(err) {});
        }
    });

    navigator.mediaDevices.getUserMedia(constraints)
        .then((stream) => {
            player.srcObject = stream;
        }).catch(function(err) {});
    </script>
    <form method="POST" id="frmUpdate" enctype="multipart/form-data">
        <div class="form-group">
            <label for="farmName">Naam:</label>
            <input type="text" class="form-control" value="<?php echo $naam; ?>" name="Naam" id="farmName"
                placeholder="Naam">
            <label for="van">Van:</label>
            <input type="text" class="form-control" value="<?php echo $van; ?>" name="Van" id="van" placeholder="Van">

            <label for="Area">Woon Area:</label>
            <input type="text" class="form-control" value="<?php echo $Area; ?>" name="Area" id="Area"
                placeholder="Woon Area">
            <label for="Skof">Werker Skof:</label>
            <select class="form-control" name="Skof" id="Skof">
                <option value="<?php echo $skof; ?>"><?php echo $skof; ?></option>
                <option value="Dag">Dag</option>
                <option value="Nag">Nag</option>
            </select>

            <label for="KDatum">Kontrak Datum:</label>
            <input type="date" class="form-control" value="<?php echo $KDatum; ?>" name="KDatum" id="KDatum">

            <label for="CN">Werker Nommer:</label>
            <input type="test" class="form-control" value="<?php echo $CN; ?>" name="CN" id="CN"
                placeholder="Werker Nommer" required>
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">
            <input type="hidden" name="action" value="update">
            <label for="img_data">Werker foto:</label>
            <div class="bg-white p-1 border rounded">
                <img width="320px" height="240px" id="img_pic" src="<?php echo $img_data; ?>" />
                <input type="hidden" name="img_data" id="img_data" value="<?php echo $img_data; ?>" />
            </div>
        </div>

        <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
        <button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Workers.php'">Kanselleer</button>
        <a class="btn btn-info" target="_blank" href="print.php?CN=<?php echo $CN ;?>">QR KODE</a>
    </form>
    <?php
    }
    ?>


</div>