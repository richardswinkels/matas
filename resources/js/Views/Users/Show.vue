<template>
    <h1 class="text-xl font-semibold">Purchase history</h1>
    <div v-for="userAssembly in userAssemblies">
        <div>#{{userAssembly.assembly?.id}} - {{userAssembly.assembly?.name}} - {{ formatEuro(userAssembly.assembly?.price) }} - {{ userAssembly.created_at }}</div>
    </div>
    <TailwindPagination :data="userAssemblies" :limit="1" :keepLength="true"
                        @pagination-change-page="fetchUserAssemblies" class="mt-4"/>
</template>

<script>
import {TailwindPagination} from 'laravel-vue-pagination';
import {formatEuro } from "@/helpers.js";

export default {
    data() {
        return {
            'userAssemblies': [],
        }
    },
    components: {
        TailwindPagination,
    },
    mounted() {
        this.fetchUserAssemblies()
    },
    methods: {
        formatEuro,
        async fetchUserAssemblies(page = 1) {
            let url = '/api/user/assemblies?page=' + page;

            axios.get(url)
                .then(response => this.userAssemblies = response.data.data)
                .catch(error => console.log(error))
        },
    },
}
</script>
