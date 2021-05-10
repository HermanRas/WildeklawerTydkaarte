function doDBSync() {
    // if we online
    if (window.navigator.onLine) {
        // set api stuff
        let baseURL = 'https://phq-7hxllh2.petragroup.local/web_dev/Projects/WildeklawerTydkaarte';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';


        // if clockingsUP local DB is created
        if (localStorage.getItem('worklogUP')) {
            // Load Offline clockingsUP
            let records = JSON.parse(localStorage.getItem('clockingsUP'));
            if (records.length !== 0) {
                //console.log(records[0]);
                postDBUpdate(baseURL + '/API/clockUp.php' + '?KEY=' + apiKey, 'clockingsUP')
            }
        }

        // if worklogUP local DB is created
        if (localStorage.getItem('worklogUP')) {
            // Load Offline worklogUP
            let records = JSON.parse(localStorage.getItem('worklogUP'));
            if (records.length !== 0) {
                console.log(records[0]);
                postDBUpdate(baseURL + '/API/workUp.php' + '?KEY=' + apiKey, 'worklogUP')
            }
        }
    }
}
doDBSync();