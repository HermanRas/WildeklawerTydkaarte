function updateAction() {
    var farmAction = document.getElementById("dest").value;

    if (farmAction != `addDest`) {
        window.location.replace("admin_Destination.php?name=" + farmAction);
    } else {
        window.location.replace("admin_Destination.php?add");
    }
}

function deleteAction() {
    farmName = document.getElementById('uid').value;
    window.location.replace("admin_Destination.php?delete=" + farmName);
}