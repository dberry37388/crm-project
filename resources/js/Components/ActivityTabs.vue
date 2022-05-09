<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import ListNotes from "./Notes/ListNotes";

const props = defineProps({
    modelId: {
        type: Number,
        required: true
    },

    noteListRoute: {
        type: String,
        required: true
    },

    noteStoreRoute: {
        type: String,
        required: true
    }
})
</script>

<template>
    <TabGroup>
        <TabList class="border-gray-300 border-b outline-0 focus:outline-0">
            <Tab v-slot="{ selected }" as="template">
                <button :class="[selected ? 'border-black font-bold outline-0' : 'border-transparent hover:font-semibold hover:text-gray-700 hover:border-gray-300', 'py-4 px-8 text-center border-b-2 font-medium text-sm']">
                    Notes
                </button>
            </Tab>

            <Tab v-slot="{ selected }" as="template">
                <button :class="[selected ? 'border-black font-bold outline-0' : 'border-transparent hover:font-semibold hover:text-gray-700 hover:border-gray-300', 'py-4 px-8 text-center border-b-2 font-medium text-sm']">
                    Tasks
                </button>
            </Tab>
        </TabList>
        <TabPanels>
            <TabPanel>
                <div class="mt-6">
                    <ListNotes :noteListRoute="noteListRoute" :modelRoute="noteStoreRoute" v-show="modelId" />
                </div>
            </TabPanel>

            <TabPanel>
                <div class="mt-6">
                    Tasks will go here.
                </div>
            </TabPanel>
        </TabPanels>
    </TabGroup>
</template>
