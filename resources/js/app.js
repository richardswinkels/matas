import './bootstrap';

import {createApp} from 'vue';
import {isAdmin} from "./helpers.js";
import {formatEuro} from './helpers.js';
import {isLoggedIn} from "./helpers.js";

import router from './routes/index';

createApp({})
    .use(registerViews)
    .mount('#app');
