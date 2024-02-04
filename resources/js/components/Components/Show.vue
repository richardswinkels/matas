<template>
    <div>
        <div class="mb-4">
            <img :src="this.component.image ? `/storage/${this.component.image}` : '/images/no-image.svg'" :alt="this.component.name" class="h-[400px] w-[400px]" />
        </div>
        <div class="mb-4">
            <label class="font-bold">
                ID:
            </label>
            <p>
                {{ this.component.id }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Name:
            </label>
            <p>
                {{ this.component.name }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Type:
            </label>
            <p>
                {{ this.component.type }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Manufacturer:
            </label>
            <p>
                {{ this.component.manufacturer }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Price:
            </label>
            <p>
                {{ this.formatEuro(component.price) }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            component: {},
        }
    },
    mounted() {
        const componentId =  this.$route.params.id;
        this.fetchComponent(componentId);
    },
    methods: {
        async fetchComponent(id) {
            let url = '/api/components/' + id;

            axios.get(url)
                .then(response => this.component = response.data.data)
                .catch(error => console.log(error))
        },
    },
}
</script>
