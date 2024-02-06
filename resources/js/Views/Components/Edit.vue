<template>
    <form @submit.prevent="updateComponent(componentData)">
        <div>
            <label for="name" class="block text-sm font-semibold mb-1">
                Name:
            </label>
            <input v-model="componentData.name" id="name" type="text"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.name">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="manufacturer" class="block text-sm font-semibold mb-1">
                Manufacturer:
            </label>
            <select v-model="componentData.manufacturer_id" id="manufacturer"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <option value="" selected>Choose manufacturer</option>
                <option v-for="manufacturer in manufacturers" :value="manufacturer.id">
                    #{{ manufacturer.id }} - {{ manufacturer.name }}
                </option>
            </select>
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.manufacturer_id">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="type" class="block text-sm font-semibold mb-1">
                Type:
            </label>
            <input v-model="componentData.type" id="type" type="text"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.type">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="price" class="block text-sm font-semibold mb-1">
                Price:
            </label>
            <input v-model="componentData.price" id="price" type="number" min="0" step="0.01"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.price">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="image" class="block text-sm font-semibold mb-1">
                Image:
            </label>
            <input @change="componentData.file = $event.target.files[0]" type="file" id="image"/>
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.file">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                <span v-show="isLoading"
                      class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        component: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            componentData: {
                ...this.component
            },
            manufacturers: [],
            validationErrors: [],
            isLoading: false,
        }
    },
    mounted() {
        this.fetchManufacturers()
    },
    methods: {
        async fetchManufacturers() {
            let url = '/api/manufacturers';

            axios.get(url)
                .then(response => this.manufacturers = response.data.data)
                .catch(error => console.log(error));
        },
        async updateComponent(component) {
            if (this.isLoading) return;

            this.isLoading = true
            this.validationErrors = {}

            const serializedComponent = new FormData()
            for (const key in component) {
                if (component.hasOwnProperty(key)) {
                    serializedComponent.append(key, component[key])
                }
            }

            serializedComponent.append("_method", "PUT");

            axios.post('/api/components/' + component.id, serializedComponent)
                .then(response => {
                    window.location.href = route('components.index');
                })
                .catch(error => {
                    if (error.response?.data) {
                        this.validationErrors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
        },
    },
}
</script>
