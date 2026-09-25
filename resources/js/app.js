import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

const reverb = window.ReverbConfig ?? {};
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: reverb.key,
    wsHost: reverb.host,
    wsPort: reverb.port ?? 80,
    wssPort: reverb.port ?? 443,
    forceTLS: (reverb.scheme ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
