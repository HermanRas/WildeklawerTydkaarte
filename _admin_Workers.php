<?PHP
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
        $sql = "select * from workers order by naam;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
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
    </div>
    <?php
    }
    ?>

    <?php
    //if add new
    if (isset($_GET['add'])){
    ?>
    <form method="POST" id="frmAdd">

        <div id="my_camera"></div>
        <input class="btn btn-primary" type="button" value="Stoor Foto" onClick="take_snapshot()">
        <!-- Webcam.min.js -->
        <script type="text/javascript" src="JS/webcam.min.js"></script>
        <!-- Configure a few settings and attach camera -->
        <script language="JavaScript">
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90,
            deviceId: {
                exact: [e2fc402b621403eab5ca4b92cf42b71b113c8c4e272c66fe4451d2ae444e6c91]
            }
        });
        Webcam.attach('#my_camera');
        // Code to handle taking the snapshot and displaying it locally
        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap(function(data_uri) {
                // display results in page
                document.getElementById('img_pic').src = data_uri;
                document.getElementById('img_data').value = data_uri;
            });
        }
        </script>

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
            <input type="text" class="form-control" value="" name="CN" id="CN" placeholder="Werker Nommer">
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
        $result = sqlQuery($sql, $sqlargs);
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
    <form method="POST" id="frmUpdate">

        <div id="my_camera"></div>
        <input class="btn btn-primary" type="button" value="Stoor Foto" onClick="take_snapshot()">
        <!-- Webcam.min.js -->
        <script type="text/javascript" src="JS/webcam.min.js"></script>
        <!-- Configure a few settings and attach camera -->
        <script language="JavaScript">
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
        // Code to handle taking the snapshot and displaying it locally
        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap(function(data_uri) {
                // display results in page
                document.getElementById('img_pic').src = data_uri;
                document.getElementById('img_data').value = data_uri;
            });
        }
        </script>

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
                placeholder="Werker Nommer">
            <input type="hidden" name="action" value="add">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">
            <input type="hidden" name="action" value="update">
            <label for="img_data">Werker foto:</label>
            <div class="bg-white p-1 border rounded">
                <img width="320px" height="240px" id="img_pic" src="<?php echo $img_data; ?>" />
                <input type="hidden" name="img_data" id="img_data" value="<?php echo $img_data; ?>" />
            </div>
        </div>
</div>
<button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
<button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>
<button type="button" class="btn btn-warning" onclick="window.location.href='admin_Workers.php'">Kanselleer</button>
<a class="btn btn-info" target="_blank" href="print.php?CN=<?php echo $CN ;?>">QR KODE</a>
</form>
<?php
    }
    ?>


</div>