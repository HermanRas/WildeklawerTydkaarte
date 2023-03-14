function swCheckConnectionQuality(event_details){

    if (!navigator.onLine){
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
            return true;

        } else {
            return false;
        }
    }
}


async function swPostDBUpdate(URL, dataset){
    let postData = ''
    let i = 0;
    dataset.forEach(row => {
        for (const [key, value] of Object.entries(row)) {
            postData += ('&' + key + '[]=' + value);
        }
    });

    const requestOptions = {
        method: 'POST',
        headers: { 'Content-type': 'application/x-www-form-urlencoded' },
        body: postData
    };
    
    //console.dir({'SW_postDBUpdate': {'requestOptions': requestOptions}});

    try {
        const response = await fetch(URL, requestOptions);

        console.dir({'SW_postDBUpdate': {'response': response}});
        return true;
    } catch (error) {
        console.error(error);
        console.dir({'SW_postDBUpdate': {"error": error}});
        return false;
    }

}


///////////////////////////////////////////////////////////////////////////
// BACKGROUND SYNC CODE         https://github.com/WICG/background-sync/blob/main/explainers/sync-explainer.md
///////////////////////////////////////////////////////////////////////////
self.addEventListener('sync', function (event) {
    if (event.tag == 'OneOffSync') {
        //console.dir({"SW_sync": "OneOffSync received"});
        event.waitUntil(swDoDBSync());
    }
});

self.addEventListener('periodicsync', function(event) {
    if (event.registration.tag == 'PeriodicSync') {
        //console.dir({"SW_periodicsync": "PeriodicSync received"});
        event.waitUntil(swDoDBSync());
    } else {
      // unknown sync, may be old, best to unregister
      event.registration.unregister();
    }
});


async function swDoDBSync() {
    //console.dir({"SW_doDBSync": "started"});
    const syncBroadcast = new BroadcastChannel('wildeklawer');

    if (swCheckConnectionQuality() == true) {

        const DB_NAME       = 'wildeklawer';
        const DB_STORE_NAME = 'dataset';
        const DB_VERSION    = 1; 
        const BASE_URL      = 'https://laptop.dev:8443';
        const API_KEY       = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

        let open_req = indexedDB.open(DB_NAME, DB_VERSION);
        let db;

        open_req.onsuccess = function (open_event) {
            
            db = open_event.target.result;

            let transaction  = db.transaction(DB_STORE_NAME, 'readwrite');
            let objectStore  = transaction.objectStore(DB_STORE_NAME);
            let worklog_req  = objectStore.get('worklogUP');
            let clocklog_req = objectStore.get('clockingsUP');
            

            worklog_req.onsuccess = function (evt) {
                let worklogs = evt.target.result;
                
                if (worklogs && worklogs.length !== 0) {
                    if(swPostDBUpdate(BASE_URL + '/API/workUp.php' + '?KEY=' + API_KEY, worklogs)){
                        objectStore.put([],'worklogUP');
                        syncBroadcast.postMessage({ type: 'background-sync-done', });
                    } else {
                        syncBroadcast.postMessage({ type: 'background-sync-not-done', });
                    }
                }

            }

            worklog_req.onerror = function (evt) {
                console.error("get worklogUP:", evt.target.errorCode);
            }

            clocklog_req.onsuccess = function (evt) {
                let clocklogs = evt.target.result;
                
                if (clocklogs && clocklogs.length !== 0) {
                    if(swPostDBUpdate(BASE_URL + '/API/clockUp.php' + '?KEY=' + API_KEY, clocklogs)){
                        objectStore.put([],'clockingsUP');
                        syncBroadcast.postMessage({ type: 'background-sync-done', });
                    } else {
                        syncBroadcast.postMessage({ type: 'background-sync-not-done', });
                    }
                }

            }

            clocklog_req.onerror = function (evt) {
                console.error("get clockingsUP:", evt.target.errorCode);
            }

            try {
                db.close();
            } catch(error) {
                console.error(error);
            }

        };

        open_req.onerror = function (event) {
            console.error("openDb:", event.target.errorCode);
        };

        open_req.onupgradeneeded = function (event) {
            //console.log("openDb.onupgradeneeded");
            var store = event.currentTarget.result.createObjectStore(DB_STORE_NAME);
        };
    
    } else {
        syncBroadcast.postMessage({ type: 'background-sync-not-done', });
    }

    //console.dir({"SW_doDBSync": "completed"});
}


///////////////////////////////////////////////////////////////////////////
// OFFLINE PWA CODE
///////////////////////////////////////////////////////////////////////////
// Incrementing OFFLINE_VERSION will kick off the install event and force
// previously cached resources to be updated from the network.
const OFFLINE_VERSION = 9;
const CACHE_NAME = 'offline';

// Customize offline page for any url not in cache
const OFFLINE_URL = '/indexOffline.html';
// list of urls to cache
const filesToCache = [
    // STATIC PAGES
    // '/favicon.ico',
    // '/',
    // '/_footer.html',
    // '/_header.html',
    // '/_nav.html',
    // '/_home.html',
    OFFLINE_URL,
    '/home.html',
    '/index.html',
    '/site_Privacy.html',
    '/site_Terms.html',
    '/user_InputBadge.html',
    '/user_InputClock.html',
    '/user_InputData.html',
    '/user_InputSelect.html',

    // // CSS
    '/CSS/app.css',
    '/CSS/login.css',
    '/CSS/bootstrap.min.css',

    // // JS Scripts
    '/JS/bootstrap.bundle.min.js',
    '/JS/clientAction.js',
    '/JS/destAction.js',
    '/JS/farmAction.js',
    '/JS/jquery-3.6.0.min.js',
    '/JS/login.js',
    '/JS/produceAction.js',
    '/JS/qr-code.min.js',
    '/JS/html5-qrcode.min.js',
    '/JS/spryAction.js',
    '/JS/sweetalert2.10.js',
    '/JS/taskAction.js',
    '/JS/userAction.js',
    '/JS/workerAction.js',
    '/JS/idb.min.js',
    '/JS/uuidv4.min.js',
    '/JS/uuidv5.min.js',
    '/JS/register.js',
    '/JS/load.js',

    // // JS APP
    '/App/app.js',
    '/App/dbAPI.js',
    '/App/navAdmin.js',
    '/App/backgroundSync.js',
    '/App/user_InputClock.js',
    '/App/user_InputData.js',

    // // // Images
    // '/Img/admin.png',
    // '/Img/bins.png',
    // '/Img/Bulk_klok.png',
    // '/Img/details_close.png',
    // '/Img/details_open.png',
    '/Img/favicon.png',
    '/Img/icon-192x192.png',
    '/Img/icon-256x256.png',
    '/Img/icon-384x384.png',
    '/Img/icon-512x512.png',
    // '/Img/icon.ico',
    // '/Img/icon.jpeg',
    // '/Img/invoere.png',
    // '/Img/klok.png',
    // '/Img/splash.jpg',
    // '/Img/teken_uit.png',
    // '/Img/tuis.png',
    // '/Img/verslae.png',
    // '/Img/Wildeklawer-logo.png',
    // '/Img/WKLogo_Full.jpeg',
];

self.addEventListener('install', (event) => {
    // Load Offline Error Page for uncashed php pages
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);
        await cache.add(new Request(OFFLINE_URL, { cache: 'reload' }));
    })());

    // Load Offline cash for PWA
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);
        filesToCache.forEach(async function(file){
            try {
                await cache.add(new Request(file));
            } catch (error) {
                console.error(error);
                console.dir(error);
            }
            
        })
        
    })());
});

self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        // Enable navigation preload if it's supported.
        // See https://developers.google.com/web/updates/2017/02/navigation-preload
        if ('navigationPreload' in self.registration) {
            await self.registration.navigationPreload.enable();
        }
    })());
    // Tell the active service worker to take control of the page immediately.
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // We only want to call event.respondWith() if this is a navigation request
    event.respondWith((async () => {
        try {
            // First, try to use the network preload response if it's supported.
            const preloadResponse = await event.preloadResponse;
            if (preloadResponse) {
                return preloadResponse;
            }
            const networkResponse = await fetch(event.request);
            return networkResponse;
        } catch (error) {
            // the 4xx or 5xx range, the catch() will NOT be called.
            // load cache
            const cache = await caches.open(CACHE_NAME);
            // load standard reponse for anything not in cache
            const offlineResponse = await cache.match(OFFLINE_URL);
            // load if url is cached
            const eventRequest = await cache.match(event.request.url, {
                ignoreSearch: true,
                ignoreMethod: true,
                ignoreVary: true
            });
            // check to see if we send offline or cache
            if (eventRequest) {
                cachedResponse = eventRequest;
            } else {
                cachedResponse = offlineResponse;
            }
            // send response
            return cachedResponse;
        }
    })());
});

function clearCash(CACHE_NAME) {
    caches.delete(CACHE_NAME);
    alert('Offline Data Cleared');
}

const swBroadcast = new BroadcastChannel('wildeklawer');

swBroadcast.onmessage = (event) => {
    if (event.data && event.data.type === 'do-background-sync') {
      swDoDBSync();
    }
};