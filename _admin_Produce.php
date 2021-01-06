<?PHP
///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['action'])){

    //do actions update
    if ($_POST['action']== 'update'){
        $uid = $_POST['uid'];
        $naam = $_POST['produceName'];
        $afk = $_POST['produceAfk'];

        $sql = "update gewas set naam='$naam',afkorting='$afk' where id = '$uid'";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Produce.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $naam = $_POST['produceName'];
        $Afk = $_POST['produceAfk'];

        $sql = "insert into gewas (naam,afkorting) values('$naam','$Afk');";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Produce.php?notice=add"); </script>';
    }
}

//do actions delete
if (isset($_GET['delete'])){
    //delete produce with uid
    $uid = $_GET['delete'];
    
    $sql = "delete from gewas where id = '$uid'";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo '<script>  window.location.replace("admin_Produce.php?notice=delete"); </script>';
}
?>

<script src="JS/produceAction.js">
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
                Gewas Verwyder !
            </div>';
        }

        //if update
        if ($_GET['notice']=='update'){
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Gewas Opgedateer !
            </div>';
        }

        //if add
        if ($_GET['notice']=='add'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Gewas Bygevoeg !
            </div>';
        }
    }

    //if no add or update show form
    if ((!isset($_GET['add']))&&(!isset($_GET['name']))){
        $sql = "select * from gewas limit 0,1000";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
    ?>
    <div class="form-group">
        <label for="produce">Gewas:</label>
        <select class="form-control" id="Produce" onchange="updateAction()">
            <option value="">Kies Gewas</option>
            <?php
                foreach ($result[0] as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] .'</option>';
                }
            ?>
            <option value="addProduce">+Nuwe Gewas</option>
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
            <label for="produceName">Naam:</label>
            <input type="text" class="form-control" value="" name="produceName" id="produceName" placeholder="Naam">
            <label for="produceAfk">afkorting:</label>
            <input type="text" class="form-control" value="" name="produceAfk" id="produceAfk" placeholder="afkorting">
            <input type="hidden" name="action" value="add">
        </div>
        <button type="button" class="btn btn-success" onclick="frmAdd.submit()">Voeg By</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Produce.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>

    <?php
    //update current
    if (isset($_GET['name'])){
        $uid = $_GET['name'];
        $sql = "select * from gewas where id = '$uid' limit 1;";
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
            <label for="produceName">Verander Naam:</label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="produceName" id="produceName">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">

            <label for="produceAfk">Verander afkorting:</label>
            <input type="text" class="form-control" value="<?php echo $Afk; ?>" name="produceAfk" id="produceAfk">
            <input type="hidden" name="action" value="update">
        </div>
        <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
        <button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Produce.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>


</div>