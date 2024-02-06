import './bootstrap';
import registerViews from './Views/index.js';

import { ZiggyVue } from 'ziggy-js';

import {createApp} from 'vue';

createApp({})
    .use(registerViews)
    .use(ZiggyVue)
    .mount('#app');
