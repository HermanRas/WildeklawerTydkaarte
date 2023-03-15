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
        $KDatum = $_POST['KDatum'];
        $updated_at = $_POST['updated_at'];
        $sql = "update clients set naam='$naam',kdatum='$KDatum',updated_at='$updated_at' where id = '$uid'";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Clients.php?notice=update"); </script>';
    }
    
    //do actions add
    if ($_POST['action']== 'add'){
        $uid = $_POST['uid'];
        $naam = $_POST['Naam'];
        $KDatum = $_POST['KDatum'];
        $created_at = $_POST['created_at'];
        $updated_at = $_POST['updated_at'];
        $sql = "insert into clients (uid,naam,kdatum,created_at,updated_at) values('$uid','$naam','$KDatum','$created_at','$updated_at');";

        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        echo '<script>  window.location.replace("admin_Clients.php?notice=add"); </script>';
    }
}

//do actions delete
// if (isset($_GET['delete'])){
//     //delete clients with uid
//     $uid = $_GET['delete'];

//     $sql = "delete from clients where id = '$uid'";
//     require_once 'config/db_query.php';
//     $sqlargs = array();
//     $result = sqlQuery($sql, $sqlargs);
//     echo '<script>  window.location.replace("admin_Clients.php?notice=delete"); </script>';
// }
?>

<script src="JS/clientAction.js">
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
                Kliente Konneksie Verwyder !
            </div>';
        }

        //if update
        if ($_GET['notice']=='update'){
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Kliente Konneksie Opgedateer !
            </div>';
        }

        //if add
        if ($_GET['notice']=='add'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Kliente Konneksie Bygevoeg !
            </div>';
        }
    }
  
    ?>

    <?php
    //update current
    if (isset($_GET['name'])){
        $uid = $_GET['name'];
        $sql = "select  uid,naam,kdatum,created_at,updated_at from clients where uid = '$uid' limit 1;";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
        $img_data = 'Img/favicon.png';
        foreach ($result[0] as $row) {
            $naam = $row['naam'];
            $KDatum = $row['kdatum'];
            $created_at = $row['created_at'];
            $updated_at = $row['updated_at'];
        }
    ?>


    <form method="POST" id="frmUpdate" enctype="multipart/form-data">
        <div class="form-group">
            <label for="farmName">Naam:</label>
            <input type="text" class="form-control" value="<?php echo $naam; ?>" name="Naam" id="naam"
                placeholder="Naam">

            <label for="KDatum">Klient Datum:</label>
            <input type="date" class="form-control" value="<?php echo $KDatum; ?>" name="KDatum" id="KDatum" disabled>

            <label for="updated_at">Updateerings Datum:</label>
            <input type="date" class="form-control" value="<?php echo $updated_at; ?>" name="updated_at" id="updated_at" disabled>
            
            <input type="hidden" value="<?php echo $uid; ?>" name="uid" id="uid">
            <input type="hidden" name="action" value="update">
        </div>

        <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Verander</button>
        <!--<button type="button" class="btn btn-danger" onclick="deleteAction()">Verwyder</button>-->
        <button type="button" class="btn btn-warning"
            onclick="window.location.href='admin_Clients.php'">Kanselleer
        </button>
    </form>
    <?php
    }
    ?>

    <table id="clients" class="display" style="width:95%">
        <thead>
            <tr>
                <th>#</th>
                <th>Naam</th>
                <th>Klient Datum</th>
                <th>Opdateer Datum</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select uid,naam,kdatum,created_at,updated_at from clients order by naam;";
            require_once 'config/db_query.php';
            $sqlargs = array();
            $result = sqlQuery($sql, $sqlargs);
            
            foreach ($result[0] as $row) {
            ?>
            <tr>
                <td>
                    <div class="text-centre">
                        <input class="checkBox" type="checkbox" name="uid" value="<?php echo $row['uid']?>">
                    </div>
                </td>
                <td><?php echo $row['naam'];?></td>
                <td><?php echo $row['kdatum'];?></td>
                <td><?php echo $row['updated_at'];?></td>
            </tr>
            <?php
            }
        ?>
        </tbody>
    </table>

</div>