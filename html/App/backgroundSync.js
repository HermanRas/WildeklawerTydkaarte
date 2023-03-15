function doDBSync() {
    // if we're online
    if (checkConnectionQuality() == true) {
        const broadcast = new BroadcastChannel('wildeklawer');
        broadcast.postMessage({ type: 'do-background-sync', });
    }
}
doDBSync();

function fSync() {
    // if we online
    if (checkConnectionQuality() == true) {
        const broadcast = new BroadcastChannel('wildeklawer');
        broadcast.postMessage({ type: 'do-background-sync', });
    }
}
