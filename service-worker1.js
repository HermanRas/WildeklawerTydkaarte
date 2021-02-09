// give your cache a name
const cacheName = 'my-cache';

// put the static assets and routes you want to cache here
const filesToCache = [
    '/WEB_DEV/DevTest/PWA-DynamicTest/',
    '/WEB_DEV/DevTest/PWA-DynamicTest/index.html',
    '/WEB_DEV/DevTest/PWA-DynamicTest/indexOffline.html',
    '/WEB_DEV/DevTest/PWA-DynamicTest/js/service-worker-install.js',
    '/WEB_DEV/DevTest/PWA-DynamicTest/js/service-worker.js',
];


// the event handler for the activate event
self.addEventListener('activate', e => self.clients.claim());

// the event handler for the install event 
// typically used to cache assets
self.addEventListener('install', e => {
    e.waitUntil(
        caches.open(cacheName)
            .then(cache => cache.addAll(filesToCache))
    );
    console.log('PWA: Cashed Files');
});

// the fetch event handler, to intercept requests and serve all 
// static assets from the cache
self.addEventListener('fetch', e => {
    e.respondWith(
        caches.match(e.request)
            .then(response => response ? response : fetch(e.request))
    );
    console.log('PWA: Request received for:', e.request);
});