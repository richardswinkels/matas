import './bootstrap';

import { createApp } from 'vue'
import TestComponent from './components/test-component.vue'

createApp({})
    .component('TestComponent', TestComponent)
    .mount('#app')
