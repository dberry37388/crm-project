<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true
    },

    content: {
        type: String,
        required: false
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
