import './bootstrap';

import {createApp} from 'vue';
import {isAdmin} from "./mixins";
import {formatEuro} from './mixins';
import {isLoggedIn} from "./mixins";

import router from './routes/index';

createApp({})
    .mixin(formatEuro)
    .mixin(isAdmin)
    .mixin(isLoggedIn)
    .use(router)
    .mount('#app');
