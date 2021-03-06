<script setup>
import { computed, ref } from 'vue'
import {Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions} from "@headlessui/vue";
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'

const query = ref('')
const selectedCompany = ref()
let companies = ref();

const props = defineProps({
    label: {
        type: String,
        default: 'Select a Company'
    }
});

const companiesLookup = axios.get(route('api.v1.currentTeam.list-companies'))
    .then((r) => {
        companies = r.data.data;
    })

const filteredCompanies = computed(() =>
    query.value === ''
        ? companies
        : companies.filter((company) => {
            return company.name.toLowerCase().includes(query.value.toLowerCase())
        })
)
</script>

<template>
    <Combobox as="div" v-model="selectedCompany">
        <ComboboxLabel class="block text-sm font-medium text-gray-700">
            {{ label }}
        </ComboboxLabel>

        <div class="relative mt-1">
            <ComboboxInput class="w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" @change="query = $event.target.value" :display-value="(company) => company?.name" autocomplete="off"/>
            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions v-if="filteredCompanies.length > 0" class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                <ComboboxOption v-for="company in filteredCompanies" :key="company.id" :value="company" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                        <div class="flex items-center">
                            <span :class="['ml-3 truncate', selected && 'font-semibold']">
                                    {{ company.name }}
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
