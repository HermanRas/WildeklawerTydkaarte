<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){
    
    for ($i=0; $i < count($_POST['worker_id']); $i++) {
        $uid = $_POST["user_id"][$i];
        $CN = $_POST["worker_id"][$i];
        $Plaas = $_POST["farm_id"][$i];
        $Gewas = $_POST["produce_id"][$i];
        $Spry = $_POST["spry_id"][$i];
        $kratte = $_POST["crates"][$i];
        $task = $_POST["task_id"][$i];
        $date = $_POST["logDate"][$i];
        $time = $_POST["logTime"][$i];

        // Lookup user_id
        $sql = "select id,naam,van from `workers` where CN = '$CN' limit 1;";

        require_once 'config/db_query.php';
        $sqlargs = array();
        $worker_id = sqlQuery($sql, $sqlargs);
        $worker_id = $worker_id[0][0]['id'];
        
        $sql = "insert into worklog (user_id,worker_id,farm_id,produce_id,spry_id,task_id,crates,logDate,logTime)
        values('$uid','$worker_id',     '$Plaas', '$Gewas',    '$Spry',   '$task', '$kratte','$date', '$time');";
        
        require_once 'config/db_query.php';
        $sqlargs = array();
        $res = sqlQuery($sql, $sqlargs);
        
    }
    
    $info = array('success'=>'DataSaved');
    echo   json_encode($info);
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
?>