///////////////////////////////////////////////////////////////////////////
// BACKGROUND SYNC CODE
///////////////////////////////////////////////////////////////////////////
self.addEventListener('sync', function (event) {
    if (event.tag == 'DBSync') {
        event.waitUntil(doDBSync());
    }
});

async function doDBSync() {
    // 
}


///////////////////////////////////////////////////////////////////////////
// OFFLINE PWA CODE
///////////////////////////////////////////////////////////////////////////
// Incrementing OFFLINE_VERSION will kick off the install event and force
// previously cached resources to be updated from the network.
const OFFLINE_VERSION = 8;
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
    // '/home.html',
    // '/index.html',
    // '/site_Privacy.html',
    // '/site_Terms.html',
    // '/user_InputBadge.html',
    // '/user_InputClock.html',
    // '/user_InputData.html',
    // '/user_InputSelect.html',

    // // CSS
    // '/CSS/app.css',
    // '/CSS/login.css',
    // '/CSS/bootstrap.min.css',

    // // JS Scripts
    // '/JS/bootstrap.bundle.min.js',
    // '/JS/destAction.js',
    // '/JS/farmAction.js',
    // '/JS/jquery-3.6.0.min.js',
    // '/JS/login.js',
    // '/JS/produceAction.js',
    // '/JS/qr-code.min.js',
    // '/JS/html5-qrcode.min.js',
    // '/JS/spryAction.js',
    // '/JS/sweetalert2.10.js',
    // '/JS/taskAction.js',
    // '/JS/userAction.js',
    // '/JS/workerAction.js',

    // // JS APP
    // '/App/app.js',
    // '/App/dbAPI.js',
    // '/App/navAdmin.js',
    // '/App/backgroundSync.js',
    // '/App/user_InputClock.js',
    // '/App/user_InputData.js',

    // // // Images
    // '/Img/admin.png',
    // '/Img/bins.png',
    // '/Img/Bulk_klok.png',
    // '/Img/details_close.png',
    // '/Img/details_open.png',
    // '/Img/favicon.png',
    // '/Img/icon-192x192.png',
    // '/Img/icon-256x256.png',
    // '/Img/icon-384x384.png',
    // '/Img/icon-512x512.png',
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
        await cache.addAll(filesToCache);
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
