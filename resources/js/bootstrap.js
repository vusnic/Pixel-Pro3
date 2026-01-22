import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuração para resolver problemas de CORS no ambiente de desenvolvimento
if (process.env.NODE_ENV === 'development') {
    window.axios.defaults.withCredentials = true;
    window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
}
