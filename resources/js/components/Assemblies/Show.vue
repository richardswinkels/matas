<template>
    <div>
        <div class="mb-4">
            <img :src="this.assembly.image ? `/storage/${this.assembly.image}` : '/images/no-image.svg'" :alt="this.assembly.name" class="h-[400px] w-[400px]" />
        </div>
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
        <div class="mb-4" v-if="this.assembly.components && this.assembly.components.length">
            <label class="font-bold">
                Components:
            </label>
            <ul class="list-disc ml-4">
               <li v-for="component in this.assembly.components">
                   <router-link :to="{ name: 'components.show', params: { id: component.id }}" class="underline hover:text-gray-500">
                       #{{ component.id }} - {{ component.name }}
                   </router-link>
               </li>
            </ul>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            assembly: {},
        }
    },
    mounted() {
        const assemblyId =  this.$route.params.id;
        this.fetchAssembly(assemblyId);
    },
    methods: {
        async fetchAssembly(id) {
            let url = '/api/assemblies/' + id;

            axios.get(url)
                .then(response => this.assembly = response.data.data)
                .catch(error => console.log(error))
        },
    },
}
</script>
