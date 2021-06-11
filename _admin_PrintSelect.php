<?php
        $sql = "SELECT naam,van,CN from workers
                Order By Id DESC";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);
?>

<div class="container">
    <form name="frmUpdate" action="print.php" method="POST">
        <?php
        foreach ($result[0] as $row) {
        ?>
        <!--############################## START ############################-->
        <div class="row">
            <div class="col">
                <div class="text-end">
                    <input type="checkbox" name="CN[]" value="<?php echo $row['CN']?>">
                </div>
            </div>
            <div class="col">
                <?php echo $row['CN']?>
                (<?php echo $row['naam'] . " ".$row['van'];?>)
            </div>
        </div>
        <!--############################## END ############################-->
        <?php
        }
        ?>
        <div class="text-center">
            <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Druk</button>
            <button type="button" class="btn btn-warning" onclick="window.location.href='home.html'">Kanselleer</button>
        </div>
    </form>
</div>