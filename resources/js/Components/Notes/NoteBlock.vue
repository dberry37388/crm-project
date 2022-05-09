<script setup>

const props = defineProps({
    note: {
        type: Object,
        required: true
    }
})

</script>

<template>
    <div class="bg-white p-5 hover:shadow-lg">
        <div class="flex items-center justify-between gap-4 text-sm">
            <div>
                <span class="font-semibold">Note by</span> {{ note.created_by.name }}
            </div>

            <div class="text-gray-500">
                {{ new Date(note.created_at).toLocaleDateString() }}
            </div>
        </div>

        <div class="mt-5">
            {{ note.note }}
        </div>
    </div>
</template>
