function updateAction() {
    var clientAction = document.getElementById("client").value;

    if (clientAction != `addClient`) {
        window.location.replace("admin_Clients.php?name=" + clientAction);
    } else {
        window.location.replace("admin_Clients.php?add");
    }
}

function deleteAction() {
    clientUID = document.getElementById('uid').value;
    window.location.replace("admin_Clients.php?delete=" + clientUID);
}