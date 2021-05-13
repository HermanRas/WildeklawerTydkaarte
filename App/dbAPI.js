function getDBUpdate(URL, table) {
    var xhttpCalls = new XMLHttpRequest();
    xhttpCalls.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            let response = xhttpCalls.responseText;
            window.localStorage.setItem(table, response);
        } else {
            if (this.readyState == 4) {
                let err = {
                    'URL': URL,
                    'table': table,
                    'page': this.readyState,
                    'status': this.status,
                    'data': xhttpCalls.responseText,
                };
                console.log('Error', err);
            }
        }
    };
    xhttpCalls.open("GET", URL, true);
    xhttpCalls.send();
}

function postDBUpdate(URL, table) {
    // load data from file
    let records = JSON.parse(localStorage.getItem(table));
    let postData = ''
    let i = 0;
    records.forEach(row => {
        for (const [key, value] of Object.entries(row)) {
            //console.log(key + "[" + i + "]", value);
            postData += ('&' + key + '[]=' + value);
        }
        i++;
    });

    var xhttpCalls = new XMLHttpRequest();
    xhttpCalls.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            let response = xhttpCalls.responseText;
            let status = JSON.parse(response);
            if (status['success'] == 'DataSaved') {
                var date = new Date().toISOString();
                const tmpData = localStorage.getItem(table);
                localStorage.setItem(table + date, tmpData);
                localStorage.setItem(table, JSON.stringify([]));
            }
        } else {
            if (this.readyState == 4) {
                let err = {
                    'URL': URL,
                    'table': table,
                    'data': postData,
                    'page': this.readyState,
                    'status': this.status,
                    'data': xhttpCalls.responseText,
                };
                console.log('Error', err);
            }
        }
    };
    xhttpCalls.open("POST", URL, true);
    xhttpCalls.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttpCalls.send(postData);
}