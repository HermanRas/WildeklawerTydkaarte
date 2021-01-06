<?php
// Start the session
session_start();

// if all 4 pin codes entered
if ((null !== $_POST["pin1"]) && (null !== $_POST["pin2"]) && (null !== $_POST["pin3"]) && (null !== $_POST["pin4"])){

    //add db
    include_once '_db_open.php';

    $pin = $_POST["pin1"].$_POST["pin2"].$_POST["pin3"].$_POST["pin4"]; 
    $sql = "select * from users where pwd = '$pin';";
    $db_data = $conn->query($sql)->fetch();

    if(isset($db_data['id'])){
        // cool** that user with that pin found
        $_SESSION['uid'] = $db_data['id'];
        $_SESSION['acl'] = $db_data['accesslevel'];
        $_SESSION['farm_id'] = $db_data['plaas_id'];

        //default guest
        $myPage = 'user_DayLive.php';

        // if admin
        if ($db_data['accesslevel'] == '7'){
            // $myPage = 'admin_Summary.php';
            $myPage = 'user_DayLive.php';
        }
        
        // if user
        if ($db_data['accesslevel'] == '4'){
            $myPage = 'user_Input.php';
        }

        // if user
        if ($db_data['accesslevel'] == '1'){
            $myPage = 'user_DayLive.php';
        }

        //send logged in user to his page
        header("Location: $myPage");

    }else{
        //no with that pin or too many users with same pin
        header("Location: index.php");
    }
   

}else{
    // not all 4 pins was entered
    header("Location: index.php");
}


?>