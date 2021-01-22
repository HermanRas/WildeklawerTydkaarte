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
    $Gewas = $_POST["Gewas"];
    $Spry = $_POST["spilpunt"];
    $kratte = $_POST["kratte"];
    $task = $_POST["Taak"];
    $date = $_POST["Date"];
    $time = $_POST["time"];

    
    $sql = "insert into worklog (user_id,worker_id,farm_id,produce_id,spry_id,task_id,crates,logDate,logTime)
    values('$uid','$CN',     '$Plaas', '$Gewas',    '$Spry',   '$task', '$kratte','$date', '$time');";
    
    require_once 'config/db_query.php';
    $sqlargs = array();
    $res = sqlQuery($sql, $sqlargs);
    
    $msg =  '<script>window.setTimeout(function(){ window.location = "user_InputSelect.php"; },3000);</script>' .
            '<h1 class="text-success text-center" style="font-size:10rem;">'. $kratte.'</h1>'.
            '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Taak Bygevoeg !</div>'.
            '<a href="user_InputSelect.php" class="btn btn-primary">Tuis</a>';
}
?>

<div class="container">
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
    $res = sqlQuery($sql, $sqlargs);

    if($res[1] == 0){ // not clocked in
         $msg =  '<script>window.setTimeout(function(){ window.location = "user_InputBadge.php"; },10000);</script>' .
            '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Werker is nie op tyd kaart nie, teken eers in!</div>'.
            '<a href="user_InputSelect.php" class="btn btn-primary">Tuis</a>';
    }else{
        if ($res[0][0]['task_id'] == 1 || $res[0][0]['task_id'] == 4 || $res[0][0]['clockType']){ //for Algemeen or skoffel
            $msg =  '<script>window.setTimeout(function(){ window.location = "user_InputSelect.php"; },10000);</script>' .
                '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Taak het geen invoer (Algemeen of Skoffel)!</div>'.
                '<a href="user_InputSelect.php" class="btn btn-primary">Tuis</a>';
        }
    }

    if ($msg !== ''){
        echo $msg; 
        die;
        }
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
            <label>Gewas:</label>
            <select id="Gewas" name="Gewas" class="form-control" required>
                <option value="" selected>Kies Gewas</option>
                <?php
                    $sql = "select * from gewas limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    foreach ($result[0] as $row) {
                        if ($row['id']==$_COOKIE['Gewas']){
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
            <label>Taak:</label>
            <select id="Taak" name="Taak" class="form-control" onchange="updateTask(this.value);" required>
                <option value="" selected>Kies Taak</option>
                <?php
                    $sql = "SELECT * from task where (naam != 'Skoffel') AND (naam != 'Algemeen') limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    foreach ($result[0] as $row) {
                            echo '<option value="'.$row['id'].'">'.$row['naam'].'</option>';
                    }
                      ?>
            </select>
        </div>

        <div class="form-group">
            <label>Kratte:</label>
            <input type="number" class="form-control" placeholder="" id="kratte" name="kratte" required>
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


<!-- Page Level Scrip -->
<script>
// Fix crate listing for clearing field
function updateTask(taskID) {
    // console.log(taskID);
    let kratte = document.getElementById('kratte');
    if (taskID == 1 || taskID == 4) {
        kratte.readOnly = true;
        kratte.value = 0;
    } else {
        kratte.readOnly = false;
        kratte.value = '';
    }
}
</script>