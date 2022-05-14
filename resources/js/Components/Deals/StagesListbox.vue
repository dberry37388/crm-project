<script setup>

import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from "@headlessui/vue"
import {SelectorIcon, CheckIcon} from "@heroicons/vue/solid"
import {ref, watch} from "vue";

const listOptions = [
    { name: 'Any', color: '#444444' },
    { name: 'Appointment scheduled', color: '#444444' },
    { name: 'Qualified to buy', color: '#f4f4f4' },
    { name: 'Presentation scheduled', color: '#fc0000' },
    { name: 'Decision maker brought-in', color: '#fc0000' },
    { name: 'Contract sent', color: '#fc0000' },
    { name: 'Closed won', color: '#fc0000' },
    { name: 'Closed lost', color: '#fc0000' },
]

const props = defineProps({
    default: {
        type: String,
        default: 'Any'
    },
    label: {
        type: String,
        default: 'Stage'
    },

})

let option = ref(props.default)

const emit = defineEmits(['update']);

watch(option, (currentValue) => {
    emit('update', currentValue)
});
</script>

<template>
    <Listbox as="div" v-model="option">
        <ListboxLabel class="block text-sm font-medium text-gray-700 font-semibold"> {{ label }} </ListboxLabel>
        <div class="relative">
            <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <span class="flex items-center">
                        <span class="block truncate">{{ option }}</span>
                    </span>

                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions class="absolute z-10 mt-1 w-50   bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="option in listOptions" :key="option.id" :value="option.name" v-slot="{ active, selected }">
                        <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                            <div class="flex items-center">
                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                                        {{ option.name }}
                                    </span>
                            </div>

                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
