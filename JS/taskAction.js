function updateAction() {
    var TaskName = document.getElementById("Task").value;

    if (TaskName != `addTask`) {
        window.location.replace("admin_Task.php?name=" + TaskName);
    } else {
        window.location.replace("admin_Task.php?add");
    }
}

function deleteAction() {
    TaskName = document.getElementById('uid').value;
    window.location.replace("admin_Task.php?delete=" + TaskName);
}