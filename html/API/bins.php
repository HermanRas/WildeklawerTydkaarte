<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){
        //is results for excel or Offline app?
        if (isset($_GET['EXCEL'])){

            // All good do some work
            $sql = "SELECT
                    worklog.logDate,
                    workers.naam,
                    workers.van,
                    workers.CN,
                    Sum(worklog.crates) As 'crates',
                    task.naam As task_naam
                    From
                    workers Left Join
                    worklog On workers.id = worklog.worker_id Left Join
                    task On worklog.task_id = task.id
                    where logDate > ''
                    Group By
                    worklog.logDate, workers.naam, workers.van, workers.CN, task.naam";

            require_once 'config/db_query.php';
            $sqlargs = array();
            $result = sqlQuery($sql, $sqlargs);

            //for excel use
            echo '<table style="border:1px solid black;width:100%">';
            echo '    <thead>';
            echo '        <tr style="border:1px solid black;">';
            echo '            <th style="border:1px solid black;">Datum</th>';
            echo '            <th style="border:1px solid black;">Naam</th>';
            echo '            <th style="border:1px solid black;">Van</th>';
            echo '            <th style="border:1px solid black;">CN</th>';
            echo '            <th style="border:1px solid black;">Kratte</th>';
            echo '            <th style="border:1px solid black;">Taak</th>';
            echo '        </tr>';
            echo '    </thead>';
            echo '    <tbody>';

            // repeat for all records
            foreach ($result[0] as $row) {
                echo "        <tr>";
                echo "            <td style=\"border:1px solid black;\">".$row['logDate']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['naam']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['van']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['CN']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['crates']."</td>";
                echo "            <td style=\"border:1px solid black;\">".$row['task_naam']."</td>";
                echo "        </tr>";
            }

            echo '    </tbody>';
            echo '</table>';
        }else{
            // All good do some work
            $sql = "SELECT
                    worklog.logDate,
                    workers.naam,
                    workers.van,
                    workers.CN,
                    Sum(worklog.crates) As 'crates',
                    task.naam As task_naam
                    From
                    workers Left Join
                    worklog On workers.id = worklog.worker_id Left Join
                    task On worklog.task_id = task.id
                    where logDate > '' and logDate > (CURDATE()-1)
                    Group By
                    worklog.logDate, workers.naam, workers.van, workers.CN, task.naam";

            require_once 'config/db_query.php';
            $sqlargs = array();
            $result = sqlQuery($sql, $sqlargs);
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