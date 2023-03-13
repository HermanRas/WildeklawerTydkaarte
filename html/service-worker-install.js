// Register Service Worker
if ('serviceWorker' in navigator) {
    let registration;
    const registerServiceWorker = async () => {
        registration = await navigator.serviceWorker.register('service-worker.js');
    };
    registerServiceWorker();
}

// Setup Service Worker
navigator.serviceWorker.ready.then(async function(registration) {
    await registration.sync.register('OneOffSync');
});

navigator.serviceWorker.ready.then(async function(registration) {
    await registration.periodicSync.register({ tag:          'PeriodicSync'
                                            ,  minPeriod:    15 * 60 * 1000   // 15 minutes
                                            ,  powerState:   'auto'           // alternative: 'avoid-draining'
                                            ,  networkState: 'online'         // alternative: 'avoid-cellular'
                                            });
  });