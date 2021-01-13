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
                <a class="nav-link active" href="home.php">Tuis <span class="sr-only">(current)</span></a>
            </li>

            <?php 
            // you are a user higher acl
            if($_SESSION['acl'] > 3){
            ?>
            <li class="nav-item">
                <a class="nav-link" href="user_InputSelect.php">Invoere</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user_InputBadge.php">Teken In/Uit</a>
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
                    <a class="dropdown-item" href="admin_Workers.php">Werkers</a>
                    <a class="dropdown-item" href="admin_Produce.php">Gewasse</a>
                    <a class="dropdown-item" href="admin_Farm.php">Plase</a>
                    <a class="dropdown-item" href="admin_Spry.php">Spilpunte</a>
                    <a class="dropdown-item" href="admin_Task.php">Take</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_Summary.php">Verslae</a>
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