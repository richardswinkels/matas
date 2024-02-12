<template>
    <form @submit.prevent="updateAssembly">
        <div>
            <label for="name" class="block text-sm font-semibold mb-1">
                Name:
            </label>
            <input v-model="assemblyForm.name" id="name" type="text"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in assemblyForm.errors.get('name')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="price" class="block text-sm font-semibold mb-1">
                Price:
            </label>
            <input v-model="assemblyForm.price" id="price" type="number" min="0" step="0.01"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in assemblyForm.errors.get('price')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="stock" class="block text-sm font-semibold mb-1">
                stock:
            </label>
            <input v-model="assemblyForm.stock" id="stock" type="number" min="0"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in assemblyForm.errors.get('stock')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="image" class="block text-sm font-semibold mb-1">
                Image:
            </label>
            <input @change="assemblyForm.file = $event.target.files[0]" type="file" id="image"/>
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in assemblyForm.errors.get('file')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                <span v-show="assemblyForm.processing"
                      class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                <span v-if="assemblyForm.processing">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
    <div class="mt-8 border-t pt-8 mb-6" v-if="assembly.components">
        <label class="font-bold">
            Components in Assembly:
        </label>
        <ul class="mt-2">
            <li v-for="component in assemblyComponents.data">
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
                <option v-for="component in components.data" :value="component.id">
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

<script setup>
import {onMounted, ref, watch} from "vue"
import Form from "form-backend-validation"

const props = defineProps({
    assembly: {
        type: Object,
        required: true
    }
})

const components = ref([])
const assemblyComponents = ref([])
const selectedComponentId = ref()
const validationErrors = ref([])

const assemblyForm = new Form({
    'name': props.assembly.name,
    'price': props.assembly.price,
    'stock': props.assembly.stock,
    'manufacturer_id': props.assembly.manufacturer_id,
    'file': null,
    '_method': 'PUT'
})

const updateAssembly = async () => {
    try {
        await assemblyForm.post(route('api.assembly.update', props.assembly.id))
        window.location.href = route('assemblies.index');
    } catch (error) {
        console.log(error)
    }
}

const fetchComponents = async () => {
    try {
        const response = await axios.get(route('api.components.index'))
        components.value = response.data
    } catch (error) {
        console.log(error)
    }
}

const fetchAssemblyComponents = async () => {
    try {
        const response = await axios.get(route('api.assembly.components.show', props.assembly.id))
        assemblyComponents.value = response.data
    } catch (error) {
        console.log(error)
    }
}

const addComponent = async () => {
    try {
        await axios.post(route('assemblies.components.store', props.assembly.id, selectedComponentId))
        await fetchAssemblyComponents()
    } catch (error) {
        console.log(error)
    }
}

const removeComponent = async (componentId) => {
    try {
        await axios.delete(route('assemblies.components.destroy', props.assembly.id, componentId))
    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    fetchComponents()
})

watch(() => props.assembly.components, (initialComponents) => {
    assemblyComponents.value = { ...initialComponents };
});
</script>
