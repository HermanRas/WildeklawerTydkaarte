// Import DB Classes
import { User } from "./user_class.js";
import { Worker } from "./worker_class.js";
import { Farm } from "./farm_class.js";
import { getDBUpdate } from './dbAPI.js';

// Setup DB if not setup
// for users
if (localStorage.getItem('user') === null) {
    window.localStorage.setItem('user', JSON.stringify([]));
}
// for workers
if (localStorage.getItem('worker') === null) {
    window.localStorage.setItem('worker', JSON.stringify([]));
}
// for farm
if (localStorage.getItem('farm') === null) {
    window.localStorage.setItem('farm', JSON.stringify([]));
}
// for spilpunt
if (localStorage.getItem('spilpunt') === null) {
    window.localStorage.setItem('spilpunt', JSON.stringify([]));
}
// for gewas
if (localStorage.getItem('gewas') === null) {
    window.localStorage.setItem('gewas', JSON.stringify([]));
}
// for task
if (localStorage.getItem('task') === null) {
    window.localStorage.setItem('task', JSON.stringify([]));
}
// for access
if (localStorage.getItem('access') === null) {
    window.localStorage.setItem('access', JSON.stringify([]));
}

if (window.navigator.onLine) {
    let OnlineStatus = true;
    let baseURL = 'https://phq-7hxllh2.petragroup.local/web_dev/Projects/WildeklawerTydkaarte';
    let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';

    // update tables system is online
    getDBUpdate(baseURL + '/API/users.php' + '?KEY=' + apiKey, 'user');
    getDBUpdate(baseURL + '/API/workers.php' + '?KEY=' + apiKey, 'worker');
    getDBUpdate(baseURL + '/API/plaas.php' + '?KEY=' + apiKey, 'plaas');
    getDBUpdate(baseURL + '/API/spilpunt.php' + '?KEY=' + apiKey, 'spilpunt');
    getDBUpdate(baseURL + '/API/gewas.php' + '?KEY=' + apiKey, 'gewas');
    getDBUpdate(baseURL + '/API/task.php' + '?KEY=' + apiKey, 'access');

} else {
    let OnlineStatus = false;
}