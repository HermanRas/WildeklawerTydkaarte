<?PHP
// Set Global Vars
$msg = '';


// Load list of workers
    $today = date('Y-m-d');
    $sql = "SELECT id
            FROM `workers`
            WHERE contract_end < '$today' ";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $terminated = sqlQuery($sql, $sqlargs);

///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['Plaas'])){
// Add to sql

    $uid = $_SESSION["uid"];
    $Plaas = $_POST["Plaas"];
    $CNs = $_POST["CN"];
    $spilpunt = $_POST["spilpunt"];
    $Spry = $_POST["spilpunt"];
    $clockType = $_POST["clockType"];
    $Gewas = $_POST["Gewas"];
    $task = $_POST["Taak"];
    $date = $_POST["Date"];
    $time = $_POST["time"];

    $Terminated_CNs = [] ;
    foreach ($CNs as $CN ) {
    // Lookup user_id
    $sql = "select id,naam,van from `workers` where CN = '$CN' limit 1;";

    require_once 'config/db_query.php';
    $sqlargs = array();
    $worker_id = sqlQuery($sql, $sqlargs);
    $worker_id = $worker_id[0][0]['id'];

    
    $key = array_search($worker_id, array_column($terminated[0], 'id'));
    if ($key !== false){
        array_push($Terminated_CNs,$CN);
    }else{
        // add worker to clock log
        $sql = "insert into clocklog (user_id,worker_id,farm_id,spry_id,produce_id,task_id,clockType,logDate,logTime) 
                values('$uid','$worker_id',     '$Plaas',    '$Spry','$Gewas',   '$task', $clockType,'$date', '$time');";

        require_once 'config/db_query.php';
        $sqlargs = array();
        $res = sqlQuery($sql, $sqlargs);
        }
        
        $msg =  '<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Tyd rooster Opgedateer !</div>'.
                '<a href="user_InputSelect.php" class="btn btn-primary">Tuis</a><br>';
    }
    if(count($Terminated_CNs) > 0){
        $CN_Mgs= '';
        foreach ($Terminated_CNs as $CN) {
            $CN_Mgs = $CN_Mgs . $CN . '<br>';
        }
        $msg = $msg .'<br> Die volgende Werker se kontrak het verval en kan nie klok nie :'.
        '<div class="alert alert-danger alert-dismissible" role="alert">'. $CN_Mgs .'</div>';
    }
}
?>

<h1 class="bg-wk"><img style="height:1.5em;" src="Img/klok.png" class="rounded m-1 p-1" alt="Klok">Massa-Klok</h1>
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
            <label>Werkers:</label>
            <?php 
                for ($i=0; $i < count($_POST['CN']); $i++) { 
                    # code...
                    echo '<input type="text" class="form-control mt-1" value="'. $_POST['name'][$i].'" readonly>';
                    echo '<input type="hidden" name="CN[]" value="'. $_POST['CN'][$i].'">';
                }
            ?>
        </div>

        <div class="form-group">
            <?php
                $CN = $_POST['CN'][0];
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

        <div class="form-group">
            <label>Gewas:</label>
            <select id="Gewas" name="Gewas" class="form-control" required>
                <option value="" selected>Kies Gewas</option>
                <?php
                    $sql = "select * from gewas limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    if ( $direction == 0){
                        foreach ($result[0] as $row) {
                            if ($row['id']==$_COOKIE['Gewas']){
                                echo '<option value="'.$row['id'].'" selected>'.$row['naam'].'</option>';
                            }else{
                                echo '<option value="'.$row['id'].'">'.$row['naam'].'</option>';
                            }
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