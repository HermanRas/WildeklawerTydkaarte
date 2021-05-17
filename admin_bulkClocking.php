<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom Headers -->
    <?php include_once('_header.html'); ?>
    <script src="App/dbAPI.js"></script>
    <script src="App/app.js"></script>
    <script src="App\backgroundSync.js"></script>
    <script src="JS/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <!-- NAV BAR -->
    <?php include_once('_nav.html'); ?>
    <script src="App/navAdmin.js"> </script>

    <!-- Page Title -->
    <h1 class="bg-success">
        <img style="height:1.5em;" src="Img/admin.png" class="rounded m-1 p-1" alt="Spilpunt">Admin - Massa TerugKlok
    </h1>
    <!-- Main Content -->
    <?php include_once('_admin_bulkClocking.php'); ?>

    <!-- Footer -->
    <?php include_once('_footer.html'); ?>
    <script src="JS/bootstrap.bundle.min.js"> </script>
</body>

</html>