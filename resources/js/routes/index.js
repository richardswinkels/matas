import { createRouter, createWebHistory } from 'vue-router';

import TestComponent from '@/components/test-component.vue';

const routes = [
    {
        path: '/',
        name: 'test',
        component: TestComponent,
        meta: {
            title: 'test title',
        },
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
});
