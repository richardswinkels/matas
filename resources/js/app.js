import './bootstrap';
import {createApp} from 'vue';

import registerViews from './Views/index.js';

import { ZiggyVue } from 'ziggy-js';

createApp({})
    .use(registerViews)
    .use(ZiggyVue)
    .mount('#app');
