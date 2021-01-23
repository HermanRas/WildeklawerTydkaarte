<?php require_once('config/_session.php'); ?>
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
    <h1 class="bg-warning">
        <img style="height:1.5em;" src="Img/admin.png" class="rounded m-1 p-1" alt="Plaas">Admn - Plaas
    </h1>
    <!-- Main Content -->
    <?php include_once('_admin_Farm.php'); ?>

    <!-- Footer -->
    <?php include_once('_footer.php'); ?>
</body>

</html>