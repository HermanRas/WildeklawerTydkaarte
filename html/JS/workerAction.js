function updateAction() {
    var workerAction = document.getElementById("worker").value;

    if (workerAction != `addWorker`) {
        window.location.replace("admin_Workers.php?name=" + workerAction);
    } else {
        window.location.replace("admin_Workers.php?add");
    }
}

function deleteAction() {
    workerUID = document.getElementById('uid').value;
    window.location.replace("admin_Workers.php?delete=" + workerUID);
}