<template>
    <form @submit.prevent="store">
        <div>
            <label for="name" class="block text-sm font-semibold mb-1">
                Name:
            </label>
            <input v-model="form.name" id="name" type="text"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in form.errors.get('name')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="price" class="block text-sm font-semibold mb-1">
                Price:
            </label>
            <input v-model="form.price" id="price" type="number" min="0" step="0.01"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in form.errors.get('price')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="stock" class="block text-sm font-semibold mb-1">
                Stock:
            </label>
            <input v-model="form.stock" id="stock" type="number" min="0"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in form.errors.get('stock')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="image" class="block text-sm font-semibold mb-1">
                Image:
            </label>
            <input @change="form.file = $event.target.files[0]" type="file" id="image"/>
            <div class="text-red-600 text-sm mt-1">
                <div v-for="message in form.errors.get('file')">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                <span v-show="form.processing"
                      class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                <span v-if="form.processing">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import Form from "form-backend-validation"

const form = new Form({
    'name': '',
    'price': 0.00,
    'stock': 0,
    'file': null,
})

const store = async () => {
    try {
        await form.post(route('api.assemblies.store'))
        window.location.href = route('assemblies.index')
    } catch (error) {
        console.log(error);
    }
}
</script>
