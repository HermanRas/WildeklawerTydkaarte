function updateAction() {
    var farmAction = document.getElementById("farm").value;

    if (farmAction != `addFarm`) {
        window.location.replace("admin_Farm.php?name=" + farmAction);
    } else {
        window.location.replace("admin_Farm.php?add");
    }
}

function deleteAction() {
    farmName = document.getElementById('uid').value;
    window.location.replace("admin_Farm.php?delete=" + farmName);
}