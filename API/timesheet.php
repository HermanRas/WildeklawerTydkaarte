<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){

        // All good do some work
        $sql = "SELECT
                vclocklogout.id,
                vclocklogout.naam,
                vclocklogout.van,
                vclocklogout.CN,
                vclocklogout.managerNaam,
                vclocklogout.managerVen,
                vclocklogout.logDate,
                vclocklogout.logTime,
                vclocklogout.plaasNaam,
                vclocklogout.sipluntNaam,
                vclocklogout.taakNaam,
                vclocklogout.clockType
                From
                vclocklogout";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);

        //is results for excel or Offline app?
        if (isset($_GET['EXCEL'])){
            //for excel use
            echo '<table style="border:1px solid black;width:100%">';
            echo '    <thead>';
            echo '        <tr style="border:1px solid black;">';
            echo '            <th style="border:1px solid black;">id</th>';
            echo '            <th style="border:1px solid black;">TotalTime</th>';
            echo '            <th style="border:1px solid black;">naam</th>';
            echo '            <th style="border:1px solid black;">van</th>';
            echo '            <th style="border:1px solid black;">CN</th>';
            echo '            <th style="border:1px solid black;">managerNaam</th>';
            echo '            <th style="border:1px solid black;">managerVan</th>';
            echo '            <th style="border:1px solid black;">logDate</th>';
            echo '            <th style="border:1px solid black;">plaasNaam</th>';
            echo '            <th style="border:1px solid black;">sipluntNaam</th>';
            echo '            <th style="border:1px solid black;">taakNaam</th>';
            echo '            <th style="border:1px solid black;">clockType</th>';
            echo '        </tr>';
            echo '    </thead>';
            echo '    <tbody>';

            // repeat for all records
            foreach ($result[0] as $row) {
                echo "        <tr>";
                echo "            <td style=\"border:1px solid black;\">".$row['id']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['logTime']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['naam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['van']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['CN']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['managerNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['managerVen']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['logDate']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['plaasNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['sipluntNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['taakNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['clockType']."</td>";
                echo "        </tr>";
            }

            echo '    </tbody>';
            echo '</table>';
        }else{
            //for application use
            echo json_encode($result[0]);
        }

    }else{
        http_response_code(403);
        $err = array('error'=>'API AUTH KEY FAILED');
        echo   json_encode($err);
    }
}else{
    http_response_code(403);
    $err = array('error'=>'NO API KEY');
    echo   json_encode($err);
}