import { createRouter, createWebHistory } from 'vue-router';

import Auth from '@/layouts/Auth.vue';
import App from '@/layouts/App.vue';

import Login from "@/components/Auth/Login.vue";
import Register from "@/components/Auth/Register.vue";
import ComponentsIndex from '@/components/Components/Index.vue';
import ComponentsShow from '@/components/Components/Show.vue';
import ComponentsCreate from '@/components/Components/Create.vue';
import ComponentsEdit from '@/components/Components/Edit.vue';
import AssembliesIndex from '@/components/Assemblies/Index.vue';
import AssembliesShow from '@/components/Assemblies/Show.vue';
import AssembliesCreate from '@/components/Assemblies/Create.vue';
import AssembliesEdit from '@/components/Assemblies/Edit.vue';

const routes = [
    {
        path: '',
        redirect: 'components'
    },
    {
        component: Auth,
        children: [
            {
                path: '/login',
                name: 'login',
                component: Login,
            },
            {
                path: '/register',
                name: 'register',
                component: Register,
            }
        ]
    },
    {
        component: App,
        children: [
            {
                path: '/components',
                name: 'components.index',
                component: ComponentsIndex,
                meta: {
                    title: 'Components overview',
                },
            },
            {
                path: '/components/:id',
                name: 'components.show',
                component: ComponentsShow,
                meta: {
                    title: 'Component details',
                },
            },
            {
                path: '/components/create',
                name: 'components.create',
                component: ComponentsCreate,
                meta: {
                    title: 'Create new component',
                },
            },
            {
                path: '/components/:id/edit',
                name: 'components.edit',
                component: ComponentsEdit,
                meta: {
                    title: 'Edit existing component',
                },
            },
            {
                path: '/assemblies',
                name: 'assemblies.index',
                component: AssembliesIndex,
                meta: {
                    title: 'Assemblies overview',
                },
            },
            {
                path: '/assemblies/:id',
                name: 'assemblies.show',
                component: AssembliesShow,
                meta: {
                    title: 'Assembly details',
                },
            },
            {
                path: '/assemblies/create',
                name: 'assemblies.create',
                component: AssembliesCreate,
                meta: {
                    title: 'Create new assembly',
                },
            },
            {
                path: '/assemblies/:id/edit',
                name: 'assemblies.edit',
                component: AssembliesEdit,
                meta: {
                    title: 'Edit existing assembly',
                },
            },
        ],
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
});
