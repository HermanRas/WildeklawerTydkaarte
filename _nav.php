<nav class="navbar navbar-expand-md navbar-dark  bg-dark p-1">


    <a class="btn btn-outline-secondary m-2 p-0 px-1" href="home.php">
        <img style="max-height:40px;" src="Img/tuis.png" class="rounded" alt="Tuis">
        <br>
        <span class="text-xxs">Tuis</span>
    </a>

    <a href="user_InputSelect.php" class="btn btn-outline-secondary m-2 p-0 px-1">
        <img style="max-height:40px;" src="Img/invoere.png" class="rounded" alt="Invoer">
        <br>
        <span class="text-xxs">Invoer</span>
    </a>
    <a href="user_InputCheckBins.php" class="btn btn-outline-secondary m-2 p-0 px-1">
        <img style="max-height:40px;" src="Img/bins.png" class="rounded" alt="Invoer">
        <br>
        <span class="text-xxs">Bins?</span>
    </a>
    <a href="user_InputBadge.php" class="btn btn-outline-secondary m-2 p-0 px-1">
        <img style="max-height:40px;" src="Img/klok.png" class="rounded" alt="Klok">
        <br>
        <span class="text-xxs">Klok</span>
    </a>
    <a href="user_InputBulkBadge.php" class="btn btn-outline-secondary m-2 p-0 px-1">
        <img style="max-height:40px;" src="Img/Bulk_klok.png" class="rounded" alt="BulkKlok">
        <br>
        <span class="text-xxs">Massa-Klok</span>
    </a>
    <a href="_logout.php" class="btn btn-outline-secondary m-2 p-0 px-1">
        <img style="max-height:40px;" src="Img/teken_uit.png" class="rounded" alt="TekenUit">
        <br>
        <span class="text-xxs">TekenUit</span>
    </a>

    <?php 
        // you are a admin or higher acl
        if($_SESSION['acl'] > 6){
    ?>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="btn btn-outline-secondary m-2 p-0 px-1  dropdown-toggle" href="#" id="navbarDropdown"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img style="max-height:40px;" src="Img/admin.png" class="rounded" alt="admin">
                <br>
                <span class="text-xxs">Admin</span>
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
    </ul>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="btn btn-outline-secondary m-2 p-0 px-1  dropdown-toggle" href="#" id="navbarDropdown"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img style="max-height:40px;" src="Img/verslae.png" class="rounded" alt="verslae">
                <br>
                <span class="text-xxs">Verslae</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="admin_Verslae.php">Tyd PerDag</a>
                <a class="dropdown-item" href="admin_Verslae.php">Tyd PerTaak</a>
                <a class="dropdown-item" href="admin_Verslae.php">Tyd Staat</a>
                <a class="dropdown-item" href="admin_Verslae.php">Gem TydPerTaak</a>
                <a class="dropdown-item" href="admin_Verslae.php">Gem TydPerGewas</a>
                <a class="dropdown-item" href="admin_Verslae.php">???</a>
            </div>
        </li>
    </ul>
    <?php
        }
    ?>
</nav>