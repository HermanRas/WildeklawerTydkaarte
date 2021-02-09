<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){

        // All good do some work
        $sql = "SELECT
                workers.id,
                workers.naam,
                workers.van,
                workers.CN
                From
                workers";
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