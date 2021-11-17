function updateData() {
    // all good let them caputer
    getlist(document.getElementById('Plaas'));
    getPryList(document.getElementById('spilpunt'));
    getGewasList(document.getElementById('Gewas'));
    let CN = getWorkers(document.getElementById('workers'));
    let ClockDir = getClockDir('clockType', CN);
    getTaskList(document.getElementById('task'), ClockDir);
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
        let uid = sessionStorage.getItem("uid");
        let CNs = document.querySelectorAll('[id=CN]');
        let clockType = document.getElementById('clockType').value;
        let task = document.getElementById('task').value;
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
        let worklogUP = JSON.parse(window.localStorage.getItem('clockingsUP'));
        CNs.forEach(CN => {
            let work_rec = {
                "user_id": uid,
                "cn": CN.value,
                "farm_id": farm_id,
                "clockType": clockType,
                "spry_id": spilpunt_id,
                "task_id": task,
                "produce_id": Gewas_id,
                "logDate": date,
                "logTime": time,
            };
            worklogUP.push(work_rec);
        });

        window.localStorage.setItem('clockingsUP', JSON.stringify(worklogUP));

        // Give user feedback on save transaction
        msg = `<script>window.setTimeout(function(){ window.location = "home.html"; },3000);</script>
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    Klok kaarte opgedateer!</div >
                    <a href="home.html" class="btn btn-primary">Tuis</a>`;

        document.getElementById('main').innerHTML = msg;
    }
}

// Fetch farm names
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

// Fetch Task names
function getTaskList(Element, clockDir) {
    let dropdown = Element.innerHTML;
    let list = '';
    let cookie = getCookie("task");
    console.log(clockDir);
    if (clockDir == 1) {
        list += '<option value="0" selected>Teken UIT</option>';
    } else {
        let results = JSON.parse(localStorage.getItem("task"));
        results.forEach(item => {
            if (item['id'] == cookie) {
                list += '<option value="' + item['id'] + '" selected>' + item['naam'] + '</option>';
            } else {
                list += '<option value="' + item['id'] + '">' + item['naam'] + '</option>';
            }
        });
    }
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

// Fetch Workers names
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
            list += '<input type="text" class="form-control mt-1" value="' + item['naam'] + ' ' + item['van'] + '" readonly>' +
                '<input type="hidden" id="CN" name="CN[]" value="' + item['CN'] + '">';
        }
        Element.innerHTML = list;
    });
    return CNs[0];
}

// Fetch Last Clocking names
function getClockDir(Element, CN) {
    let clockVal = document.getElementById(Element);
    // let clockText = document.getElementById(Element + 'Text');
    let clockDir = null;

    let onServer = JSON.parse(localStorage.getItem("clockings"));
    let onDevice = JSON.parse(localStorage.getItem("clockingsUP"));
    results = onServer.concat(onDevice);

    results.forEach(item => {
        if (item['cn']) {
            if (item['cn'].toString() == CN) {
                clockDir = item['clockType'];
            }
        }
    });

    ////DEBUG Direction////
    if (clockDir == 1 || clockDir == null) {
        setTimeout(function () {
            clockVal.value = '0';
            // console.log('IN');
            // console.log('sleeped1');
        }, 500);
        setTimeout(function () {
            clockVal.value = '0';
            // console.log('IN');
            // console.log('sleeped2');
        }, 1000);

        return 0;
    } else {
        setTimeout(function () {
            clockVal.value = '1';
            // console.log('OUT');
            // console.log('sleeped1');
        }, 500);
        setTimeout(function () {
            clockVal.value = '1';
            // console.log('OUT');
            // console.log('sleeped2');
        }, 1000);
        return 1;
    }
}