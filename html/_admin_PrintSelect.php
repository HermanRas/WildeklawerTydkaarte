<?php
        $sql = "SELECT naam,van,CN from workers
                Order By naam ASC";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQueryEmulate($sql, $sqlargs);
?>

<div class="container">
    <form name="frmUpdate" action="print.php" method="POST">
        <table id="example" class="display" style="width:95%">

            <thead>
                <tr>
                    <th>
                        Selection
                    </th>
                    <th>
                        Naam
                    </th>
                    <th>
                        Van
                    </th>
                    <th>
                        WerkerNommer
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($result[0] as $row) {
                ?>
                <!--############################## START ############################-->

                <tr>
                    <td>
                        <input type="checkbox" name="CN[]" value="<?php echo $row['CN']?>">
                    </td>
                    <td>
                        <?php echo $row['naam'];?>
                    </td>
                    <td>
                        <?php echo $row['van'];?>
                    </td>
                    <td>
                        <?php echo $row['CN'];?>
                    </td>
                </tr>

                <!--############################## END ############################-->
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="text-center">
            <button type="button" class="btn btn-success" onclick="frmUpdate.submit()">Druk</button>
            <button type="button" class="btn btn-warning" onclick="window.location.href='home.html'">Kanselleer</button>
        </div>
    </form>
</div>


<script>
// add fancy search and filter to table
var table = $('#example').DataTable({
    "scrollY": "500px",
    "scrollX": true,
    "paging": false
});
</script>