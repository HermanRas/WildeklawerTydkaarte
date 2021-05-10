<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom Headers -->
    <?php include_once('_header.html'); ?>
</head>

<body>
    <!-- NAV BAR -->
    <?php include_once('_nav.html'); ?>
    <script src="App/navAdmin.js"> </script>

    <!-- Page Title -->
    <h1 class="bg-warning">
        <img style="height:1.5em;" src="Img/admin.png" class="rounded m-1 p-1" alt="Plaas">Admin - Plaas
    </h1>
    <!-- Main Content -->
    <?php include_once('_admin_Farm.php'); ?>

    <!-- Footer -->
    <?php include_once('_footer.html'); ?>
    <script src="JS/bootstrap.bundle.min.js"> </script>
</body>

</html>