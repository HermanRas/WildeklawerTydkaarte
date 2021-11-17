<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom Headers -->
    <?php include_once('_header.html'); ?>
    <script src="JS/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(2);
        /* IE */
        -moz-transform: scale(2);
        /* FF */
        -webkit-transform: scale(2);
        /* Safari and Chrome */
        -o-transform: scale(2);
        /* Opera */
        transform: scale(2);
        padding: 10px;
    }

    /* Might want to wrap a span around your checkbox text */
    .checkboxtext {
        /* Checkbox text */
        font-size: 110%;
        display: inline;
    }
    </style>
</head>

<body>
    <!-- NAV BAR -->
    <?php include_once('_nav.html'); ?>
    <script src="App/navAdmin.js"> </script>

    <!-- Page Title -->
    <h1 class="bg-warning">
        <img style="height:1.5em;" src="Img/admin.png" class="rounded m-1 p-1" alt="Werker">Admin - Werker Druk Seleksie
    </h1>
    <!-- Main Content -->
    <?php include_once('_admin_PrintSelect.php'); ?>

    <!-- Footer -->
    <?php include_once('_footer.html'); ?>
    <script src="JS/bootstrap.bundle.min.js"> </script>
</body>

</html>