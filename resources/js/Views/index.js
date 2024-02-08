import {defineAsyncComponent} from 'vue';

export default {
    install(app, options) {
        app.component('assemblies.index', defineAsyncComponent(() => import('./Assemblies/Index.vue')))
        app.component('assemblies.show', defineAsyncComponent(() => import('./Assemblies/Show.vue')))
        app.component('assemblies.create', defineAsyncComponent(() => import('./Assemblies/Create.vue')))
        app.component('assemblies.edit', defineAsyncComponent(() => import('./Assemblies/Edit.vue')))
        app.component('components.index', defineAsyncComponent(() => import('./Components/Index.vue')))
        app.component('components.show', defineAsyncComponent(() => import('./Components/Show.vue')))
        app.component('components.create', defineAsyncComponent(() => import('./Components/Create.vue')))
        app.component('components.edit', defineAsyncComponent(() => import('./Components/Edit.vue')))
        app.component('users.show', defineAsyncComponent(() => import('./Users/Show.vue')))
    }
}
