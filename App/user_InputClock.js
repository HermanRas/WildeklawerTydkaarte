function updateData() {
    // all good let them caputer
    getlist(document.getElementById('Plaas'));
    getPryList(document.getElementById('spilpunt'));
    getTaskList(document.getElementById('task'));
    let CN = getWorkers(document.getElementById('workers'));
    getClockDir('clockType', CN);
}

///////////////////////////////////////////////////////////////////////////////////
//   Do POST Actions
///////////////////////////////////////////////////////////////////////////////////
function saveData() {
    // if form ready to save
    if (document.getElementById("frm1").checkValidity()) {

        // get from data
        let farm_id = document.getElementById('Plaas').value;
        let task_id = document.getElementById('task').value;
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
        document.cookie = 'task=' + task_id + ';expires=' + expireTime + ';path=/';


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

        msg = `<script>window.setTimeout(function(){ window.location = "user_InputSelect.html"; },3000);</script>
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    Taak Bygevoeg!</div ><h1 class="text-success text-center" style="font-size:10rem;">`+ kratte + `</h1>
                    <a href="user_InputSelect.html" class="btn btn-primary">Tuis</a>`;

        document.getElementById('main').innerHTML = msg;
    }
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

function getTaskList(Element) {
    let dropdown = Element.innerHTML;
    let list = '';
    let cookie = getCookie("task");
    let results = JSON.parse(localStorage.getItem("task"));
    results.forEach(item => {
        if (item['id'] == cookie) {
            list += '<option value="' + item['id'] + '" selected>' + item['naam'] + '</option>';
        } else {
            list += '<option value="' + item['id'] + '">' + item['naam'] + '</option>';
        }
    });
    Element.innerHTML = dropdown + list;
}

function getWorkers(Element) {
    // Get CNs from URL 
    let url = window.location.href.split('?');
    url = url[1].split('=')
    CNs = url[1];
    CNs = CNs.split(',');

    let list = '';
    let results = JSON.parse(localStorage.getItem("worker"));
    results.forEach(item => {
        if (CNs.includes(item['CN'].toString())) {
            list += '<input type="text" class="form-control mt-1" value="' + item['naam'] + ' ' + item['naam'] + '" readonly>' +
                '<input type="hidden" name="CN[]" value="' + item['CN'] + '">';

        }
        Element.innerHTML = list;
    });
    return CNs[0];
}

function getClockDir(Element, CN) {
    clockVal = document.getElementById(Element);
    clockText = document.getElementById(Element + 'Text');


    let results = JSON.parse(localStorage.getItem("clock"));
    let toUP = JSON.parse(localStorage.getItem("clock"));

    clockText.value = 'IN'
    clockVal.value = '1'
}