var db;
var db_name = 'wildeklawerDB';
// until we won't need this prefix mess
var indexedDB = window.indexedDB || window.webkitIndexedDB
    || window.mozIndexedDB || window.msIndexedDB;
var IDBTransaction = window.IDBTransaction ||
    window.webkitIDBTransaction;

// The initialization of our stuff
function init() {
    var dbVersion = 1.0;
    var openRequest = indexedDB.open(db_name, dbVersion);

    //handle setup - as the spec like it
    openRequest.onupgradeneeded = function (e) {
        console.log("running onupgradeneeded");
        // put code to upgrade db in the wild
        var thisDb = e.target.result;
        db = thisDb;

        // -----------------------------------------------------------------------------
        // READ TABLES BELOW !!
        // -----------------------------------------------------------------------------

        //Create Users
        if (!thisDb.objectStoreNames.contains("users")) {
            var objectStore = thisDb.createObjectStore("users", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("van", "van", { unique: false });
            objectStore.createIndex("CN", "CN", { unique: false });
            objectStore.createIndex("pwd", "pwd", { unique: false });
            objectStore.createIndex("farm_id", "farm_id", { unique: false });
            objectStore.createIndex("accesslevel", "accesslevel", { unique: false });
        }

        //Create Workers
        if (!thisDb.objectStoreNames.contains("workers")) {
            var objectStore = thisDb.createObjectStore("workers", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("van", "van", { unique: false });
            objectStore.createIndex("CN", "CN", { unique: false });
            objectStore.createIndex("pwd", "pwd", { unique: false });
            objectStore.createIndex("farm_id", "farm_id", { unique: false });
            objectStore.createIndex("accesslevel", "accesslevel", { unique: false });
        }

        //Create Plaas
        if (!thisDb.objectStoreNames.contains("plaas")) {
            var objectStore = thisDb.createObjectStore("plaas", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("afkorting", "afkorting", { unique: false });
        }

        //Create Spilpunt
        if (!thisDb.objectStoreNames.contains("spilpunt")) {
            var objectStore = thisDb.createObjectStore("spilpunt", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("afkorting", "afkorting", { unique: false });
            objectStore.createIndex("farm_id", "farm_id", { unique: false });
        }

        //Create Gewas
        if (!thisDb.objectStoreNames.contains("gewas")) {
            var objectStore = thisDb.createObjectStore("gewas", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("afkorting", "afkorting", { unique: false });
        }

        //Create Task
        if (!thisDb.objectStoreNames.contains("task")) {
            var objectStore = thisDb.createObjectStore("task", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("afkorting", "afkorting", { unique: false });
        }

        //Create Access
        if (!thisDb.objectStoreNames.contains("access")) {
            var objectStore = thisDb.createObjectStore("access", { keyPath: "id", unique: true });
            objectStore.createIndex("naam", "naam", { unique: false });
            objectStore.createIndex("beskrywing", "beskrywing", { unique: false });
        }

        // -----------------------------------------------------------------------------
        // WRITE TABLES BELOW !!
        // -----------------------------------------------------------------------------

        //Create ClockLog
        if (!thisDb.objectStoreNames.contains("clocklog")) {
            var objectStore = thisDb.createObjectStore("clocklog", { keyPath: "id", autoIncrement: true });
            objectStore.createIndex("user_id", "user_id", { unique: false });
            objectStore.createIndex("worker_id", "worker_id", { unique: false });
            objectStore.createIndex("task_id", "task_id", { unique: false });
            objectStore.createIndex("farm_id", "farm_id", { unique: false });
            objectStore.createIndex("spry_id", "spry_id", { unique: false });
            objectStore.createIndex("clockType", "clockType", { unique: false });
            objectStore.createIndex("logDate", "logDate", { unique: false });
            objectStore.createIndex("logTime", "logTime", { unique: false });
        }

        //Create WorkLog
        if (!thisDb.objectStoreNames.contains("worklog")) {
            var objectStore = thisDb.createObjectStore("worklog", { keyPath: "id", autoIncrement: true });
            objectStore.createIndex("user_id", "user_id", { unique: false });
            objectStore.createIndex("worker_id", "worker_id", { unique: false });
            objectStore.createIndex("farm_id", "farm_id", { unique: false });
            objectStore.createIndex("produce_id", "produce_id", { unique: false });
            objectStore.createIndex("spry_id", "spry_id", { unique: false });
            objectStore.createIndex("task_id", "task_id", { unique: false });
            objectStore.createIndex("crates", "crates", { unique: false });
            objectStore.createIndex("logDate", "logDate", { unique: false });
            objectStore.createIndex("logTime", "logTime", { unique: false });
        }

    }

    // -----------------------------------------------------------------------------
    // OPEN DB FOR APPLICATION !!
    // -----------------------------------------------------------------------------
    openRequest.onsuccess = function (e) {
        db = e.target.result;
        db.onerror = function (event) {
            // Generic error handler for all 
            // errors targeted at this database
            alert("Database error: " + event.target.errorCode);
            console.dir(event.target);
        };
    }

}


// -----------------------------------------------------------------------------
// INSERT DATA TO TABLE
// -----------------------------------------------------------------------------
function dbInsert(table, data) {
    var transaction = db.transaction([table], "readwrite");

    var objectStore = transaction.objectStore(table);
    var request = objectStore.add(data);

    // transaction.oncomplete = function (event) {
    //     // console.log("All done!");
    // };

    // transaction.onerror = function (event) {
    //     // console.dir(event);
    // };

    // request.onsuccess = function (event) {
    //     // console.log("done with insert");
    // };
}


// -----------------------------------------------------------------------------
// Update DATA TO TABLE
// -----------------------------------------------------------------------------
function dbUpdate(table, data) {
    var transaction = db.transaction([table], "readwrite");

    var objectStore = transaction.objectStore(table);
    var request = objectStore.put(data);

    // transaction.oncomplete = function (event) {
    //     // console.log("All done!");
    // };

    // transaction.onerror = function (event) {
    //     // console.dir(event);
    // };

    // request.onsuccess = function (event) {
    //     // console.log("done with update");
    // };
}


// -----------------------------------------------------------------------------
// GET DATA FROM TABLE
// -----------------------------------------------------------------------------
function dbQuery(table, strID) {
    var transaction = db.transaction([table], "readwrite");
    var objectStore = transaction.objectStore(table);
    var dbData = '';

    objectStore.getAll().onsuccess = function (event) {
        dbData = event.target.result;
        results(dbData, strID);
    }

    // transaction.oncomplete = function (event) {
    //     // console.log("All done!");
    // };

    // transaction.onerror = function (event) {
    //     // console.dir(event);
    // };
}

// -----------------------------------------------------------------------------
// Sync DATA FROM API (Write Example)
// -----------------------------------------------------------------------------
function syncDB() {
    if (db) {
        dbUpdate("task", {
            id: 4,
            naam: "Saai",
            afkorting: "S"
        });

    } else {
        // DB not ready sleep for a while..
        setTimeout(() => { syncDB(); }, 2000);
    }
}
syncDB();


// -----------------------------------------------------------------------------
// Get DATA FROM DB Read Example
// -----------------------------------------------------------------------------
function readDB() {
    if (db) {
        // QUERY IS ASYNC
        dbQuery("task", "taskResult");
    } else {
        // DB not ready sleep for a while..
        setTimeout(() => { readDB(); }, 2000);
    }
}
readDB();


var resultData = [];
function results(data, resultId) {
    resultData[resultId] = data;
    console.log(resultData[resultId][2]["naam"]);
}