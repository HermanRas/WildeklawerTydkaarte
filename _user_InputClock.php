<?PHP
// Set Global Vars
$msg = '';

///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['Plaas'])){
// Add to sql

    $uid = $_SESSION["uid"];
    $Plaas = $_POST["Plaas"];
    $CN = $_POST["CN"];
    $spilpunt = $_POST["spilpunt"];
    $Spry = $_POST["spilpunt"];
    $clockType = $_POST["clockType"];
    $task = $_POST["Taak"];
    $date = $_POST["Date"];
    $time = $_POST["time"];

    $sql = "insert into clocklog (user_id,worker_id,farm_id,spry_id,task_id,clockType,logDate,logTime)
    values('$uid','$CN',     '$Plaas',    '$Spry',   '$task', $clockType,'$date', '$time');";

    require_once 'config/db_query.php';
    $sqlargs = array();
    $res = sqlQuery($sql, $sqlargs);

    $msg =  '<script>window.setTimeout(function(){ window.location = "user_InputBadge.php"; },3000);</script>' .
            '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Tyd rooster Opgedateer !</div>'.
            '<a href="user_InputSelect.html" class="btn btn-primary">Tuis</a>';
}
?>

<h1 class="bg-wk"><img style="height:1.5em;" src="Img/klok.png" class="rounded m-1 p-1" alt="Klok">Klok</h1>
<div class="container">
    <?php 
        echo $msg; 
    ?>

    <?php if (!isset($_POST['Plaas'])){ ?>

    <form action="" method="POST" id="frm1" class="needs-validation was-validated" novalidate>
        <br>
        <div class="form-group">
            <label>Plaas: </label>
            <select id="Plaas" name="Plaas" class="form-control" required>
                <option value="" selected>Kies Plaas</option>
                <?php
                    $sql = "select * from plaas limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    foreach ($result[0] as $row) {
                        if ($row['id']==$_COOKIE['farm_id']){
                            echo '<option value="'.$row['id'].'" selected>'.$row['naam'].'</option>';
                        }else{
                            echo '<option value="'.$row['id'].'">'.$row['naam'].'</option>';
                        }
                    }
                      ?>
            </select>
        </div>

        <div class="form-group">
            <label>Spilpunt: </label>
            <select id="spulpunt" name="spilpunt" class="form-control" required>
                <option value="" selected>Kies Spilpunt</option>
                <?php
                    $sql = "select * from spilpunt limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    foreach ($result[0] as $row) {
                        if ($row['id']==$_COOKIE['spilpunt_id']){
                            echo '<option value="'.$row['id'].'" selected>'.$row['naam'].'</option>';
                        }else{
                            echo '<option value="'.$row['id'].'">'.$row['naam'].'</option>';
                        }
                    }
                      ?>
            </select>
        </div>

        <div class="form-group">
            <?php
                    $CN = $_GET['User'];
                    $sql = "select * from workers where CN='$CN' limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    ?>
            <label>Werker:</label>
            <input type="text" class="form-control"
                value="<?php echo $result[0][0]['naam']." ".$result[0][0]['van']." - ($CN)" ?>" readonly>
            <input type="hidden" name="CN" value="<?php echo $result[0][0]['id']; ?>">
        </div>

        <div class="form-group">
            <?php
                $CN = $_GET['User'];
                $sql = "SELECT * from clocklog 
                        left join workers on workers.id = clocklog.worker_id
                        where CN='$CN' 
                        and logDate = CURDATE()
                        order by clocklog.id DESC
                        limit 1";
                require_once 'config/db_query.php';
                $sqlargs = array();
                $result = sqlQuery($sql, $sqlargs);

                // var_dump($result[1]);
                // die;
                if ($result[1] == 0){
                    // has not clocked today
                    $direction = 0;
                    $directionString = 'IN';
                }else{
                    if($result[0][0]['clockType'] == 0){
                        // has clocked in
                        $direction = 1;
                        $directionString = 'UIT';
                    }else{
                        // has clocked out
                        $direction = 0;
                        $directionString = 'IN';
                    }
                }
            ?>
            <label>IN / UIT:</label>
            <input type="text" class="form-control" value="<?php echo $directionString ?>" readonly>
            <input type="hidden" name="clockType" value="<?php echo $direction ?>">
        </div>


        <div class="form-group">
            <label>Taak:</label>
            <select id="Taak" name="Taak" class="form-control" required>
                <option value="" selected>Kies Taak</option>
                <?php
                    $sql = "select * from task limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    if ( $direction == 0){
                        foreach ($result[0] as $row) {
                                echo '<option value="'.$row['id'].'">'.$row['naam'].'</option>';
                        }
                    }else{
                                echo '<option value="0" selected>Teken Uit</option>';
                    }
                      ?>
            </select>
        </div>

        <button class="btn btn-primary" id="Stuur">Stoor</button>

        <br>
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
    </form>
    <!-- ADD Fancy Form Validation -->
    <script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    document.getElementById("frm1").checkValidity();
    </script>
    <?php }?>
</div>