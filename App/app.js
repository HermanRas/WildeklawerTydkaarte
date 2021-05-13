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
    // for worklog
    if (localStorage.getItem('worklog') === null) {
        window.localStorage.setItem('worklog', JSON.stringify([]));
    }
    // for worklogUP
    if (localStorage.getItem('worklogUP') === null) {
        window.localStorage.setItem('worklogUP', JSON.stringify([]));
    }
    // for db_details
    if (localStorage.getItem('db_details') === null) {
        window.localStorage.setItem('db_details', JSON.stringify({}));
    }
    // for Clockings
    if (localStorage.getItem('clockings') === null) {
        window.localStorage.setItem('clockings', JSON.stringify([]));
    }
    // for ClockingsUP
    if (localStorage.getItem('clockingsUP') === null) {
        window.localStorage.setItem('clockingsUP', JSON.stringify([]));
    }

    updateDB();
}

function updateDB() {
    if (window.navigator.onLine) {
        // set api stuff
        let baseURL = 'https://wildeklawerapps.co.za/WildeklawerTydkaarte';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

        // update tables system is online
        getDBUpdate(baseURL + '/API/users.php' + '?KEY=' + apiKey, 'user');
        getDBUpdate(baseURL + '/API/workers.php' + '?KEY=' + apiKey, 'worker');
        getDBUpdate(baseURL + '/API/plaas.php' + '?KEY=' + apiKey, 'plaas');
        getDBUpdate(baseURL + '/API/spilpunt.php' + '?KEY=' + apiKey, 'spilpunt');
        getDBUpdate(baseURL + '/API/gewas.php' + '?KEY=' + apiKey, 'gewas');
        getDBUpdate(baseURL + '/API/task.php' + '?KEY=' + apiKey, 'task');
        getDBUpdate(baseURL + '/API/access.php' + '?KEY=' + apiKey, 'access');
        getDBUpdate(baseURL + '/API/clocklog.php' + '?KEY=' + apiKey, 'clockings');
        getDBUpdate(baseURL + '/API/worklog.php' + '?KEY=' + apiKey, 'worklog');

        var now = new Date();
        window.localStorage.setItem('db_details', JSON.stringify({ 'version': 1, 'last_update': now }));
    }
}

function updateAppStatus(status) {
    if (status == 'online') {
        // remove old notice if it was set
        let old_notice = document.getElementById('notice');
        if (old_notice) {
            old_notice.parentElement.removeChild(old_notice);
        }

        // load offline Clocks
        let clockings = JSON.parse(localStorage.getItem('clockingsUP'));
        let cLength = 0;
        if (clockings.length !== 0) {
            cLength = clockings.length;
        }

        // load offline bins
        let bins = JSON.parse(localStorage.getItem('worklogUP'));
        let bLength = 0;
        if (bins.length !== 0) {
            bLength = bins.length;
        }

        if (bLength > 0 || cLength > 0) {
            // set new notice
            setTimeout(function () {
                let body = document.body;
                let firstItem = document.body.children[0];
                let notice = document.createElement("div");
                notice.id = 'notice';
                notice.classList.add("AppOnline");
                notice.innerHTML = '<i class="fas fa-sync-alt"></i> ' + cLength + "/" + bLength;
                body.insertBefore(notice, firstItem);
                body.appendChild(notice);
            }, 2000);
        }
    } else {
        // set new notice
        setTimeout(function () {
            // remove old notice if it was set
            let old_notice = document.getElementById('notice');
            if (old_notice) {
                old_notice.parentElement.removeChild(old_notice);
            }

            // load offline Clocks
            let clockings = JSON.parse(localStorage.getItem('clockingsUP'));
            let cLength = 0;
            if (clockings.length !== 0) {
                cLength = clockings.length;
            }

            // load offline bins
            let bins = JSON.parse(localStorage.getItem('worklogUP'));
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
            body.insertBefore(notice, firstItem);
            body.appendChild(notice);
        }, 2000);
    }
}

// PWA Status change listener (Lost Connection go Offline)
window.addEventListener('offline', function (event) {
    updateAppStatus('offline');
});
window.addEventListener('online', function (event) {
    updateAppStatus('online');
});

if (window.navigator.onLine) {
    updateAppStatus('online');
}
if (!window.navigator.onLine) {
    updateAppStatus('offline');
}

// PWA Logout
function logout() {
    sessionStorage.clear();
    window.location.replace("index.html");
}

// PWA Session management (No Auth)
if (!sessionStorage.getItem('acl')) {
    let url = (window.location.href);
    if (!url.includes("index.html")) {
        window.location.replace("index.html");
    }
}

// PWA Fetch Data from URI
async function loadData(URI, TAG, POS) {
    jQuery.get(URI).done(
        function (data) {
            if (TAG !== '') {
                document.getElementById(TAG).innerHTML = data;
            } else {
                if (POS == 'HEAD') {
                    var pageHead = document.head;
                    pageHead.innerHTML = data + pageHead.innerHTML;
                }
                if (POS == 'BODY') {
                    var pageBody = document.body;
                    pageBody.innerHTML += data;
                }
                if (POS == 'BODY' && POS == 'HEAD') {
                    console.log('loadData(' + URI + ') ERROR don\'t know where to write');
                }
            }
        }
    );
    return Promise.resolve("Success");
}
async function loadScript(URI) {
    jQuery.getScript(URI);
    return Promise.resolve("Success");
}

// Offline Cookie Loader
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}