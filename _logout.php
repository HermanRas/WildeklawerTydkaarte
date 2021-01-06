<?php
//if its not started
session_start();

//now kill it
session_destroy();

//send them back to login
header("Location: index.php");
?>