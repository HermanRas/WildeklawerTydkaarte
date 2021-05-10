<?php

if (isset($_GET['delete'])){
    
    $tid = $_GET['delete'];
    
    $sql = "delete from worklog where id = '$tid'";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);

    //if delete
    echo   '<!-- The Page Title -->
            <title>Wildeklawer Tydkaarte</title>

            <!-- Add Manifest -->
            <link rel="manifest" href="./manifest.json">
            <!-- End Manifest -->

            <!-- Chrome/android APP settings -->
            <meta name="theme-color" content="#00AB93">
            <link rel="icon" href="Img/icon.jpeg" sizes="192x192">
            <!-- end of Chrome/Android App Settings  -->

            <!-- Bootstrap // you can use hosted CDN here-->
            <link rel="stylesheet" href="CSS/bootstrap.min.css">
            <link rel="stylesheet" href="CSS/app.css">
            <!-- end of bootstrap -->
            <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Taak Verwyder !
            </div>

            <br>
             <a href="home.html" class="btn btn-primary">Tuis</a>
             </div>';
            die;

    }
?>
<h1 class="bg-info"><img style="height:1.5em;" src="Img/tuis.png" class="rounded m-1 p-1" alt="Tuis">Tuis</h1>
<div class="container">
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="0">Datum</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="1">Plaas</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="2">Gewas</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="3">Spilpunt</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="4">Werker</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="5">Bestuurder</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="6">Taak</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="7">Kratte</a>

    <table id="example" class="display" style="width:95%">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Plaas</th>
                <th>Gewas</th>
                <th>Spilpunt</th>
                <th>Werker</th>
                <th>Bestuurder</th>
                <th>Taak</th>
                <th>Kratte</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $sql = "SELECT * from vWorkLog
                        order by id desc
                        LIMIT 0, 20;";
                require_once 'config/db_query.php';
                $sqlargs = array();
                $result = sqlQueryEmulate($sql, $sqlargs);
                foreach ($result[0] as $row) {
                ?>
                <td>
                    <a href="_home.php?delete=<?php echo $row['id'] ?>" style="color:red;"><i
                            class="fa fa-trash-alt"></i></a>
                    <span class="small">
                        <?php echo $row['logDate'].' '.$row['logTime'];?>
                    </span>
                </td>
                <td><?php echo $row['plaas'];?></td>
                <td><?php echo $row['gewas'];?></td>
                <td><?php echo $row['spilpunt'];?></td>
                <td><?php echo $row['naam'].' '.$row['van'];?></td>
                <td><?php echo $row['Bestuurder_naam'].' '.$row['Bestuurder_Van'];?></td>
                <td><?php echo $row['taak'];?></td>
                <td><?php echo $row['crates'];?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>