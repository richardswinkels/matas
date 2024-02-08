<template>
    <h1 class="text-xl font-semibold mb-4">Purchase history</h1>
    <table class="min-w-full divide-y divide-gray-200 border">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Assembly ID</span>
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</span>
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</span>
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Purchased At</span>
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left">

                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <tr v-for="userAssembly in userAssemblies">
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ userAssembly.assembly.id }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ userAssembly.assembly.name }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ formatEuro(userAssembly.assembly.price) }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ userAssembly.quantity }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ formatDate(userAssembly.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-right">
                    <a :href="route('assemblies.show', userAssembly.assembly.id)"
                       class="px-2 py-2 rounded-lg bg-amber-400 hover:bg-amber-300 inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 text-gray-100">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path fill-rule="evenodd"
                                  d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    <TailwindPagination :data="userAssemblies" :limit="1" :keepLength="true"
                        @pagination-change-page="fetchUserAssemblies" class="mt-4"/>
</template>

<script>
import {TailwindPagination} from 'laravel-vue-pagination';
import {formatEuro, formatDate } from "@/helpers.js";

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
        ...{ formatEuro, formatDate},
        async fetchUserAssemblies(page = 1) {
            let url = '/api/user/assemblies?page=' + page;

            axios.get(url)
                .then(response => this.userAssemblies = response.data.data)
                .catch(error => console.log(error))
        },
    },
}
</script>
