<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom Headers -->
    <?php include_once('_header.php'); ?>

    <!-- include libraries(for login CSS  & jQuery) -->
    <link href="CSS/login.css" rel="stylesheet">
</head>

<body>
    <h1 style="text-align: center;color: #fff;"></h1>
    <form method="POST" action="_login.php" id="frm_login">
        <div class="numpad"></div>
        <script src="JS\login.js"></script>
    </form>
    <!-- footer -->
    <?php include_once('_footer.php'); ?>
</body>

</html>