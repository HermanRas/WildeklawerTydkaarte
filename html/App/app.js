/**
 * @param {string} store_name
 * @param {string} store_name
 * @param {string} mode either "readonly" or "readwrite"
 */
function getObjectStore(db, store_name, mode) {
    const transaction = db.transaction(store_name, mode);
    return transaction.objectStore(store_name);
}

function updateLocalStorageDataset() {
    if (checkConnectionQuality() == true) {
        // set api stuff
        let baseURL = 'https://laptop.dev:8443';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

        // update tables system is online
        getLocalStorageUpdate(baseURL + '/API/users.php'    + '?KEY=' + apiKey, 'user'     );
        getLocalStorageUpdate(baseURL + '/API/workers.php'  + '?KEY=' + apiKey, 'worker'   );
        getLocalStorageUpdate(baseURL + '/API/plaas.php'    + '?KEY=' + apiKey, 'plaas'    );
        getLocalStorageUpdate(baseURL + '/API/spilpunt.php' + '?KEY=' + apiKey, 'spilpunt' );
        getLocalStorageUpdate(baseURL + '/API/gewas.php'    + '?KEY=' + apiKey, 'gewas'    );
        getLocalStorageUpdate(baseURL + '/API/task.php'     + '?KEY=' + apiKey, 'task'     );
        getLocalStorageUpdate(baseURL + '/API/access.php'   + '?KEY=' + apiKey, 'access'   );
        getLocalStorageUpdate(baseURL + '/API/clocklog.php' + '?KEY=' + apiKey, 'clockings');
        getLocalStorageUpdate(baseURL + '/API/worklog.php'  + '?KEY=' + apiKey, 'worklog'  );

        var now = new Date();
        window.localStorage.setItem('db_details', JSON.stringify({ 'version': 1, 'last_update': now }));
    }
}

function updateIndexedDbDataset(dbPromise) {
    if (checkConnectionQuality() == true) {
        // set api stuff
        let baseURL = 'https://laptop.dev:8443';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

        // update tables system is online
        getIndexedDBUpdate(baseURL + '/API/users.php'    + '?KEY=' + apiKey, dbPromise, 'user'     );
        getIndexedDBUpdate(baseURL + '/API/workers.php'  + '?KEY=' + apiKey, dbPromise, 'worker'   );
        getIndexedDBUpdate(baseURL + '/API/plaas.php'    + '?KEY=' + apiKey, dbPromise, 'plaas'    );
        getIndexedDBUpdate(baseURL + '/API/spilpunt.php' + '?KEY=' + apiKey, dbPromise, 'spilpunt' );
        getIndexedDBUpdate(baseURL + '/API/gewas.php'    + '?KEY=' + apiKey, dbPromise, 'gewas'    );
        getIndexedDBUpdate(baseURL + '/API/task.php'     + '?KEY=' + apiKey, dbPromise, 'task'     );
        getIndexedDBUpdate(baseURL + '/API/access.php'   + '?KEY=' + apiKey, dbPromise, 'access'   );
        getIndexedDBUpdate(baseURL + '/API/clocklog.php' + '?KEY=' + apiKey, dbPromise, 'clockings');
        getIndexedDBUpdate(baseURL + '/API/worklog.php'  + '?KEY=' + apiKey, dbPromise, 'worklog'  );

        var now = new Date();
        dbPromise.put('dataset', { 'version': 1, 'last_update': now }, 'db_details');
    }
}

function buildEmptyLocalStorageItems(){
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
    // for db_details
    if (localStorage.getItem('db_details') === null) {
        window.localStorage.setItem('db_details', JSON.stringify({}));
    }
    // for Clockings
    if (localStorage.getItem('clockings') === null) {
        window.localStorage.setItem('clockings', JSON.stringify([]));
    }
}

async function buildEmptyIndexedDbItems(dbPromise){

    const now = new Date();
    
    await dbPromise.put('dataset',JSON.stringify([]), 'user');
    await dbPromise.put('dataset',JSON.stringify([]), 'worker');
    await dbPromise.put('dataset',JSON.stringify([]), 'plaas');
    await dbPromise.put('dataset',JSON.stringify([]), 'spilpunt');
    await dbPromise.put('dataset',JSON.stringify([]), 'gewas');
    await dbPromise.put('dataset',JSON.stringify([]), 'task');
    await dbPromise.put('dataset',JSON.stringify([]), 'access');
    await dbPromise.put('dataset',JSON.stringify([]), 'worklog');
    await dbPromise.put('dataset',JSON.stringify({}), 'db_details');
    await dbPromise.put('dataset',{ 'version': 1, 'last_update': now }, 'db_details');
    await dbPromise.put('dataset',JSON.stringify([]), 'clockings');

    await transaction.complete;

}

// Setup DB if not setup
async function setup() {
    buildEmptyLocalStorageItems();
    updateLocalStorageDataset();
    let dbPromise = await idbOpen('wildeklawer')
    updateIndexedDbDataset(dbPromise);

}

async function updateDB() {
    updateLocalStorageDataset();
    let dbPromise = await idbOpen('wildeklawer');
    updateIndexedDbDataset(dbPromise);
}

async function idbOpen(databaseName){
    let dbPromise = await idb.openDB(databaseName, 1, 
                {   upgrade(db, oldVersion, newVersion, transaction, event) {
                        console.log(`need to upgrade from ${oldVersion} to ${newVersion}`);
                        db.createObjectStore('dataset');
                    }
                ,
                });

    return dbPromise;
}

async function idbGet(dbPromise, store, key) {
    return (await dbPromise).get(store, key);
}

async function idbSet(dbPromise, store, key, val) {
    return (await dbPromise).put(store, val, key);
}

async function idbDel(dbPromise, store, key) {
    return (await dbPromise).delete(store, key);
}

async function idbClear(dbPromise, store) {
    return (await dbPromise).clear(store);
}

async function idbKeys(dbPromise, store) {
    return (await dbPromise).getAllKeys(store);
}

async function updateNotice(classlist){
    let dbPromise = await idbOpen('wildeklawer');

    let old_notice = document.getElementById('notice');
    if (old_notice) {
        old_notice.parentElement.removeChild(old_notice);
    }

    // load offline Clocks
    let clockings = await idbGet(dbPromise, 'dataset','clockingsUP');
    let cLength = 0;
    if (clockings && clockings.length !== 0) {
        cLength = clockings.length;
    }

    // load offline bins
    let bins = await idbGet(dbPromise, 'dataset','worklogUP');
    let bLength = 0;
    if (bins && bins.length !== 0) {
        bLength = bins.length;
    }

    let notice = document.createElement("div");
    notice.id  = 'notice';
    notice.classList.add(classlist);
    notice.innerHTML = '<i class="fas fa-sync-alt"></i> ' + cLength + "/" + bLength;
    notice.addEventListener("click", function(event){
        fSync();
    });

    if (  (bLength > 0)
        || (cLength > 0)
        ) {
        let body = document.body;
        let firstItem = document.body.children[0];
        body.insertBefore(notice, firstItem);
        body.appendChild(notice);
    }
}

function updateAppStatus(status) {
    if (status == 'online') {
        updateNotice("AppOnline");
        
    } else {
        updateNotice("AppOffline");
    }

    const connectionStableEvent = new CustomEvent ( 'connection:stable'
    , { bubbles: true
      , detail: status == 'online' ? true : false
      }
    );
    window.dispatchEvent(connectionStableEvent);

}

function checkConnectionQuality(event_details){

    if (!window.navigator.onLine){
        updateAppStatus('offline');
        return false;
    } else {

        const goodConnection    = ['3g', '4g', '5g', '6g'];
        const connectionType    = navigator.connection.effectiveType;
        const connectionLatency = navigator.connection.rtt;
        const bandwidth = navigator.connection.downlink;
            
        if( (connectionLatency < 500) 
        &&  (goodConnection.includes(connectionType))
        &&  (bandwidth > 0.5)
        ){
            updateAppStatus('online');
            const broadcast = new BroadcastChannel('wildeklawer');
            broadcast.postMessage({ type: 'do-background-sync', });
            return true;

        } else {
            updateAppStatus('offline');
            return false;
        }
    }
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

// PWA Status change listener (Lost Connection go Offline)
window.addEventListener('offline', checkConnectionQuality);
window.addEventListener('online', checkConnectionQuality);
window.addEventListener('sync:done', function(event){
    console.log("Sync:Done Received");
    checkConnectionQuality();
});
window.navigator.connection.addEventListener("change", checkConnectionQuality);

checkConnectionQuality(); //on first run check connection quality
//setup();

const broadcastListener = new BroadcastChannel('wildeklawer');
broadcastListener.onmessage = (event) => {
    if (event.data && event.data.type === 'background-sync-done') {
        console.log('background-sync-done');
        updateNotice("AppOnline");
    }
    else if (event.data && event.data.type === 'background-sync-not-done') {
        console.log('background-sync-not-done');
        updateNotice("AppOffline");
    }
};
