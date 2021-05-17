function doDBSync() {
    var date = new Date();
    date.setHours(date.getHours() + 2);
    date = date.toISOString().substring(14, 16);
    if ((date > 00 && date < 05) || (date > 30 && date < 35)) {
        console.log(date)
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
                    postDBUpdate(baseURL + '/API/clockUp.php' + '?KEY=' + apiKey, 'clockingsUP')
                }
            }

            // if worklogUP local DB is created
            if (localStorage.getItem('worklogUP')) {
                // Load Offline worklogUP
                let records = JSON.parse(localStorage.getItem('worklogUP'));
                if (records.length !== 0) {
                    postDBUpdate(baseURL + '/API/workUp.php' + '?KEY=' + apiKey, 'worklogUP')
                }
            }
        }
    }
}
doDBSync();

function fSync() {
    // if we online
    if (window.navigator.onLine) {

        alert('Online - Sync Started');
        // set api stuff
        let baseURL = 'https://phq-7hxllh2.petragroup.local/web_dev/Projects/WildeklawerTydkaarte';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

        // if clockingsUP local DB is created
        if (localStorage.getItem('worklogUP')) {
            // Load Offline clockingsUP
            let records = JSON.parse(localStorage.getItem('clockingsUP'));
            if (records.length !== 0) {
                postDBUpdate(baseURL + '/API/clockUp.php' + '?KEY=' + apiKey, 'clockingsUP')
            }
        }

        // if worklogUP local DB is created
        if (localStorage.getItem('worklogUP')) {
            // Load Offline worklogUP
            let records = JSON.parse(localStorage.getItem('worklogUP'));
            if (records.length !== 0) {
                postDBUpdate(baseURL + '/API/workUp.php' + '?KEY=' + apiKey, 'worklogUP')
            }
        }
    }
}