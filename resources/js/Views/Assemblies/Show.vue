<template>
    <div>
        <div class="mb-4">
            <img :src="assembly.image ? `/storage/${assembly.image}` : '/images/no-image.svg'"
                 :alt="assembly.name" class="h-[400px] w-[400px]"/>
        </div>
        <div>
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
                <ul class="list-disc ml-4">
                    <li v-for="component in assembly.components">
                        <a :href="route('components.show', component.id)"
                           class="underline hover:text-gray-500">
                            #{{ component.id }} - {{ component.name }}
                        </a>
                    </li>
                </ul>
            </div>
            <div v-if="canPurchase">
                <input v-model="quantity" type="number" min="1"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-24"/>
                <button
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm"
                    @click="purchaseAssembly(component.id, quantity)">
                    Buy
                </button>
            </div>
        </div>
    </div>
</template>


<script>
import {formatEuro} from "@/helpers.js";

export default {
    props: {
        assembly: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            quantity: '',
        }
    },
    computed: {
        canPurchase() {
            return User !== null;
        },
    },
    methods: {
        formatEuro,
        async purchaseAssembly(id, quantity) {
            let url = '/api/assemblies/' + id;
            axios.post(url, {
                'quantity': quantity
            })
                .then(response => this.assembly = response.data.data)
                .catch(error => console.log(error))
        },
    },
}
</script>
