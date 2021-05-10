// Register Service Worker
if ('serviceWorker' in navigator) {
    let registration;
    const registerServiceWorker = async () => {
        registration = await navigator.serviceWorker.register('service-worker.js');
    };
    registerServiceWorker();
}

// Setup Service Worker
navigator.serviceWorker.ready.then(function (swRegistration) {
    return swRegistration.sync.register('DBSync');
});