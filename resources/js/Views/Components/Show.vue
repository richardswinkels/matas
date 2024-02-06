<template>
    <div>
        <div class="mb-4">
            <img :src="component.image ? `/storage/${component.image}` : '/images/no-image.svg'"
                 :alt="component.name" class="h-[400px] w-[400px]"/>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                ID:
            </label>
            <p>
                {{ component.id }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Name:
            </label>
            <p>
                {{ component.name }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Type:
            </label>
            <p>
                {{ component.type }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Manufacturer:
            </label>
            <p>
                {{ component.manufacturer.name }}
            </p>
        </div>
        <div class="mb-4">
            <label class="font-bold">
                Price:
            </label>
            <p>
                {{ formatEuro(component.price) }}
            </p>
        </div>
    </div>
</template>

<script>
import {formatEuro} from "@/helpers.js";

export default {
    methods: {formatEuro},
    props: {
        component: {
            type: Object,
            required: true,
        }
    },
}
</script>
