// Setup DB if not setup
function setup() {
    // for users
    if (localStorage.getItem('user') === null) {
        window.localStorage.setItem('user', JSON.stringify([]));
    }
    // for workers
    if (localStorage.getItem('worker') === null) {
        window.localStorage.setItem('worker', JSON.stringify([]));
    }
    // for farm
    if (localStorage.getItem('plaas') === null) {
        window.localStorage.setItem('plaas', JSON.stringify([]));
    }
    // for spilpunt
    if (localStorage.getItem('spilpunt') === null) {
        window.localStorage.setItem('spilpunt', JSON.stringify([]));
    }
    // for gewas
    if (localStorage.getItem('gewas') === null) {
        window.localStorage.setItem('gewas', JSON.stringify([]));
    }
    // for task
    if (localStorage.getItem('task') === null) {
        window.localStorage.setItem('task', JSON.stringify([]));
    }
    // for access
    if (localStorage.getItem('access') === null) {
        window.localStorage.setItem('access', JSON.stringify([]));
    }
    // for db_details
    if (localStorage.getItem('db_details') === null) {
        window.localStorage.setItem('db_details', JSON.stringify({}));
    }
    // for Clockings
    if (localStorage.getItem('clockings') === null) {
        window.localStorage.setItem('clockings', JSON.stringify([]));
    }
    // for Bins
    if (localStorage.getItem('bins') === null) {
        window.localStorage.setItem('bins', JSON.stringify([{ 'test': 1 }, { 'test': 2 }, { 'test': 3 },]));
    }
    updateDB();
}

function updateDB() {
    if (window.navigator.onLine) {
        // set api stuff
        let baseURL = 'https://phq-7hxllh2.petragroup.local/web_dev/Projects/WildeklawerTydkaarte';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

        // update tables system is online
        getDBUpdate(baseURL + '/API/users.php' + '?KEY=' + apiKey, 'user');
        getDBUpdate(baseURL + '/API/workers.php' + '?KEY=' + apiKey, 'worker');
        getDBUpdate(baseURL + '/API/plaas.php' + '?KEY=' + apiKey, 'plaas');
        getDBUpdate(baseURL + '/API/spilpunt.php' + '?KEY=' + apiKey, 'spilpunt');
        getDBUpdate(baseURL + '/API/gewas.php' + '?KEY=' + apiKey, 'gewas');
        getDBUpdate(baseURL + '/API/task.php' + '?KEY=' + apiKey, 'task');
        getDBUpdate(baseURL + '/API/access.php' + '?KEY=' + apiKey, 'access');

        var now = new Date();
        window.localStorage.setItem('db_details', JSON.stringify({ 'version': 1, 'last_update': now }));
    }
}

function updateAppStatus(status) {
    if (status == 'online') {
        // set new notice
        let old_notice = document.getElementById('notice');
        if (old_notice) {
            old_notice.remove();
        }
    } else {
        // remove old notice if it was set
        let old_notice = document.getElementById('notice');
        if (old_notice) {
            old_notice.remove;
        }

        // load offline Clocks
        let clockings = JSON.parse(localStorage.getItem('clockings'));
        let cLength = 0;
        if (clockings.length !== 0) {
            cLength = clockings.length;
        }

        // load offline bins
        let bins = JSON.parse(localStorage.getItem('bins'));
        let bLength = 0;
        if (bins.length !== 0) {
            bLength = bins.length;
        }

        // set new notice
        let body = document.body;
        let firstItem = document.body.children[0];
        let notice = document.createElement("div");
        notice.id = 'notice';
        notice.classList.add("AppOffline");
        notice.innerHTML = '<i class="fas fa-wifi"></i> ' + cLength + "/" + bLength;
        // body.insertBefore(notice, firstItem);
        body.appendChild(notice);
    }
}

window.addEventListener('offline', function (event) {
    updateAppStatus('offline');
});
window.addEventListener('online', function (event) {
    updateAppStatus('online');
});


function logout() {
    sessionStorage.clear();
    window.location.replace("index.html");
}


if (!sessionStorage.getItem('acl')) {
    let url = (window.location.href);
    if (!url.includes("index.html")) {
        window.location.replace("index.html");
    }
}