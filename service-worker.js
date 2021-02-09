// Incrementing OFFLINE_VERSION will kick off the install event and force
// previously cached resources to be updated from the network.
const OFFLINE_VERSION = 1;
const CACHE_NAME = 'offline';

// Customize offline page for any url not in cache
const OFFLINE_URL = '/web_dev/Projects/WildeklawerTydkaarte/indexOffline.html';
// list of urls to cache
const filesToCache = [
    '/web_dev/Projects/WildeklawerTydkaarte/',
    '/web_dev/Projects/WildeklawerTydkaarte/CSS/app.css',
    '/web_dev/Projects/WildeklawerTydkaarte/CSS/login.css',
    '/web_dev/Projects/WildeklawerTydkaarte/CSS/bootstrap.min.css',
    '/web_dev/Projects/WildeklawerTydkaarte/site_Privacy.html',
    '/web_dev/Projects/WildeklawerTydkaarte/site_Terms.html',
    '/web_dev/Projects/WildeklawerTydkaarte/js/bootstrap.bundle.min.js',
    '/web_dev/Projects/WildeklawerTydkaarte/Img/icon-192x192.png'
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
    if (event.request.mode === 'navigate') {
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
                const eventRequest = await cache.match(event.request.url);
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
    }
});