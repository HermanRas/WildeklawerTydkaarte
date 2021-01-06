<?php
if (isset($_GET['delete'])){
    
    $tid = $_GET['delete'];
    
    include_once('_db_open.php');
    $sql = "delete from trips where id = '$tid'";
    $result = $conn->query($sql);

    //if delete
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            Trip Verwyder !
         </div>';
    }
?>

<div class="container">
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="0">Datum</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="1">Plaas</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="2">Gewas</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="3">Spilpunt</a>
    <a class="toggle-vis btn btn-info btn-sm my-2" data-column="4">Werknemers</a>
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
                <th>Werknemers</th>
                <th>Bestuurder</th>
                <th>Taak</th>
                <th>Kratte</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $sql = "select * from vWorkLog
                        order by Created desc;";
                require_once 'config/db_query.php';
                $sqlargs = array();
                $result = sqlQuery($sql, $sqlargs);
                foreach ($result[0] as $row) {
                ?>
                <td>
                    <a href="admin_Trip.php?delete=<?php echo $row['id'] ?>" style="color:red;"><i
                            class="fa fa-trash-alt"></i></a>
                    <span class="small">
                        <?php echo $row['logDate'].' '.$row['logTime'];?>
                    </span>
                </td>
                <td><?php echo $row['plaas'];?></td>
                <td><?php echo $row['gewas'];?></td>
                <td><?php echo $row['Spilpunt'];?></td>
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


<script>
// add fancy search and filter to table
$(document).ready(function() {
    var table = $('#example').DataTable({
        "order": [
            [0, "desc"]
        ],
        "scrollY": "500px",
        "scrollX": true,
        "paging": false
    });

    $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();
        if (this.classList.contains('btn-info')) {
            this.classList.add('btn-danger');
            this.classList.remove('btn-info');
        } else {
            this.classList.add('btn-info');
            this.classList.remove('btn-danger');
        }

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
    });

});
</script>