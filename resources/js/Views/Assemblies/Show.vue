<template>
    <div>
        <div class="mb-4 flex">
            <img :src="assembly.image ? `/storage/${assembly.image}` : '/images/no-image.svg'"
                 :alt="assembly.name" class="h-[400px] w-[400px]"/>
            <div v-if="canPurchase" class="self-center mx-auto">
                <input v-model="form.quantity" type="number" min="1"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-48"/>
                <button
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm"
                    @click="purchaseAssembly">
                    Buy
                </button>

                <div class="text-red-600 text-sm mt-1">
                    <div v-for="message in form.errors.get('quantity')">
                        {{ message }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mr-24">
            <div class="mb-4">
                    <label class="font-bold">
                        ID:
                    </label>
                    <p>
                        {{ assembly.id }}
                    </p>
                </div>
            <div class="mb-4">
                    <label class="font-bold">
                        Name:
                    </label>
                    <p>
                        {{ assembly.name }}
                    </p>
                </div>
            <div class="mb-4">
                    <label class="font-bold">
                        Price:
                    </label>
                    <p>
                        {{ formatEuro(assembly.price) }}
                    </p>
                </div>
            <div class="mb-6" v-if="assembly.components && assembly.components.length">
                    <label class="font-bold">
                        Components:
                    </label>
                    <ul>
                        <li v-for="component in assembly.components">
                            <a :href="route('components.show', component.id)"
                               class="underline hover:text-gray-500">
                                #{{ component.id }} - {{ component.name }}
                            </a>
                        </li>
                    </ul>
                </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed} from "vue"
import {formatEuro} from "@/helpers.js"
import Form from "form-backend-validation";

const props = defineProps({
    assembly: {
        type: Object,
        required: true
    }
})

const quantity = ref(0);

const form = new Form({
    'quantity': quantity.value,
})

const purchaseAssembly = async () => {
    try {
        await form.post(route('api.user.assemblies.store', props.assembly.id))
        quantity.value = 0
    } catch (error) {
        console.log(error)
    }
}

const canPurchase = computed(() => User !== null)
</script>
