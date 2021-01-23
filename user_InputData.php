<?php require_once('config/_session.php');
if(!isset($_COOKIE['bestemming_id'])){
    setcookie('bestemming_id', 999, time() + (86400 * 30), "/"); // 86400 = 1 day
}

if(!isset($_COOKIE['farm_id'])){
    setcookie('farm_id', $_SESSION['farm_id'] , time() + (86400 * 30), "/"); // 86400 = 1 day
}

if(!isset($_COOKIE['Gewas'])){
    setcookie('Gewas', 999, time() + (86400 * 30), "/"); // 86400 = 1 day
}

if (isset($_POST['Plaas'])){
    $Plaas = $_POST["Plaas"];
    $spilpunt = $_POST["spilpunt"];
    $Gewas = $_POST["Gewas"];
    setcookie('spilpunt_id', $spilpunt, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie('farm_id', $Plaas, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie('Gewas', $Gewas, time() + (86400 * 30), "/"); // 86400 = 1 day
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom Headers -->
    <?php include_once('_header.php'); ?>
</head>

<body>
    <!-- NAV BAR -->
    <?php include_once('_nav.php'); ?>


    <!-- Page Title -->

    <!-- Main Content -->
    <?php include_once('_user_InputData.php'); ?>


    <!-- Footer -->
    <?php include_once('_footer.php'); ?>
</body>

</html>