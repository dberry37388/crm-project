<script setup>
import {ChevronDownIcon} from "@heroicons/vue/solid";

const props = defineProps({
    name: {
        type: String,
        required: true
    },

    selected: {
        type: Boolean,
        default: false,
    },

    order: {
        type: String,
        default: '',
    }
})

const emit = defineEmits(['update'])

function sort() {
    emit('update', name)
}

</script>

<template>
    <th scope="col" @click="sort('name')" class="table-header">
        <div class="flex items-center justify-between">
            <span>
                {{name}}
            </span>

            <ChevronDownIcon :class="[selected === true ? 'font-bold' : 'font-medium text-black', order === '-' ?  '-rotate-180' : 'rotate-0', 'h-5 w-5 transform']" aria-hidden="true" />
        </div>
    </th>
</template>
