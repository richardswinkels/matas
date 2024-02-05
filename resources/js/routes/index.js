

const routes = [
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
                beforeEnter: admin,
                meta: {
                    title: 'Create new component',
                },
            },
            {
                path: '/components/:id/edit',
                name: 'components.edit',
                component: ComponentsEdit,
                beforeEnter: admin,
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
                beforeEnter: admin,
                meta: {
                    title: 'Create new assembly',
                },
            },
            {
                path: '/assemblies/:id/edit',
                name: 'assemblies.edit',
                component: AssembliesEdit,
                beforeEnter: admin,
                meta: {
                    title: 'Edit existing assembly',
                },
            },
        ],
    },
];
