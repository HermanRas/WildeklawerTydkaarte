
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Start of App JS -->
    <script src="JS/umd.js"></script>
    <script src="App/dbAPI.js"></script>
    <script src="App/app.js"></script>
    <!-- End Of App JS -->
    <script src="JS/jquery-3.6.0.min.js"></script>
    

    <!-- Custom Headers -->
    <?php include_once('_header.html'); ?>
</head>

<body onload="setup()">
    <!-- NAV BAR -->
    <?php include_once('_nav.html'); ?>


    <!-- Page Title -->
    <!-- Main Content -->
    <?php include_once('_user_IntputCheckBins.php'); ?>


    <!-- Footer -->
    <?php include_once('_footer.html'); ?>
</body>

</html>