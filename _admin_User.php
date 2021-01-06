<?PHP
///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['action'])){

    //do actions update
    if ($_POST['action']== 'update'){
        $uid = $_POST['uid'];
        $naam = $_POST['userName'];
        $pwd = $_POST['userPin'];
        $acl = $_POST['acl'];
        $farm_id = $_POST['farm_id'];

        include_once('_db_open.php');
        $sql = "update users set naam='$naam',pwd='$pwd',accesslevel='$acl',plaas_id='$farm_id' where id = '$uid'";
        $result = $conn->query($sql);

        echo '<script>  window.location.replace("admin_User.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $naam = $_POST['userName'];
        $pwd = $_POST['userPin'];
        $acl = $_POST['acl'];
        $farm_id = $_POST['farm_id'];

        include_once('_db_open.php');
        $sql = "insert into users (naam,pwd,accesslevel,plaas_id) values('$naam','$pwd','$acl','$farm_id');";
        $result = $conn->query($sql);
        echo '<script>  window.location.replace("admin_User.php?notice=add"); </script>';
    }
}

//do actions delete
if (isset($_GET['delete'])){
    //delete user with uid
    $uid = $_GET['delete'];
    
    include_once('_db_open.php');
    $sql = "delete from users where id = '$uid'";
    $result = $conn->query($sql);

    echo '<script>  window.location.replace("admin_User.php?notice=delete"); </script>';
}

if (isset($_GET['notice'])){
    
    //if delete
    if ($_GET['notice']=='delete'){
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            Gebruiker Verwyder !
         </div>';
    }

    //if update
    if ($_GET['notice']=='update'){
    echo '<div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            Gebruiker Opgedateer !
         </div>';
    }

    //if add
    if ($_GET['notice']=='add'){
    echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            Gebruiker Bygevoeg !
         </div>';
    }
}

?>

<script src="JS/userAction.js">
///////////////////////////////////////////////////////////////////////////////////
//   Do onchange Actions
///////////////////////////////////////////////////////////////////////////////////
</script>


<div class="container">
    <?php
    //if no add or update show form
    if ((!isset($_GET['add']))&&(!isset($_GET['name']))){
        include_once('_db_open.php');
        $sql = "select * from users limit 0,1000";
        $result = $conn->query($sql);
    ?>
    <div class="form-group">
        <label for="User">Users:</label>
        <select class="form-control" id="User" onchange="updateAction()">
            <option value="">Kies Gebruiker</option>
            <?php
                foreach ($result as $row) {
                    echo '<option value="'. $row['id'] .'">'. $row['naam'] .'</option>';
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
        include_once('_db_open.php');

        $sql = "select * from plaas;";
        $resultFarm = $conn->query($sql);

        $sql = "select * from access where naam not like '%spare%';";
        $resultAcl = $conn->query($sql);
    ?>
    <form method="POST" id="frmAdd">
        <div class="form-group">
            <label for="userName">Naam:</label>
            <input type="text" class="form-control" value="" name="userName" id="userName" placeholder="Naam">
            <label for="userPin">PIN:</label>
            <input type="text" class="form-control" value="" name="userPin" id="userPin" placeholder="PIN">

            <label for="farm_id">Verander tuis Plaas:</label>
            <select class="form-control" name="farm_id" id="farm_id">
                <option value="">Kies Plaas</option>
                <?php
                    foreach ($resultFarm as $row) {
                        echo '<option value="'. $row['id'].'" '. $selected .'>('. $row['id']. ') ' . $row['naam'] .'</option>';
                     }
                ?>
            </select>

            <label for="acl">Verander Toegang:</label>
            <select class="form-control" name="acl" id="acl" required>
                <option value="">Kies Toegang</option>
                <?php
                    foreach ($resultAcl as $row) {
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
        include_once('_db_open.php');
        $uid = $_GET['name'];
        $sql = "select * from users where id = '$uid' limit 1;";
        $result = $conn->query($sql);
        foreach ($result as $row) {
            $name = $row['naam'];
            $pass = $row['pwd'];
            $acl = $row['accesslevel'];
            $farm_id = $row['plaas_id'];
        }

        $sql = "select * from access where naam not like '%spare%';";
        $resultAcl = $conn->query($sql);

        $sql = "select * from plaas;";
        $resultFarm = $conn->query($sql);
    ?>
    <form method="POST" id="frmUpdate">
        <div class="form-group">
            <label for="userName">Verander Gebruiker:</label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="userName" id="userName">
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">

            <label for="userPin">Verander PIN:</label>
            <input type="text" class="form-control" value="<?php echo $pass; ?>" name="userPin" id="userPin">

            <label for="farm_id">Verander tuis Plaas:</label>
            <select class="form-control" name="farm_id" id="farm_id">
                <option value="">Kies Plaas</option>
                <?php
                    foreach ($resultFarm as $row) {
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
                    foreach ($resultAcl as $row) {
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