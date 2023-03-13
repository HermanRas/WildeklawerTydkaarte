function doDBSync() {
    console.log("DB Sync Called");
    // if we're online
    if (checkConnectionQuality() == true) {
        const broadcast = new BroadcastChannel('wildeklawer');
        broadcast.postMessage({ type: 'do-background-sync', });
    }
}
doDBSync();

function fSync() {
    console.log("Force Sync Called");
    // if we online
    if (checkConnectionQuality() == true) {
        const broadcast = new BroadcastChannel('wildeklawer');
        broadcast.postMessage({ type: 'do-background-sync', });
    }
}
