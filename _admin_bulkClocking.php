<?php

if (isset($_POST['uit'])){
    $uid = $_POST['uid'];
    $date = $_POST['Date'];
    $time = $_POST['time'];
    $CNs = $_POST['CN'];

    foreach ($CNs as $cn) {
        // Lookup user_id
        $sql = "select id from `workers` where CN = '".$cn."' limit 1;";

        require_once 'config/db_query.php';
        $sqlargs = array();
        $worker_id = sqlQuery($sql, $sqlargs);
        $worker_id = $worker_id[0][0]['id'];


        // add worker to clock log
        $sql = "insert into clocklog (user_id,worker_id,farm_id,spry_id,produce_id,task_id,clockType,logDate,logTime) 
                values('$uid','$worker_id',0,0,0,0,1,'$date', '$time');";
        // echo $sql."<br>";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $res = sqlQuery($sql, $sqlargs);
    }

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
                Werkers Uit Geklok !
            </div>

            <br>
             <a href="home.html" class="btn btn-primary">Tuis</a>
             </div>';
            die;

    }
?>
<div class="container">
    <form method="POST">
        <a class="btn btn-success" href="#" onclick="selectAll()">Merk Almal</a>
        <a class="btn btn-info" href="#" onclick="UnSelectAll()">Merk Geen</a>
        <table id="example" class="display" style="width:95%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Naam</th>
                    <th>CN</th>
                    <th>Datum</th>
                    <th>Plaas</th>
                    <th>Spilpunt</th>
                    <th>Taak</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * from `vworktimecalc` 
                        where
                        (inDate = CURDATE()
                        or
                        inDate = CURDATE()-1)
                        and
                        outDate IS NULL
                        limit 0,1000";
                require_once 'config/db_query.php';
                $sqlargs = array();
                $result = sqlQuery($sql, $sqlargs);
                
                foreach ($result[0] as $row) {
                ?>
                <tr>
                    <td>
                        <div class="text-end">
                            <input class="checkBox" type="checkbox" name="CN[]" value="<?php echo $row['CN']?>" checked>
                        </div>
                    </td>
                    <td><?php echo $row['naam'].' '.$row['van'];?></td>
                    <td><?php echo $row['CN'];?></td>
                    <td><?php echo $row['inDate'].' '.$row['inTime'];?></td>
                    <td><?php echo $row['plaasNaam'];?></td>
                    <td><?php echo $row['spilpuntNaam'];?></td>
                    <td><?php echo $row['taakNaam'];?></td>
                </tr>
                <?php
                }
            ?>
            </tbody>
        </table>

        <input type="hidden" name="uid" id="uid" value="">
        <div class="form-group">
            <label>Datum:</label>
            <script>
            // Use of Date.now() function 
            var date = new Date().toISOString().substring(0, 10)
            // Printing the current date
            document.write('<input type="date" value="' + date +
                '" class="form-control" id="date"  name="Date" required>');
            </script>
        </div>

        <div class="form-group">
            <label>Tyd:</label>

            <script>
            // Use of Date.now() function 
            var date = new Date();
            date.setHours(date.getHours() + 2);
            date = date.toISOString().substring(11, 16);
            // Printing the current date                     
            document.write('<input type="text" value="' + date +
                '" class="form-control" id="time" name="time"  required>');
            </script>
        </div>
        <button name="uit" class="btn btn-info" type="submit">Klok Uit</button>
        <a class="btn btn-primary" href="home.html">Tuis</a>
    </form>
</div>

<script>
document.getElementById('uid').value = sessionStorage.getItem('uid');
// add fancy search and filter to table
var table = $('#example').DataTable({
    "scrollY": "500px",
    "scrollX": true,
    "paging": false
});
</script>

<script type="text/javascript">
function selectAll() {
    var items = document.querySelectorAll(".checkBox");
    for (var i = 0; i < items.length; i++) {
        if (items[i].type == 'checkbox')
            items[i].checked = true;
    }
}

function UnSelectAll() {
    var items = document.querySelectorAll(".checkBox");
    for (var i = 0; i < items.length; i++) {
        if (items[i].type == 'checkbox')
            items[i].checked = false;
    }
}
</script>