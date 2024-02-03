import './bootstrap';

import { createApp } from 'vue';

import router from './routes/index';

createApp({})
    .use(router)
    .mount('#app');
