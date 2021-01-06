<nav class="navbar navbar-expand-md navbar-dark  bg-dark p-1">
    <a class="navbar-brand" href="#">
        <img src="Img/WKLogo_Full.jpeg" width="120px" class="d-inline-block align-top rounded" alt="">
    </a>
    <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link active" href="user_DayLive.php">Opsoming <span class="sr-only">(current)</span></a>
            </li>

            <?php 
            // you are a user higher acl
            if($_SESSION['acl'] > 3){
            ?>
            <li class="nav-item">
                <a class="nav-link" href="user_Input.php">Invoere</a>
            </li>
            <?php
            }
            ?>
            <?php 
            // you are a admin or higher acl
            if($_SESSION['acl'] > 6){
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Admin
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="admin_User.php">Gebruikers</a>
                    <a class="dropdown-item" href="admin_Workers.php">Werknemers</a>
                    <a class="dropdown-item" href="admin_Produce.php">Gewas</a>
                    <a class="dropdown-item" href="admin_Farm.php">Plaas</a>
                    <a class="dropdown-item" href="admin_Farm.php">Spilpunt</a>
                    <a class="dropdown-item" href="admin_Task.php">Taake</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="admin_Time.php">Tydrekords</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_Summary.php">Verslae <span class="sr-only">(current)</span></a>
            </li>
            <?php
            }
            ?>

        </ul>
        <ul class="navbar-nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="_logout.php">Teken Uit</a>
            </li>
        </ul>
    </div>
</nav>