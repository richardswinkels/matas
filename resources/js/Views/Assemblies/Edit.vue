<template>
    <form @submit.prevent="updateAssembly(assemblyData)">
        <div>
            <label for="name" class="block text-sm font-semibold mb-1">
                Name:
            </label>
            <input v-model="assemblyData.name" id="name" type="text"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.name">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="price" class="block text-sm font-semibold mb-1">
                Price:
            </label>
            <input v-model="assemblyData.price" id="price" type="number" min="0" step="0.01"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.price">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="stock" class="block text-sm font-semibold mb-1">
                stock:
            </label>
            <input v-model="assemblyData.stock" id="stock" type="number" min="0"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in validationErrors?.stock">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="image" class="block text-sm font-semibold mb-1">
                Image:
            </label>
            <input @change="assemblyData.file = $event.target.files[0]" type="file" id="image"/>
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
    <div class="mt-8 border-t pt-8 mb-6" v-if="assembly.components">
        <label class="font-bold">
            Components in Assembly:
        </label>
        <ul class="mt-2">
            <li v-for="component in assemblyData.components">
                <div>
                    <a :href="route('components.show', component.id)"
                       class="underline hover:text-gray-500 mr-2">
                        #{{ component.id }} - {{ component.name }}
                    </a>
                    <button @click="removeComponent(component.id)" class="font-bold">X</button>
                </div>
            </li>
        </ul>
    </div>
    <form class="mt-4" @submit.prevent="addComponent(selectedComponentId)">
        <label for="component" class="block text-sm font-semibold mb-1">
            Components:
        </label>
        <div class="inline-flex">
            <select v-model="selectedComponentId" id="manufacturer"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <option value="" selected>Choose component</option>
                <option v-for="component in components" :value="component.id">
                    #{{ component.id }} - {{ component.name }}
                </option>
            </select>
            <button type="submit"
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                Add
            </button>
        </div>
        <div class="text-red-600 text-sm mt-1">
            <div v-for="message in validationErrors.component">
                {{ message }}
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        assembly: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            assemblyData: {
                ...this.assembly
            },
            components: [],
            selectedComponentId: {},
            validationErrors: [],
            isLoading: false,
        }
    },
    mounted() {
      this.fetchComponents();
    },
    methods: {
        async fetchAssemblyComponents() {
            let url = '/api/assemblies/' + this.assembly.id + '/components';

            axios.get(url)
                .then(response => this.assemblyData['components'] = response.data.data)
                .catch(error => console.log(error));
        },
        async fetchComponents() {
            let url = '/api/components';

            axios.get(url)
                .then(response => this.components = response.data.data)
                .catch(error => console.log(error));
        },
        async updateAssembly(assembly) {
            if (this.isLoading) return;

            this.isLoading = true;
            this.validationErrors = {};

            const serializedAssembly = new FormData()
            for (const key in assembly) {
                if (assembly.hasOwnProperty(key)) {
                    serializedAssembly.append(key, assembly[key])
                }
            }

            serializedAssembly.append("_method", "PUT");

            axios.post('/api/assemblies/' + assembly.id, serializedAssembly)
                .then(response => {
                    window.location.href = route('assemblies.index');
                })
                .catch(error => {
                    if (error.response?.data) {
                        this.validationErrors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
        },
        async addComponent(componentId) {
            let url = `/api/assemblies/${this.assembly.id}/components/${componentId}`;

            axios.post(url)
                .then(() => this.fetchAssemblyComponents())
                .catch(error => console.log(error));
        },
        async removeComponent(componentId) {
            let url = `/api/assemblies/${this.assembly.id}/components/${componentId}`;

            axios.delete(url)
                .then(() => this.fetchAssemblyComponents())
                .catch(error => console.log(error));
        }
    },
}
</script>
