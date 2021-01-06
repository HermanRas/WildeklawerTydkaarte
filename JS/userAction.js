function updateAction() {
    var userName = document.getElementById("User").value;

    if (userName != `addUser`) {
        window.location.replace("admin_User.php?name=" + userName);
    } else {
        window.location.replace("admin_User.php?add");
    }
}

function deleteAction() {
    userName = document.getElementById('uid').value;
    window.location.replace("admin_User.php?delete=" + userName);
}