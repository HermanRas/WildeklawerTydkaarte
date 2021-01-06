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
    $bestemming = $_POST["bestemming"];
    $Gewas = $_POST["Gewas"];
    $Blok = $_POST["Blok"];
    $kratte = $_POST["kratte"];
    $trok = $_POST["trokno"];
    $datetime = $_POST["Date"].' '. $_POST["time"];
    
    $sql = "insert into trips ('users_id','plaas_id','gewas_id','blok','kratte','trok','datetime','bestemming_id')
           values('$uid','$Plaas','$Gewas','$Blok','$kratte','$trok','$datetime','$bestemming');";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $res = sqlQuery($sql, $sqlargs);

// $ServerDate = new DateTime('now');
//     $Logfile = fopen("sql.log", "a") or die("Unable to open file!");
//     fwrite($Logfile, 'START[' . $ServerDate->format('Y-m-d H:i:s') ."\n");
//     fwrite($Logfile, $sql."\n");
//     fwrite($Logfile, "END]\n");
//     fclose($Logfile);


    $sql = "select
            trips.datetime as 'DatumTyd',
            substr(trips.datetime, -6) as Tyd,
            plaas.afkorting as Plaas,
            gewas.afkorting as Gewas,
            trips.blok as Blok,
            trips.trok as Trok,
            trips.kratte as Bins,
            bestemming.afkorting as Pakhuis
            from trips
            left join plaas on plaas.id = trips.plaas_id
            left join gewas on gewas.id = gewas_id
            left join users on users.id = users_id
            left join bestemming on bestemming.id = bestemming_id
            order by trips.datetime desc limit 1;";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $PlaasRes = sqlQuery($sql, $sqlargs);

    foreach ($PlaasRes[0] as $row ) {
        $msgText =  $row['Plaas'] .' - '. $row['Gewas'] .' - '. $row['Blok'] .' - '. $row['Bins'] .' - '. $row['Trok'] .' - '. $row['Pakhuis'].' - '. $row['Tyd'];
        $msgText = str_replace("&","en", $msgText);
    }

    $msg = '<div class="alert alert-success text-center" style="max-width=80%;" role="alert">
                <span class="fa fa-pen"> </span>
                Stuur Whatsapp !!
                <a class="btn btn-success btn-sm" href="https://api.whatsapp.com/send?phone=&text='.$msgText.'&source=&data=" id="link" target="_blank">WHATSAPP</a> 
                <a class="btn btn-primary btn-sm" href="user_Input.php" id="link" >Tuis</a>
            </div>';
            
}
?>

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
            <label>Pakhuis: </label>
            <select id="bestemming" name="bestemming" class="form-control" required>
                <option value="" selected>Kies Pakhuis</option>
                <?php
                    $sql = "select * from bestemming limit 0,1000";
                    require_once 'config/db_query.php';
                    $sqlargs = array();
                    $result = sqlQuery($sql, $sqlargs);
                    // Options
                    foreach ($result as $row) {
                        if ($row['id']==$_COOKIE['bestemming_id']){
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
                    foreach ($result as $row) {
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
            <label>Blok:</label>
            <input type="text" id="Blok" name="Blok" class="form-control" minlength="2"
                value="<?php if (isset($_COOKIE['Blok'])){echo $_COOKIE['Blok'];} ?>" required />
        </div>


        <div class="form-group">
            <label>Bins:</label>
            <input type="number" class="form-control" placeholder="" id="kratte" name="kratte" required>
        </div>

        <div class="form-group">
            <label>Trok No:</label>
            <input type="text" class="form-control" placeholder="" id="trokno" name="trokno" required>
        </div>
        <button class="btn btn-primary" id="Stuur">Stuur</button>

        <br>

        <?php
            echo "<script>let admin = ".$_SESSION['acl']."; </script>";
            ?>
        <script>
        let readonly = '';
        if (admin > 9) {
            readonly = '';
        } else {
            readonly = 'readonly';
        }
        </script>

        <div class="form-group">
            <label>Datum:</label>
            <script>
            // Use of Date.now() function 
            var date = new Date().toISOString().substring(0, 10)
            // Printing the current date
            document.write('<input type="date" value="' + date +
                '" class="form-control" ' + readonly + ' id="date"  name="Date" required>');
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
                '" class="form-control" ' + readonly + ' id="time" name="time"  required>');
            </script>
        </div>
    </form>
    <?php }?>
</div>

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