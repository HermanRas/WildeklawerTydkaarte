<?PHP
///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['action'])){

    //do actions update
    if ($_POST['action']== 'update'){
        $uid = $_POST['uid'];
        $naam = $_POST['spryName'];
        $farm_id = $_POST['farm_id'];
        $afk = $_POST['spryAfk'];

        $sql = "update spilpunt set naam='$naam',afkorting='$afk',farm_id='$farm_id' where id = '$uid'";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_spry.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $naam = $_POST['spryName'];
        $Afk = $_POST['spryAfk'];
        $farm_id = $_POST['farm_id'];
        
        $sql = "insert into spilpunt (naam,afkorting,farm_id) values('$naam','$Afk','$farm_id');";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_spry.php?notice=add"); </script>';
    }
}

//do actions delete
if (isset($_GET['delete'])){
    //delete spry with uid
    $uid = $_GET['delete'];
    
    $sql = "delete from spilpunt where id = '$uid'";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo '<script>  window.location.replace("admin_spry.php?notice=delete"); </script>';
}
?>

<script src="js/spryAction.js">
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
                Spilpunt Verwyder !
            </div>';
        }

        //if update
        if ($_GET['notice']=='update'){
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Spilpunt Opgedateer !
            </div>';
        }

        //if add
        if ($_GET['notice']=='add'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Spilpunt Bygevoeg !
            </div>';
        }
    }
    
    //if no add or update show form
    if ((!isset($_GET['add']))&&(!isset($_GET['name']))){
        $sql = "select * from spilpunt limit 0,1000";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
    ?>
    <div class="form-group">
        <label for="Spry">Spilpunt:</label>
        <select class="form-control" id="Spry" onchange="updateAction()">
            <option value="">Kies Spilpunt</option>
            <?php
                foreach ($result[0] as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] .'</option>';
                }
            ?>
            <option value="addSpry">+Nuwe Spilpunt</option>
        </select>
    </div>
    <?php
    }
    ?>

    <?php
    //if add new
    if (isset($_GET['add'])){

        $sql = "select * from plaas;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $resultFarm = sqlQuery($sql, $sqlargs);
    ?>
    <form method="POST" id="frmAdd">
        <div class="form-group">
            <label for="spryName">Naam:</label>
            <input type="text" class="form-control" value="" name="spryName" id="spryName" placeholder="Naam">
            <label for="spryAfk">afkorting:</label>
            <input type="text" class="form-control" value="" name="spryAfk" id="spryAfk" placeholder="afkorting">
            <label for="farm_id">Verander tuis Plaas:</label>
            <select class="form-control" name="farm_id" id="farm_id">
                <option value="">Kies Plaas</option>
                <?php
                    foreach ($resultFarm[0] as $row) {
                        echo '<option value="'. $row['id'].'" '.'>('. $row['id']. ') ' . $row['naam'] .'</option>';
                     }
                ?>
            </select>
            <input type="hidden" name="action" value="add">
        </div>
        <button type="button" class="btn btn-success" onclick="frmAdd.submit()">Voeg By</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_spry.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>

    <?php
    //update current
    if (isset($_GET['name'])){
        $uid = $_GET['name'];
        $sql = "select * from spilpunt where id = '$uid' limit 1;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        foreach ($result[0] as $row) {
            $name = $row['naam'];
            $Afk = $row['afkorting'];
            $farm_id = $row['farm_id'];
        }
    
        $sql = "select * from plaas;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $resultFarm = sqlQuery($sql, $sqlargs);
    ?>
    <form method="POST" id="frmUpdate">
        <div class="form-group">
            <label for="spryName">Verander Naam:</label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="spryName" id="spryName">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">

            <label for="spryAfk">Verander afkorting:</label>
            <input type="text" class="form-control" value="<?php echo $Afk; ?>" name="spryAfk" id="spryAfk">
            <label for="farm_id">Verander tuis Plaas:</label>
            <select class="form-control" name="farm_id" id="farm_id">
                <option value="">Kies Plaas</option>
                <?php
                    foreach ($resultFarm[0] as $row) {
                        if($row['id']==$farm_id){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                        echo '<option value="'. $row['id'].'" '. $selected .'>('. $row['id']. ') ' . $row['naam'] .'</option>';
                     }
                ?>
            </select>
            <input type="hidden" name="action" value="update">
        </div>
        <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
        <button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_spry.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>


</div>