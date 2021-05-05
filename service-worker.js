// Incrementing OFFLINE_VERSION will kick off the install event and force
// previously cached resources to be updated from the network.
const OFFLINE_VERSION = 1;
const CACHE_NAME = 'offline';

// Customize offline page for any url not in cache
const OFFLINE_URL = '/web_dev/Projects/WildeklawerTydkaarte/indexOffline.html';
// list of urls to cache
const filesToCache = [
    // STATIC PAGES
    '/favicon.ico',
    '/web_dev/Projects/WildeklawerTydkaarte/',
    '/web_dev/Projects/WildeklawerTydkaarte/_footer.html',
    '/web_dev/Projects/WildeklawerTydkaarte/_header.html',
    '/web_dev/Projects/WildeklawerTydkaarte/_nav.html',
    '/web_dev/Projects/WildeklawerTydkaarte/home.html',
    '/web_dev/Projects/WildeklawerTydkaarte/index.html',
    '/web_dev/Projects/WildeklawerTydkaarte/site_Privacy.html',
    '/web_dev/Projects/WildeklawerTydkaarte/site_Terms.html',
    '/web_dev/Projects/WildeklawerTydkaarte/user_InputBadge.html',
    '/web_dev/Projects/WildeklawerTydkaarte/user_InputClock.html',
    '/web_dev/Projects/WildeklawerTydkaarte/user_InputData.html',
    '/web_dev/Projects/WildeklawerTydkaarte/user_InputSelect.html',

    // CSS
    '/web_dev/Projects/WildeklawerTydkaarte/CSS/app.css',
    '/web_dev/Projects/WildeklawerTydkaarte/CSS/login.css',
    '/web_dev/Projects/WildeklawerTydkaarte/CSS/bootstrap.min.css',

    // JS Scripts
    '/web_dev/Projects/WildeklawerTydkaarte/JS/bootstrap.bundle.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/destAction.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/farmAction.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/jquery-3.6.0.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/jquery-qrcode-0.18.0.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/login.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/produceAction.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/qr-code.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/qr-scanner-worker.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/qr-scanner.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/spryAction.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/sweetalert2.10.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/taskAction.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/userAction.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/webcam.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/JS/workerAction.js',

    // JS APP
    '/web_dev/Projects/WildeklawerTydkaarte/App/app.js',
    '/web_dev/Projects/WildeklawerTydkaarte/App/dbAPI.js',
    '/web_dev/Projects/WildeklawerTydkaarte/App/navAdmin.js',
    '/web_dev/Projects/WildeklawerTydkaarte/App/user_InputClock.js',
    '/web_dev/Projects/WildeklawerTydkaarte/App/user_InputData.js',

    // // Images
    '/web_dev/Projects/WildeklawerTydkaarte/Img/admin.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/bins.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/Bulk_klok.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/details_close.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/details_open.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/favicon.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon-192x192.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon-256x256.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon-384x384.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon-512x512.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon.ico',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon.jpeg',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/invoere.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/klok.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/splash.jpg',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/teken_uit.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/tuis.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/verslae.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/Wildeklawer-logo.png',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/WKLogo_Full.jpeg',
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
