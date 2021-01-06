function updateAction() {
    var SpryName = document.getElementById("Spry").value;

    if (SpryName != `addSpry`) {
        window.location.replace("admin_Spry.php?name=" + SpryName);
    } else {
        window.location.replace("admin_Spry.php?add");
    }
}

function deleteAction() {
    SpryName = document.getElementById('uid').value;
    window.location.replace("admin_Spry.php?delete=" + SpryName);
}