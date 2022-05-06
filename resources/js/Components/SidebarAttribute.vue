<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        label: {
            type: String,
            required: true
        },

        content: {
            type: String,
            required: true
        }
    }
})
</script>

<template>
    <div>
        <div class="text-xs mb-1 text-gray-500">
            {{ label }}
        </div>

        <div class="text-sm">
            {{ content }}
        </div>
    </div>
</template>
