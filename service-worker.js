importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.1.1/workbox-sw.js');

// NETWORK API
workbox.routing.registerRoute(
    ({ url }) => url.pathname.startsWith('/web_dev/Projects/WildeklawerTydkaarte/API'),
    new workbox.strategies.NetworkOnly()
);

// CASH CSS
workbox.routing.registerRoute(
    ({ url }) => url.pathname.startsWith('/web_dev/Projects/WildeklawerTydkaarte/CSS'),
    new workbox.strategies.CacheFirst()
);

// CASH JS
workbox.routing.registerRoute(
    ({ url }) => url.pathname.startsWith('/web_dev/Projects/WildeklawerTydkaarte/JS'),
    new workbox.strategies.CacheFirst()
);

// CASH JS
workbox.routing.registerRoute(
    new RegExp('\\.html$'),
    new workbox.strategies.CacheFirst()
);

// CASH App
workbox.routing.registerRoute(
    ({ url }) => url.pathname.startsWith('/web_dev/Projects/WildeklawerTydkaarte/App'),
    new workbox.strategies.CacheFirst()
);