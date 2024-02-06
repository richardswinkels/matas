<template>
    <div>
        <div class="mb-4">
            <img :src="this.assembly.image ? `/storage/${this.assembly.image}` : '/images/no-image.svg'"
                 :alt="this.assembly.name" class="h-[400px] w-[400px]"/>
        </div>
        <div class="flex">
            <div class="w-1/3">
                <div class="mb-4">
                    <label class="font-bold">
                        ID:
                    </label>
                    <p>
                        {{ this.assembly.id }}
                    </p>
                </div>
                <div class="mb-4">
                    <label class="font-bold">
                        Name:
                    </label>
                    <p>
                        {{ this.assembly.name }}
                    </p>
                </div>
                <div class="mb-4">
                    <label class="font-bold">
                        Price:
                    </label>
                    <p>
                        {{ this.formatEuro(this.assembly.price) }}
                    </p>
                </div>
                <div class="mb-6" v-if="this.assembly.components && this.assembly.components.length">
                    <label class="font-bold">
                        Components:
                    </label>
                    <ul class="list-disc ml-4">
                        <li v-for="component in this.assembly.components">
                            <router-link :to="{ name: 'components.show', params: { id: component.id }}"
                                         class="underline hover:text-gray-500">
                                #{{ component.id }} - {{ component.name }}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-2/3">
                <div>
                    <input v-model="quantity" type="number" min="1"
                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-24"/>
                    <button
                        class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm"
                        @click="purchaseAssembly(this.component.id, this.quantity)">
                        Buy
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            assembly: {},
            quantity: '',
        }
    },
    mounted() {
        const assemblyId = this.$route.params.id;
        this.fetchAssembly(assemblyId);
    },
    methods: {
        async purchaseAssembly(id, quantity) {
            let url = '/api/assemblies/' + id;
            axios.post(url, {
                'quantity': quantity
            })
                .then(response => this.assembly = response.data.data)
                .catch(error => console.log(error))
        },
        async fetchAssembly(id) {
            let url = '/api/assemblies/' + id;

            axios.get(url)
                .then(response => this.assembly = response.data.data)
                .catch(error => console.log(error))
        },
    },
}
</script>
