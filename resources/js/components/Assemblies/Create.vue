<template>
    <form @submit.prevent="storeAssembly(this.assembly)">
        <div>
            <label for="name" class="block text-sm font-semibold mb-1">
                Name:
            </label>
            <input v-model="this.assembly.name" id="name" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in this.validationErrors?.name">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="price" class="block text-sm font-semibold mb-1">
                Price:
            </label>
            <input v-model="this.assembly.price" id="price" type="number" min="0" step="0.01" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in this.validationErrors?.price">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="components" class="block text-sm font-semibold mb-1">
                Components:
            </label>
            <Multiselect
                v-model="this.assembly.components"
                :custom-label="({ id, name }) => `#${id} - ${name}`"
                :options="components"
                :multiple="true"
                placeholder="Select components"
                track-by="id"
            />
        </div>
        <div class="mt-4">
            <label for="image" class="block text-sm font-semibold mb-1">
                Image:
            </label>
            <input @change="assembly.file = $event.target.files[0]" type="file" id="image" />
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in this.validationErrors?.file">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                <span v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
    components: {
        Multiselect,
    },
    data() {
        return {
            assembly: {
                'name': '',
                'price': '',
                'image': '',
                'components': [],
                'component_ids': [],
            },
            components: [],
            validationErrors: [],
            isLoading: false,
        }
    },
    mounted() {
      this.fetchComponents();
    },
    methods: {
        async fetchComponents() {
            let url = '/api/components/options';

            axios.get(url)
                .then(response => this.components = response.data.data)
                .catch(error => console.log(error));
        },
        async storeAssembly(assembly) {
            if (this.isLoading) return;

            this.isLoading = true
            this.validationErrors = {}

            assembly['component_ids'] = this.assembly.components.map(component => component.id);

            const serializedAssembly = new FormData()
            for (const key in this.assembly) {
                if (this.assembly.hasOwnProperty(key)) {
                    serializedAssembly.append(key, this.assembly[key])
                }
            }

            axios.post('/api/assemblies', serializedAssembly)
                .then(response => {
                    this.$router.push({ name: 'assemblies.index' })
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
