var db;
// until we won't need this prefix mess
var indexedDB = window.indexedDB || window.webkitIndexedDB
    || window.mozIndexedDB || window.msIndexedDB;
var IDBTransaction = window.IDBTransaction ||
    window.webkitIDBTransaction;

// The initialization of our stuff
function init() {
    var dbVersion = 1.0;
    var openRequest = indexedDB.open("notesDB", dbVersion);

    //handle setup - as the spec like it
    openRequest.onupgradeneeded = function (e) {
        console.log("running onupgradeneeded");
        var thisDb = e.target.result;

        //temp delete if we want to start clean ->
        //thisDb.deleteObjectStore("note");

        //Create Note
        if (!thisDb.objectStoreNames.contains("note")) {
            console.log("I need to make the note objectstore");
            var objectStore = thisDb.createObjectStore("note",
                { keyPath: "id", autoIncrement: true });
            objectStore.createIndex("title", "title",
                { unique: false });
        }
    }

    openRequest.onsuccess = function (e) {
        db = e.target.result;
        db.onerror = function (event) {
            // Generic error handler for all 
            // errors targeted at this database
            alert("Database error: " + event.target.errorCode);
            console.dir(event.target);
        };
        // Interim solution for Chrome to create an objectStore.
        // Will be deprecated once it's fixed.
        if (db.setVersion) {
            console.log("in old setVersion: " + db.setVersion);
            if (db.version != dbVersion) {
                var req = db.setVersion(dbVersion);
                req.onsuccess = function () {
                    var ob = db.createObjectStore("note",
                        { keyPath: "id", autoIncrement: true });
                    ob.createIndex("title",
                        "title", { unique: false });
                    var trans = req.result;
                    trans.oncomplete = function (e) {
                        console.log("== trans oncomplete ==");
                        displayNotes();
                    }
                };
            }
            else {
                displayNotes();
            }
        }
        else {
            displayNotes();
        }
    }

    function displayNotes() {
        console.log("TODO - print something nice on the page");
        var transaction = db.transaction(["note"], "readwrite");
        var objectStore = transaction.objectStore("note");
        var resultsDiv = document.querySelector("#results");
        var dbData = '';

        objectStore.openCursor().onsuccess = function (event) {
            var cursor = event.target.result;
            if (cursor) {
                dbData = dbData + ("<br>Name for SSN " + cursor.key + " is " + JSON.stringify(cursor.value));
                cursor.continue();
            }
            else {
                console.log("No more entries!");
            }
            resultsDiv.innerHTML = dbData;
        };
    }

    //TEMP TO REMOVE
    document.querySelector("#test").addEventListener("click", function () {
        var transaction = db.transaction(["note"], "readwrite");
        transaction.oncomplete = function (event) {
            console.log("All done!");
        };

        transaction.onerror = function (event) {
            // Don't forget to handle errors!
            console.dir(event);
        };

        var objectStore = transaction.objectStore("note");
        //use put versus add to always write, even if exists
        var request = objectStore.add({
            title: "note 1",
            body: "this is the body " +
                Math.floor(Math.random() * 1000)
        });

        request.onsuccess = function (event) {
            console.log("done with insert");
            displayNotes();
        };

        objectStore.openCursor().onsuccess = function (event) {
            var cursor = event.target.result;
            if (cursor) {
                console.log(cursor.key);
                console.dir(cursor.value);
                cursor.continue();
            }
            else {
                console.log("Done with cursor");
            }
        };

    });
}
