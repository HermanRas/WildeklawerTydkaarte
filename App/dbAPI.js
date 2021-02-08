function getDBUpdate(URL, table) {
    var xhttpOldCalls = new XMLHttpRequest();
    xhttpOldCalls.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            let response = xhttpOldCalls.responseText;
            window.localStorage.setItem(table, response);
        } else {
            if (this.readyState == 4) {
                let err = {
                    'URL': URL,
                    'table': table,
                    'page': this.readyState,
                    'status': this.status,
                    'data': xhttpOldCalls.responseText,
                };
                console.log('Error', err);
            }
        }
    };
    xhttpOldCalls.open("GET", URL, true);
    xhttpOldCalls.send();
}