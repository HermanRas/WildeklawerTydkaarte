<?PHP
///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['action'])){

    //do actions update
    if ($_POST['action']== 'update'){
        $uid = $_POST['uid'];
        $naam = $_POST['farmName'];
        $afk = $_POST['farmAfk'];

        
        $sql = "update plaas set naam='$naam',afkorting='$afk' where id = '$uid'";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Farm.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $naam = $_POST['farmName'];
        $Afk = $_POST['farmAfk'];

        $sql = "insert into plaas (naam,afkorting) values('$naam','$Afk');";
                require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Farm.php?notice=add"); </script>';
    }
}

//do actions delete
if (isset($_GET['delete'])){
    //delete farm with uid
    $uid = $_GET['delete'];

    $sql = "delete from plaas where id = '$uid'";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo '<script>  window.location.replace("admin_Farm.php?notice=delete"); </script>';
}
?>

<script src="js/farmAction.js">
///////////////////////////////////////////////////////////////////////////////////
//   Do onchange Actions
///////////////////////////////////////////////////////////////////////////////////
</script>


<div class="container">
    <?php

    if (isset($_GET['notice'])){
        
        //if delete
        if ($_GET['notice']=='delete'){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Plaas Verwyder !
            </div>';
        }

        //if update
        if ($_GET['notice']=='update'){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Plaas Opgedateer !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

        //if add
        if ($_GET['notice']=='add'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Plaas Bygevoeg !
            </div>';
        }
    }

    //if no add or update show form
    if ((!isset($_GET['add']))&&(!isset($_GET['name']))){
        $sql = "select * from plaas limit 0,1000";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
    ?>
    <div class="form-group">
        <label for="farm">Plaas:</label>
        <select class="form-control" id="farm" onchange="updateAction()">
            <option value="">Kies Plaas</option>
            <?php
                foreach ($result[0] as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] .'</option>';
                }
            ?>
            <option value="addFarm">+Nuwe Plaas</option>
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
            <input type="text" class="form-control" value="" name="farmName" id="farmName" placeholder="Naam">
            <label for="farmAfk">afkorting:</label>
            <input type="text" class="form-control" value="" name="farmAfk" id="farmAfk" placeholder="afkorting">
            <input type="hidden" name="action" value="add">
        </div>
        <button type="button" class="btn btn-success" onclick="frmAdd.submit()">Voeg By</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Farm.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>

    <?php
    //update current
    if (isset($_GET['name'])){
        $uid = $_GET['name'];
        $sql = "select * from plaas where id = '$uid' limit 1;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        foreach ($result[0] as $row) {
            $name = $row['naam'];
            $Afk = $row['afkorting'];
        }
    ?>
    <form method="POST" id="frmUpdate">
        <div class="form-group">
            <label for="farmName">Verander Naam:</label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="farmName" id="farmName">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">

            <label for="farmAfk">Verander afkorting:</label>
            <input type="text" class="form-control" value="<?php echo $Afk; ?>" name="farmAfk" id="farmAfk">
            <input type="hidden" name="action" value="update">
        </div>
        <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
        <button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Farm.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>


</div>