<?PHP
///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['action'])){

    //do actions update
    if ($_POST['action']== 'update'){
        $uid = $_POST['uid'];
        $naam = $_POST['userName'];
        $van = $_POST['userVan'];
        $pwd = $_POST['userPin'];
        $CN = $_POST['CN'];
        $acl = $_POST['acl'];
        $farm_id = $_POST['farm_id'];

        $sql = "update users set naam='$naam',van='$van',CN='$CN',pwd='$pwd',accesslevel='$acl',farm_id='$farm_id' where id = '$uid'";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_User.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $naam = $_POST['userName'];
        $van = $_POST['userVan'];
        $CN = $_POST['CN'];
        $pwd = $_POST['userPin'];
        $acl = $_POST['acl'];
        $farm_id = $_POST['farm_id'];

        $sql = "insert into users (naam,van,CN,pwd,accesslevel,farm_id) values('$naam','$van','$CN','$pwd','$acl','$farm_id');";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_User.php?notice=add"); </script>';
    }
}

//do actions delete
if (isset($_GET['delete'])){
    //delete user with uid
    $uid = $_GET['delete'];
    
    $sql = "delete from users where id = '$uid'";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo '<script>  window.location.replace("admin_User.php?notice=delete"); </script>';
}
?>

<script src="js/userAction.js">
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
                Gebruiker Verwyder !
            </div>';
        }

        //if update
        if ($_GET['notice']=='update'){
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Gebruiker Opgedateer !
            </div>';
        }

        //if add
        if ($_GET['notice']=='add'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Gebruiker Bygevoeg !
            </div>';
        }
    }

    //if no add or update show form
    if ((!isset($_GET['add']))&&(!isset($_GET['name']))){
        $sql = "select * from users limit 0,1000";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
    ?>
    <div class="form-group">
        <label for="User">Gebruikers:</label>
        <select class="form-control" id="User" onchange="updateAction()">
            <option value="">Kies Gebruiker</option>
            <?php
                foreach ($result[0] as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] . ' ' .$row['van'].'</option>';
                }
            ?>
            <option value="addUser">+Nuwe Gebruiker</option>
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

        $sql = "select * from access where naam not like '%spare%';";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $resultAcl = sqlQuery($sql, $sqlargs);
    ?>
    <form method="POST" id="frmAdd">
        <div class="form-group">
            <label for="userName">Naam:</label>
            <input type="text" class="form-control" value="" name="userName" id="userName" placeholder="Naam">
            <label for="userVan">Van:</label>
            <input type="text" class="form-control" value="" name="userVan" id="userVan" placeholder="Van">
            <label for="CN">Werker Nommer:</label>
            <input type="number" class="form-control" value="" name="CN" id="CN" placeholder="Werker Nommer">
            <label for="userPin">PIN:</label>
            <input type="text" class="form-control" value="" name="userPin" id="userPin" placeholder="PIN">

            <label for="farm_id">Verander tuis Plaas:</label>
            <select class="form-control" name="farm_id" id="farm_id">
                <option value="">Kies Plaas</option>
                <?php
                    foreach ($resultFarm[0] as $row) {
                        echo '<option value="'. $row['id'].'" '. $selected .'>('. $row['id']. ') ' . $row['naam'] .'</option>';
                     }
                ?>
            </select>

            <label for="acl">Verander Toegang:</label>
            <select class="form-control" name="acl" id="acl" required>
                <option value="">Kies Toegang</option>
                <?php
                    foreach ($resultAcl[0] as $row) {
                        if($row['id']==$acl){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                        echo '<option value="'. $row['id'].'" '. $selected .'>('. $row['id']. ') ' . $row['naam'] .'</option>';
                     }
                ?>
            </select>
            <input type="hidden" name="action" value="add">
        </div>
        <button type="button" class="btn btn-success" onclick="frmAdd.submit()">Voeg By</button>
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_User.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>

    <?php
    //update current
    if (isset($_GET['name'])){
        $uid = $_GET['name'];
        $sql = "select * from users where id = '$uid' limit 1;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);

        foreach ($result[0] as $row) {
            $name = $row['naam'];
            $van = $row['van'];
            $CN = $row['CN'];
            $pass = $row['pwd'];
            $acl = $row['accesslevel'];
            $farm_id = $row['farm_id'];
        }

        $sql = "select * from access where naam not like '%spare%';";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $resultAcl = sqlQuery($sql, $sqlargs);

        $sql = "select * from plaas;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $resultFarm = sqlQuery($sql, $sqlargs);
    ?>
    <form method="POST" id="frmUpdate">
        <div class="form-group">
            <label for="userName">Naam:</label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="userName" id="userName"
                placeholder="Naam">
            <label for="userVan">Van:</label>
            <input type="text" class="form-control" value="<?php echo $van; ?>" name="userVan" id="userVan"
                placeholder="Van">
            <label for="CN">Werker Nommer:</label>
            <input type="number" class="form-control" value="<?php echo $CN; ?>" name="CN" id="CN"
                placeholder="Werker Nommer">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">

            <label for="userPin">Verander PIN:</label>
            <input type="text" class="form-control" value="<?php echo $pass; ?>" name="userPin" id="userPin">

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

            <label for="acl">Verander Toegang:</label>
            <select class="form-control" name="acl" id="acl">
                <option value="">Kies Toegang</option>
                <?php
                    foreach ($resultAcl[0] as $row) {
                        if($row['id']==$acl){
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
            onclick="window.location.href='admin_User.php'">Kanselleer</button>
    </form>
    <?php
    }
    ?>


</div>