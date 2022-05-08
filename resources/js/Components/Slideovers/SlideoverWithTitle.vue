<script setup>

import {DialogTitle} from "@headlessui/vue";
import { XIcon } from '@heroicons/vue/outline'
import { LinkIcon, PlusSmIcon, QuestionMarkCircleIcon } from '@heroicons/vue/solid'
import Slideover from "./Slideover";

const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const team = [
    {
        name: 'Tom Cook',
        email: 'tom.cook@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Whitney Francis',
        email: 'whitney.francis@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Leonard Krasner',
        email: 'leonard.krasner@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Floyd Miles',
        email: 'floy.dmiles@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Emily Selman',
        email: 'emily.selman@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
]
const emit = defineEmits(['close', 'update']);

const closeSlideover = (shouldRefreshParent = false) => {
    if (shouldRefreshParent) {
        emit('update');
    }

    emit('close');
};

</script>

<template>
    <Slideover :show="show">
        <div class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">
            <div class="h-0 flex-1 overflow-y-auto">
                <header class="bg-gray-700 py-6 px-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <slot name="header" />
                    </div>
                    <div class="mt-1" v-if="$slots.description">
                        <p class="text-sm text-gray-300">
                            <slot name="description" />
                        </p>
                    </div>
                </header>

                <main class="flex flex-1 flex-col justify-between">
                    <div class="px-4 sm:px-6">
                        <slot name="content" />
                    </div>
                </main>
            </div>
            <div class="flex flex-shrink-0 justify-end px-4 py-4" v-if="$slots.actions">
                <slot name="actions" />
            </div>
        </div>
    </Slideover>
</template>
