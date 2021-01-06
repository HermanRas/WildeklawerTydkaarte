function updateAction() {
    var produceName = document.getElementById("Produce").value;

    if (produceName != `addProduce`) {
        window.location.replace("admin_Produce.php?name=" + produceName);
    } else {
        window.location.replace("admin_Produce.php?add");
    }
}

function deleteAction() {
    produceName = document.getElementById('uid').value;
    window.location.replace("admin_Produce.php?delete=" + produceName);
}