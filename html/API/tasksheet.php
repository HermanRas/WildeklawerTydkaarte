<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){

        // All good do some work
        $sql = "SELECT
                vworktimecalc.MinutesOnClock,
                vworktimecalc.inDate,
                vworktimecalc.inTime,
                vworktimecalc.outDate,
                vworktimecalc.outTime,
                vworktimecalc.naam,
                vworktimecalc.van,
                vworktimecalc.CN,
                vworktimecalc.managerNaam,
                vworktimecalc.managerVen,
                vworktimecalc.plaasNaam,
                vworktimecalc.sipluntNaam,
                vworktimecalc.taakNaam
                From
                vworktimecalc";
        require_once 'config/db_query.php';
        $sqlargs = array();
        $result = sqlQuery($sql, $sqlargs);

        //is results for excel or Offline app?
        if (isset($_GET['EXCEL'])){
            //for excel use
            echo '<table style="border:1px solid black;width:100%">';
            echo '    <thead>';
            echo '        <tr style="border:1px solid black;">';
            echo '            <th style="border:1px solid black;">MinutesOnClock</th>';
            echo '            <th style="border:1px solid black;">inDate</th>';
            echo '            <th style="border:1px solid black;">inTime</th>';
            echo '            <th style="border:1px solid black;">outDate</th>';
            echo '            <th style="border:1px solid black;">outTime</th>';
            echo '            <th style="border:1px solid black;">naam</th>';
            echo '            <th style="border:1px solid black;">van</th>';
            echo '            <th style="border:1px solid black;">CN</th>';
            echo '            <th style="border:1px solid black;">managerNaam</th>';
            echo '            <th style="border:1px solid black;">managerVan</th>';
            echo '            <th style="border:1px solid black;">plaasNaam</th>';
            echo '            <th style="border:1px solid black;">sipluntNaam</th>';
            echo '            <th style="border:1px solid black;">taakNaam</th>';
            echo '        </tr>';
            echo '    </thead>';
            echo '    <tbody>';

            // repeat for all records
            foreach ($result[0] as $row) {
                echo "        <tr>";
                echo "            <td style=\"border:1px solid black;\">".$row['MinutesOnClock']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['inDate']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['inTime']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['outDate']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['outTime']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['naam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['van']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['CN']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['managerNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['managerVen']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['plaasNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['sipluntNaam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['taakNaam']."</td>";
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