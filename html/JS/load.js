$(async function () {

    //Check indexDB for Client key
    let dbPromise = await idb.openDB('wildeklawer');
      
    let client_id = await dbPromise.get('dataset','client_id');
    
    if (client_id) {
        var loginSection = document.getElementById("login");
        //  show login section
        loginSection.style.display="block";
        var offlineSection = document.getElementById("offline");
            offlineSection.style.display="none";   
    } else {
        if (window.navigator.onLine) {
            var offlineSection = document.getElementById("offline");
            offlineSection.style.display="none";    
        // generate a new key 
        let gen_uuid = uuidv4();

        // Set the inputs with key
        var uuid = document.getElementById("uuid");
        uuid.value = gen_uuid;
        // show the register section
        var registerSection = document.getElementById("register");
        registerSection.style.display="block";
        }
    }

});

