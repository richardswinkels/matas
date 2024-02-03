import { createRouter, createWebHistory } from 'vue-router';

import App from '@/layouts/App.vue';

import TestComponent from '@/components/test-component.vue';

const routes = [
    {
        path: '',
        redirect: 'test'
    },
    {
        component: App,
        children: [
            {
                path: '/test',
                name: 'test',
                component: TestComponent,
                meta: {
                    title: 'test title',
                },
            },
        ],
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
});
