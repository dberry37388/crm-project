<script setup>
import { computed, ref } from 'vue'
import {Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions} from "@headlessui/vue";
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'

const query = ref('')
const selectedDeal = ref()
let deals = ref();

const props = defineProps({
    label: {
        type: String,
        default: 'Search for a Deal'
    }
});

const dealsLookup = axios.get(route('api.v1.currentTeam.list-deals'))
    .then((r) => {
        deals = r.data.data;
    })

const filteredDeals = computed(() =>
    query.value === ''
        ? deals
        : deals.filter((deal) => {
            return deal.name.toLowerCase().includes(query.value.toLowerCase())
        })
)
</script>

<template>
    <Combobox as="div" v-model="selectedDeal">
        <ComboboxLabel class="block text-sm font-medium text-gray-700">
            {{ label }}
        </ComboboxLabel>

        <div class="relative mt-1">
            <ComboboxInput class="w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" @change="query = $event.target.value" :display-value="(deal) => deal?.name" autocomplete="off"/>
            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions v-if="filteredDeals.length > 0" class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                <ComboboxOption v-for="deal in filteredDeals" :key="deal.id" :value="deal" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                        <div class="flex items-center">
                            <span :class="['ml-3 truncate', selected && 'font-semibold']">
                                    {{ deal.name }}
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
