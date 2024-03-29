<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){

        // All good do some work
        $sql = "SELECT
                users.id,
                users.naam,
                users.van,
                users.CN,
                users.pwd,
                users.accesslevel,
                users.farm_id,
                plaas.naam As plaas_naam,
                plaas.afkorting As plaas_afk,
                access.naam As acc_naam,
                access.beskrywing As acc_afk
                From
                users Left Join
                plaas On users.farm_id = plaas.id Left Join
                access On users.accesslevel = access.id";
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
            echo '            <th style="border:1px solid black;">naam</th>';
            echo '            <th style="border:1px solid black;">van</th>';
            echo '            <th style="border:1px solid black;">CN</th>';
            echo '            <th style="border:1px solid black;">plaas_naam</th>';
            echo '            <th style="border:1px solid black;">plaas_afk</th>';
            echo '            <th style="border:1px solid black;">acc_naam</th>';
            echo '            <th style="border:1px solid black;">acc_afk</th>';
            echo '        </tr>';
            echo '    </thead>';
            echo '    <tbody>';

            // repeat for all records
            foreach ($result[0] as $row) {
                echo "        <tr>";
                echo "            <td style=\"border:1px solid black;\">".$row['id']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['naam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['van']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['CN']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['plaas_naam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['plaas_afk']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['acc_naam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['acc_afk']."</td>";
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