<script setup>
import { computed, ref } from 'vue'
import {Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions} from "@headlessui/vue";
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'

const query = ref('')
const selectedContact = ref()
let contacts = ref();

const props = defineProps({
    label: {
        type: String,
        default: 'Select a Contact'
    }
});

const contactsLookup = axios.get(route('api.v1.contacts.index'))
    .then((r) => {
        contacts = r.data.data;
    })

const filteredContacts = computed(() =>
    query.value === ''
        ? contacts
        : contacts.filter((contact) => {
            return contact.first_name.toLowerCase().includes(query.value.toLowerCase()) || contact.last_name.toLowerCase().includes(query.value.toLowerCase())
        })
)

const getDisplayValue = (contact) => {
    if (!contact || contact.length > 0) {
        return '';
    }

    return contact.first_name + ' ' + contact.last_name;
}
</script>

<template>
    <Combobox as="div" v-model="selectedContact">
        <ComboboxLabel class="block text-sm font-medium text-gray-700">
            {{ label }}
        </ComboboxLabel>

        <div class="relative mt-1">
            <ComboboxInput class="w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" @change="query = $event.target.value" :display-value="(contact) => getDisplayValue(contact)" autocomplete="off"/>
            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions v-if="filteredContacts.length > 0" class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                <ComboboxOption v-for="contact in filteredContacts" :key="contact.id" :value="contact" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                        <div class="flex items-center">
                            <span :class="['ml-3 truncate', selected && 'font-semibold']">
                                {{ contact.first_name }} {{ contact.last_name }} <span v-if="contact.email" class="text-sm text-gray-400">{{contact.email}}</span>
                            </span>
                        </div>

                        <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-indigo-600']">
                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>
