<script setup>
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
    links: Object,
})

const emit = defineEmits(['update'])

function getPage(url) {
    let urlParams = new URLSearchParams(url);
    emit('update', urlParams.get('page'))
}

</script>

<template>
    <div v-if="links.length >= 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key" class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded" v-html="link.label" />
                <div @click="getPage(link.url)" v-else :key="`link-${key}`" class="cursor-pointer mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded" :class="{ 'bg-gray-200': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
