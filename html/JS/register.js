$(async function () {
    let form = $(".registerFrom");
    form.append(
        '<button  type="button" name="register" onclick="registerClient()" style="margin-top:10px;margin-bottom:30px;">Registreer</button>'
    );
});


function registerClient(){
    if (window.navigator.onLine) {

        let uuid = document.getElementById("uuid");
        let naam = document.getElementById("naam");

        // set api stuff
        let baseURL = 'https://laptop.dev:8443';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';
        let url = baseURL + '/API/client.php' + '?KEY=' + apiKey
        
        let postData  = ('&uid=' + uuid.value);
            postData += ('&naam=' + naam.value);
            postData += ('&kdatum=' + new Date().toJSON().split('T').join(" ").slice(0,19));

        // send register request
        let xhttpCalls = new XMLHttpRequest();
        xhttpCalls.onreadystatechange = async function () {
            let dbPromise = await idb.openDB('wildeklawer');
            await dbPromise.put('dataset',uuid.value,'client_id');
            window.location.replace("index.html");
            return;
        }

        xhttpCalls.open("POST", url, true);
        xhttpCalls.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttpCalls.timeout = 60000;
        changes = true;
        xhttpCalls.send(postData);
    }
}
