// you are a admin or higher acl
if (parseInt(sessionStorage.getItem('acl')) > 6) {
    let admin_menu = document.getElementById('admin_menu');
    let user_menu = admin_menu.innerHTML;
    admin_menu.innerHTML = user_menu +
        `<ul class="navbar-nav mr-auto">
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
                                <a class="dropdown-item" href="admin_sync.html">Sync DB</a>
                            </div>
                        </li>
                    </ul>`
}