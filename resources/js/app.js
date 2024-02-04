import './bootstrap';

import { createApp } from 'vue';
import { euroMixin } from './mixins';

import router from './routes/index';

createApp({})
    .mixin(euroMixin)
    .use(router)
    .mount('#app');
