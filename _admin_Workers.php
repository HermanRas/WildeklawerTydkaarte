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

        
        $sql = "update workers set naam='$naam',van='$van',CN='$CN' where id = '$uid'";
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

        $sql = "insert into workers (naam,van,CN) values('$naam','$van','$CN');";
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

<script src="js/workerAction.js">
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
        $sql = "select * from workers limit 0,1000";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
    ?>
    <div class="form-group">
        <label for="worker">Werker:</label>
        <select class="form-control" id="worker" onchange="updateAction()">
            <option value="">Kies Werker</option>
            <?php
                foreach ($result[0] as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] .' '. $row['van'] .'</option>';
                }
            ?>
            <option value="addWorker">+Nuwe Werker</option>
        </select>
    </div>
    <?php
    }
    ?>

    <?php
    //if add new
    if (isset($_GET['add'])){
    ?>
    <form method="POST" id="frmAdd">
        <div class="form-group">
            <label for="farmName">Naam:</label>
            <input type="text" class="form-control" value="" name="Naam" id="farmName" placeholder="Naam">
            <label for="van">Van:</label>
            <input type="text" class="form-control" value="" name="Van" id="van" placeholder="Van">
            <label for="CN">Werker Nommer:</label>
            <input type="number" class="form-control" value="" name="CN" id="CN" placeholder="Werker Nommer">
            <input type="hidden" name="action" value="add">
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
        foreach ($result[0] as $row) {
            $naam = $row['naam'];
            $van = $row['van'];
            $CN = $row['CN'];
        }
    ?>
    <form method="POST" id="frmUpdate">
        <div class="form-group">
            <label for="farmName">Naam:</label>
            <input type="text" class="form-control" value="<?php echo $naam; ?>" name="Naam" id="farmName"
                placeholder="Naam">
            <label for="van">Van:</label>
            <input type="text" class="form-control" value="<?php echo $van; ?>" name="Van" id="van" placeholder="Van">
            <label for="CN">Werker Nommer:</label>
            <input type="number" class="form-control" value="<?php echo $CN; ?>" name="CN" id="CN"
                placeholder="Werker Nommer">
            <input type="hidden" name="action" value="add">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">
            <input type="hidden" name="action" value="update">
        </div>
        <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
        <button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Workers.php'">Kanselleer</button>
        <a class="btn btn-info" href="user_InputSelect.html?qr=<?php echo $CN ;?>">QR KODE</a>
    </form>
    <?php
    }
    ?>


</div>