function updateData() {
    let taskID = getTask();
    // id = 0 is not clocked
    if (taskID !== 0) {
        // id 1 || 4 is no input type job
        if (taskID == 1 || taskID == 4) {
            document.getElementById('main').innerHTML =
                `<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Die Werker is in geklok op \'n Taak wat geen invoer nodig het nie, soos skoffel of algemeen, klok uit en weer in met \'n nuwe taak wat invoer bevat.!</div>
                <a href="user_InputSelect.html" class="btn btn-primary">Tuis</a>`;
            // window.setTimeout(function () { window.location = "user_InputBadge.php"; }, 10000);
        } else {
            // all good let them caputer
            getlist(document.getElementById('Plaas'));
            getPryList(document.getElementById('spulpunt'));
            getGewasList(document.getElementById('Gewas'));
            getLoginUser();
            setTaskValue(taskID);
        }
    } else {
        document.getElementById('main').innerHTML =
            `<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Werker is nie op tyd kaart nie, teken eers in !</div>
            <a href="user_InputSelect.html" class="btn btn-primary">Tuis</a>`;
        // window.setTimeout(function () { window.location = "user_InputBadge.php"; }, 10000);
    }
}

function getTask() {
    let url = window.location.href.split('?');
    url = url[1].split('=')
    CN = url[1];

    let results = JSON.parse(localStorage.getItem("clockings"));

    // if there is any clockings
    if (results.length > 0) {
        // remove anyone that not the right company number
        let date = new Date().toISOString().substring(0, 10);
        const worker = results.filter(function (worker) {
            if (worker.cn == CN && worker.logDate == date) {
                return worker;
            }
            // return worker.cn == CN;
        });
        console.log(worker);
        // if there is clockings
        if (worker.length > 0) {
            // if the work type is not 1 & 4
            if (worker[0]['clockType'] == 0) {
                return worker[0]['task_id'];
            } else {
                // you last clocked out
                console.log('you last clocked out');
                return 0;
            }
        } else {
            // you have not clocked today
            console.log('you have not clocked today');
            return 0;
        }
    } else {
        // nobody clocked today
        console.log('nobody clocked today');
        return 0;
    }
}

///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
function formPost() {

    // if user save, set cookies

    // if (!isset($_COOKIE['bestemming_id'])) {
    //     setcookie('bestemming_id', 999, time() + (86400 * 30), "/"); // 86400 = 1 day
    // }

    // if (!isset($_COOKIE['farm_id'])) {
    //     setcookie('farm_id', $_SESSION['farm_id'], time() + (86400 * 30), "/"); // 86400 = 1 day
    // }

    // if (!isset($_COOKIE['Gewas'])) {
    //     setcookie('Gewas', 999, time() + (86400 * 30), "/"); // 86400 = 1 day
    // }

    // if (isset($_POST['Plaas'])) {
    //     $Plaas = $_POST["Plaas"];
    //     $spilpunt = $_POST["spilpunt"];
    //     $Gewas = $_POST["Gewas"];
    //     setcookie('spilpunt_id', $spilpunt, time() + (86400 * 30), "/"); // 86400 = 1 day
    //     setcookie('farm_id', $Plaas, time() + (86400 * 30), "/"); // 86400 = 1 day
    //     setcookie('Gewas', $Gewas, time() + (86400 * 30), "/"); // 86400 = 1 day
    // }


    // Add to sql
    //     $uid = $_SESSION["uid"];
    //     $Plaas = $_POST["Plaas"];
    //     $CN = $_POST["CN"];
    //     $spilpunt = $_POST["spilpunt"];
    //     $Gewas = $_POST["Gewas"];
    //     $Spry = $_POST["spilpunt"];
    //     $kratte = $_POST["kratte"];
    //     $task = $_POST["Taak"];
    //     $date = $_POST["Date"];
    //     $time = $_POST["time"];


    //     $sql = "insert into worklog (user_id,worker_id,farm_id,produce_id,spry_id,task_id,crates,logDate,logTime)
    //     values('$uid', '$CN', '$Plaas', '$Gewas', '$Spry', '$task', '$kratte', '$date', '$time'); ";

    //     msg = `<script>window.setTimeout(function(){ window.location = "user_InputSelect.html"; },3000);</script>
    //             <div class="alert alert-success alert-dismissible" role="alert">
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //             Taak Bygevoeg!</div ><h1 class="text-success text-center" style="font-size:10rem;">$kratte</h1>
    //             <a href="user_InputSelect.html" class="btn btn-primary">Tuis</a>`;
}


function getlist(Element) {
    let dropdown = Element.innerHTML;
    let list = '';
    let cookie = getCookie("farm_id");
    let results = JSON.parse(localStorage.getItem("plaas"));
    results.forEach(item => {
        if (item['id'] == cookie) {
            list += '<option value="' + item['id'] + '" selected>' + item['naam'] + '</option>';
        } else {
            list += '<option value="' + item['id'] + '">' + item['naam'] + '</option>';
        }
    });
    Element.innerHTML = dropdown + list;
}


function getPryList(Element) {
    let dropdown = Element.innerHTML;
    let list = '';
    let cookie = getCookie("spilpunt_id");
    let results = JSON.parse(localStorage.getItem("spilpunt"));
    results.forEach(item => {
        if (item['id'] == cookie) {
            list += '<option value="' + item['id'] + '" selected>' + item['naam'] + '</option>';
        } else {
            list += '<option value="' + item['id'] + '">' + item['naam'] + '</option>';
        }
    });
    Element.innerHTML = dropdown + list;
}


function getGewasList(Element) {
    let dropdown = Element.innerHTML;
    let list = '';
    let cookie = getCookie("Gewas");
    let results = JSON.parse(localStorage.getItem("gewas"));
    results.forEach(item => {
        if (item['id'] == cookie) {
            list += '<option value="' + item['id'] + '" selected>' + item['naam'] + '</option>';
        } else {
            list += '<option value="' + item['id'] + '">' + item['naam'] + '</option>';
        }
    });
    Element.innerHTML = dropdown + list;
}

function setTaskValue(taskID) {
    const task = document.getElementById('Taak_name');
    const task_id = document.getElementById('Taak');
    const tasks = JSON.parse(localStorage.getItem("task"));
    const taskVal = tasks.filter(function (taskVal) {
        return taskVal.id == taskID;
    })
    task.value = taskVal[0]['naam'];
    task_id.value = taskVal[0]['id'];
}

function getLoginUser() {
    const worker = document.getElementById('werkver_value');
    const cn = document.getElementById('CN');
    const uid = sessionStorage.getItem("uid");
    const users = JSON.parse(localStorage.getItem("worker"));
    const user = users.filter(function (user) {
        return user.id == uid;
    })
    worker.value = user[0]['naam'] + ' ' + user[0]['van'];
    cn.value = user[0]['CN'];
}