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
const OFFLINE_VERSION = 7;
const CACHE_NAME = 'offline';

// Customize offline page for any url not in cache
const OFFLINE_URL = '/WildeklawerTydkaarte/indexOffline.html';
// list of urls to cache
const filesToCache = [
    // STATIC PAGES
    '/favicon.ico',
    '/WildeklawerTydkaarte/',
    '/WildeklawerTydkaarte/_footer.html',
    '/WildeklawerTydkaarte/_header.html',
    '/WildeklawerTydkaarte/_nav.html',
    '/WildeklawerTydkaarte/home.html',
    '/WildeklawerTydkaarte/index.html',
    '/WildeklawerTydkaarte/site_Privacy.html',
    '/WildeklawerTydkaarte/site_Terms.html',
    '/WildeklawerTydkaarte/user_InputBadge.html',
    '/WildeklawerTydkaarte/user_InputClock.html',
    '/WildeklawerTydkaarte/user_InputData.html',
    '/WildeklawerTydkaarte/user_InputSelect.html',

    // CSS
    '/WildeklawerTydkaarte/CSS/app.css',
    '/WildeklawerTydkaarte/CSS/login.css',
    '/WildeklawerTydkaarte/CSS/bootstrap.min.css',

    // JS Scripts
    '/WildeklawerTydkaarte/JS/bootstrap.bundle.min.js',
    '/WildeklawerTydkaarte/JS/destAction.js',
    '/WildeklawerTydkaarte/JS/farmAction.js',
    '/WildeklawerTydkaarte/JS/jquery-3.6.0.min.js',
    '/WildeklawerTydkaarte/JS/login.js',
    '/WildeklawerTydkaarte/JS/produceAction.js',
    '/WildeklawerTydkaarte/JS/qr-code.min.js',
    '/WildeklawerTydkaarte/JS/html5-qrcode.min.js',
    '/WildeklawerTydkaarte/JS/spryAction.js',
    '/WildeklawerTydkaarte/JS/sweetalert2.10.js',
    '/WildeklawerTydkaarte/JS/taskAction.js',
    '/WildeklawerTydkaarte/JS/userAction.js',
    '/WildeklawerTydkaarte/JS/workerAction.js',

    // JS APP
    '/WildeklawerTydkaarte/App/app.js',
    '/WildeklawerTydkaarte/App/dbAPI.js',
    '/WildeklawerTydkaarte/App/navAdmin.js',
    '/WildeklawerTydkaarte/App/backgroundSync.js',
    '/WildeklawerTydkaarte/App/user_InputClock.js',
    '/WildeklawerTydkaarte/App/user_InputData.js',

    // // Images
    '/WildeklawerTydkaarte/Img/admin.png',
    '/WildeklawerTydkaarte/Img/bins.png',
    '/WildeklawerTydkaarte/Img/Bulk_klok.png',
    '/WildeklawerTydkaarte/Img/details_close.png',
    '/WildeklawerTydkaarte/Img/details_open.png',
    '/WildeklawerTydkaarte/Img/favicon.png',
    '/WildeklawerTydkaarte/Img/icon-192x192.png',
    '/WildeklawerTydkaarte/Img/icon-256x256.png',
    '/WildeklawerTydkaarte/Img/icon-384x384.png',
    '/WildeklawerTydkaarte/Img/icon-512x512.png',
    '/WildeklawerTydkaarte/Img/icon.ico',
    '/WildeklawerTydkaarte/Img/icon.jpeg',
    '/WildeklawerTydkaarte/Img/invoere.png',
    '/WildeklawerTydkaarte/Img/klok.png',
    '/WildeklawerTydkaarte/Img/splash.jpg',
    '/WildeklawerTydkaarte/Img/teken_uit.png',
    '/WildeklawerTydkaarte/Img/tuis.png',
    '/WildeklawerTydkaarte/Img/verslae.png',
    '/WildeklawerTydkaarte/Img/Wildeklawer-logo.png',
    '/WildeklawerTydkaarte/Img/WKLogo_Full.jpeg',
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
