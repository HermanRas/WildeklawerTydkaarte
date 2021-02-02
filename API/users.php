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
            echo '<table>';
            echo '    <thead>';
            echo '        <tr>';
            echo '            <th>id</th>';
            echo '            <th>naam</th>';
            echo '            <th>van</th>';
            echo '            <th>CN</th>';
            echo '            <th>farm_id</th>';
            echo '            <th>accesslevel</th>';
            echo '        </tr>';
            echo '    </thead>';
            echo '    <tbody>';
            echo '        <tr>';
            echo '            <td>id</td>';
            echo '            <td>with two columns</td>';
            echo '        </tr>';
            echo '    </tbody>';
            echo '</table>';
        }else{
            //for application use
            echo json_encode($result[0]);
        }

    }else{
        $err = array('error'=>'API AUTH KEY FAILED');
        echo   json_encode($err);
    }
}else{
    $err = array('error'=>'NO API KEY');
    echo   json_encode($err);
}