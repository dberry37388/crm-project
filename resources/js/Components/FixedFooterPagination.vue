<script setup>
import Pagination from "./Pagination";

const props = defineProps({
    meta: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['update'])

function signalPageChange(value) {
    emit('update', value)
}

</script>

<template>
    <footer class="fixed bottom-0 bg-white p-5 w-full border-t border-gray-200" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);">
        <div class="flex flex-col items-center justify-center">
            <Pagination :links="meta.links" @update="signalPageChange"/>
        </div>
    </footer>
</template>
