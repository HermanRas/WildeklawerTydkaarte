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
            getPryList(document.getElementById('spilpunt'));
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
        // if there is clockings
        if (worker.length > 0) {
            // if the work type is not 1 & 4
            if (worker[worker.length - 1]['clockType'] == 0) {
                return worker[worker.length - 1]['task_id'];
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
function saveData() {
    // if form ready to save
    if (document.getElementById("frm1").checkValidity()) {

        // get from data
        let farm_id = document.getElementById('Plaas').value;
        let Gewas_id = document.getElementById('Gewas').value;
        let spilpunt_id = document.getElementById('spilpunt').value;
        let uid = sessionStorage.getItem("uid").value;
        let CN = document.getElementById('CN').value;
        let kratte = document.getElementById('kratte').value;
        let task = document.getElementById('Taak').value;
        let date = document.getElementById('date').value;
        let time = document.getElementById('time').value;


        // if user save, set cookies
        var now = new Date();
        var Ctime = now.getTime();
        var expireTime = Ctime + 1000 * 36000;

        document.cookie = 'farm_id=' + farm_id + ';expires=' + expireTime + ';path=/';
        document.cookie = 'Gewas=' + Gewas_id + ';expires=' + expireTime + ';path=/';
        document.cookie = 'spilpunt=' + spilpunt_id + ';expires=' + expireTime + ';path=/';

        // Store data to browser store to push to server when online
        let worklogUP = JSON.parse(window.localStorage.getItem('worklogUP'));
        let work_rec = {
            "user_id": uid,
            "worker_id": CN,
            "farm_id": farm_id,
            "produce_id": Gewas_id,
            "spry_id": spilpunt_id,
            "task_id": task,
            "crates": kratte,
            "logDate": date,
            "logTime": time,
        };
        worklogUP.push(work_rec);
        window.localStorage.setItem('worklogUP', JSON.stringify(worklogUP));

        // Give user feedback on save transaction
        msg = `<script>window.setTimeout(function(){ window.location = "user_InputSelect.html"; },3000);</script>
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    Taak Bygevoeg!</div ><h1 class="text-success text-center" style="font-size:10rem;">`+ kratte + `</h1>
                    <a href="user_InputSelect.html" class="btn btn-primary">Tuis</a>`;

        document.getElementById('main').innerHTML = msg;
    }
}

// Fetch farm default value from user clocking
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

// Fetch Spry names
function getPryList(Element) {
    let dropdown = Element.innerHTML;
    let list = '';
    let cookie = getCookie("spilpunt");
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

// Fetch produce names
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

// Fetch Set Default task value from clock
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

// Fetch current user data
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