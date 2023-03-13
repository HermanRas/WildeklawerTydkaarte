<?php
// TEST to see if API is present
if (isset($_GET['KEY'])){
    // TEST to see if this is our key
    if ($_GET['KEY'] == 'MucJIL1vkG6YJibwB7HINgvnT89gpK'){

        // Set header for free run, send response then process
        ignore_user_abort(true);//not required
        set_time_limit(60);
        // Buffer all upcoming output...
        ob_start();
        // After response processing 
        $uid        = $_POST["uid"];
        $naam       = $_POST["naam"];
        $gebruiker  = $_POST["gebruiker"];
        $kdatum     = $_POST["kdatum"];
        $created_at = $_POST["created_at"];
        $updated_at = $_POST["updated_at"];
        
        $sql = "insert into clients (uid, naam, gebruiker, kdatum, created_at, updated_at)
        '$uid','$naam','$gebruiker', '$kdatums','$created_at','$updated_at' from worklog;";
        
        require_once 'config/db_query.php';
        $sqlargs = array();
        $res = sqlQuery($sql, $sqlargs);
        echo json_encode($res[0]);
        // Get the size of the output.
        $size = ob_get_length();
        // Disable compression (in case content length is compressed).
        header("Content-Encoding: none");
        // Set the content length of the response.
        header("Content-Length: {$size}");
        // Close the connection.
        header("Connection: close");
        // Flush all output.
        ob_end_flush();
        ob_flush();
        flush();

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