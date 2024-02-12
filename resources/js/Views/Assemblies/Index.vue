<template>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200">
        <div class="min-w-full align-middle">
            <div class="w-full mb-4 flex justify-end">
                <div class="flex justify-center">
                    <label for="search" class="mr-2 text-sm self-center">Search:</label>
                    <input type="text" name="search" id="search" v-model="searchQuery" @change="onSearch"
                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2"/>
                    <a :href="route('assemblies.create')"
                                 class="px-2 py-2 rounded-lg bg-green-500 hover:bg-green-400 inline-flex" v-if="canCreate">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 text-gray-100">
                            <path fill-rule="evenodd"
                                  d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Image</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Stock</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">

                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                <tr v-for="assembly in assemblies.data">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ assembly.id }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <img :src="assembly.thumbnail ? `storage/${assembly.thumbnail}` : 'images/no-image.svg'"
                             :alt="assembly.name" class="h-12 w-12"/>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ assembly.name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ formatEuro(assembly.price) }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ assembly.stock }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-right">
                        <div class="inline-flex gap-2 justify-self-end">
                            <a :href="route('assemblies.show', assembly.id)"
                                         class="px-2 py-2 rounded-lg bg-amber-400 hover:bg-amber-300 inline-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-6 h-6 text-gray-100">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                    <path fill-rule="evenodd"
                                          d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a :href="route('assemblies.edit', assembly.id)"
                                         class="px-2 py-2 rounded-lg bg-blue-500 hover:bg-blue-400 inline-flex" v-if="canEdit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-6 h-6 text-gray-100">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/>
                                    <path
                                        d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <TailwindPagination :data="assemblies" :limit="1" :keepLength="true"
                                @pagination-change-page="onPageChange" class="mt-4"/>
        </div>
    </div>
</template>

<script setup>
import {formatEuro } from "@/helpers.js"
import {ref, computed, onMounted} from "vue"
import {TailwindPagination} from 'laravel-vue-pagination'

const page = ref(1)
const assemblies = ref([])
const searchQuery = ref(null)

const fetchAssemblies = async () => {
    try {
        const response = await axios.get(route('api.assemblies.index'), {
            params: {
                page: page.value,
                search: searchQuery.value
            }
        })

        assemblies.value = response.data;
    } catch (error) {
        console.log(error)
    }
}

const canEdit = computed(() => User?.is_admin === true)
const canCreate = computed(() => User?.is_admin === true)

onMounted(() => {
    fetchAssemblies()
})

const onPageChange = (newPage) => {
    page.value = newPage
    fetchAssemblies()
}

const onSearch = () => {
    page.value = 1
    fetchAssemblies()
}
</script>
