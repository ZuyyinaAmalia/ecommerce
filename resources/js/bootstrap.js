import axios from 'axios';
import * as preline from 'preline';
window.HSStaticMethods = preline.HSStaticMethods;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
