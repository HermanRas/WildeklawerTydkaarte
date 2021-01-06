<?php
// Start the session
session_start();

// if all 4 pin codes entered
if ((null !== $_POST["pin1"]) && (null !== $_POST["pin2"]) && (null !== $_POST["pin3"]) && (null !== $_POST["pin4"])){

    //add db
    $pin = $_POST["pin1"].$_POST["pin2"].$_POST["pin3"].$_POST["pin4"]; 
    $sql = "select * from users where pwd = :pin;";
    require_once 'config/db_query.php';
    $sqlargs = array('pin'=>$pin);
    $db_data = sqlQuery($sql, $sqlargs);

    if(isset($db_data[0][0]['id'])){
        if($db_data[1] == 1){
            $db_data = $db_data[0][0];
            // cool** that user with that pin found
            $_SESSION['uid'] = $db_data['id'];
            $_SESSION['acl'] = $db_data['accesslevel'];
            $_SESSION['farm_id'] = $db_data['plaas_id'];

            //default guest
            $myPage = 'home.php';

            // if admin
            if ($db_data['accesslevel'] == '7'){
                // $myPage = 'admin_Summary.php';
                $myPage = 'home.php';
            }
            
            // if user
            if ($db_data['accesslevel'] == '4'){
                $myPage = 'user_InputSelect.php';
            }

            // if user
            if ($db_data['accesslevel'] == '1'){
                $myPage = 'home.php';
            }

            //send logged in user to his page
            header("Location: $myPage");

        }else{
            //no with that pin or too many users with same pin
            header("Location: index.php");
        }
    }else{
        // db no data
        header("Location: index.php");
    }
}else{
    // not all 4 pins was entered
    header("Location: index.php");
}


?>