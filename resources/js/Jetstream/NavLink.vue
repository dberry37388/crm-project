<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-5 py-3 bg-gray-800 text-sm font-semibold leading-5 text-white focus:outline-none transition'
        : 'inline-flex items-center px-5 py-3 text-sm font-medium leading-5 text-white hover:bg-gray-800 focus:outline-none transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
