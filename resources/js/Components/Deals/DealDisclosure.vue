<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/inertia-vue3"
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue"
import Dropdown from "../../Jetstream/Dropdown"
import {ChevronDownIcon, ChevronUpIcon, CogIcon} from "@heroicons/vue/solid"
import ManageDealSlideover from "./ManageDealSlideover";
import AttachDealToResource from "./AttachDealToResource";
import ConfirmDetachDealModal from "./ConfirmDetachDealModal";
import dayjs from "dayjs";
// import ConfirmDetachDealModal from "./ConfirmDetachDealModal";
// import AttachDealToResource from "./AttachDealToResource";

const props = defineProps({
    modelRoute: {
        type: String,
        required: true
    },
    defaultOpen: {
        type: Boolean,
        default: false
    },
    modelId: {
        type: Number,
        default: null
    },
    resourceType: {
        type: String,
        required: true
    }
})

const loading = ref(false)
const open = ref(true)
const search = ref('')
const deals = ref({})
const attachingExistingDeal = ref(false)
const attachingNewDeal = ref(false)
const detachingDeal = ref(false)
const selectedDeal = ref({})

function searchResources() {
    loading.value = true;

    axios.get(props.modelRoute)
        .then((r) => {
            deals.value = r.data.data
        })

    loading.value = false;
}

function formatDateTime(value) {
    return dayjs(value).tz(dayjs.tz.guess()).format('MMMM DD, YYYY');
}

searchResources();



</script>

<template>

    <Disclosure v-slot="{ open }" :default-open="defaultOpen">
        <div class="flex items-center justify-between">
            <DisclosureButton as="div" class="flex items-center justify-between">
                <div class="flex justify-between gap-4">
                    <div class="flex gap-4">
                    <span class="ml-6 flex items-center">
                        <ChevronDownIcon :class="[open ? '-rotate-180' : 'rotate-0', 'h-5 w-5 transform']" aria-hidden="true" />
                    </span>

                        <span class="font-semibold text-gray-900">
                        Deals
                    </span>
                    </div>
                </div>
            </DisclosureButton>

            <div class="mr-6">
                <Dropdown>
                    <template #trigger>
                        <div class="flex items-center text-sm cursor-pointer">
                            <span class="mr-1 link">
                                Actions
                            </span>

                            <ChevronDownIcon class="h-3 w-3" />
                        </div>
                    </template>

                    <template #content class="flex flex-col gap-3">
                        <div class="cursor-pointer px-3 py-2 text-sm action-link" @click="attachingNewDeal = true">
                            Associate New Deal
                        </div>

                        <div class="cursor-pointer px-3 py-2 text-sm action-link" @click="attachingExistingDeal = true">
                            Associate Existing Deal
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>

        <!-- Use the built-in <transition> component to add transitions. -->
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-out"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <DisclosurePanel class="h-75 overflow-auto">
                <div class="sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="p-5">
                            <div class="flex flex-col gap-3 mt-5">
                                <div class="border border-gray-200 p-3" v-for="deal in deals" :key="deal.id" v-if="deals.length > 0">
                                    <div class="flex items-center justify-between">
                                        <Link :href="route('deals.show', deal.id)" class="text-sm link font-semibold">
                                            {{ deal.name }}
                                        </Link>

                                        <dropdown>
                                            <template #trigger>
                                                <div class="flex items-center text-sm link cursor-pointer">
                                                    <span class="mr-1">Actions</span>
                                                    <ChevronDownIcon class="h-3 w-3" />
                                                </div>
                                            </template>

                                            <template #content>
                                                <div class="cursor-pointer px-3 py-2 text-sm action-link" @click="selectedDeal = deal; detachingDeal = true">
                                                    Remove from Resource
                                                </div>
                                            </template>
                                        </dropdown>
                                    </div>

                                    <div v-if="deal.amount" class="text-sm text-gray-500 mb-1">
                                        <span>Amount:</span> {{ deal.amount ?? '--'}}
                                    </div>

                                    <div v-if="deal.close_date" class="text-sm text-gray-500 mb-1">
                                        <span>Close Date:</span> {{ formatDateTime(deal.close_date) ?? '--'}}
                                    </div>

                                    <div v-show="deal.stage" class="text-sm text-gray-500 mb-1">
                                        {{ deal.stage }}
                                    </div>
                                </div>

                                <div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12" v-else>
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">It's lonely in here</h3>
                                    <p class="mt-1 text-sm text-gray-500">There are no deals associated with this resource.</p>
                                </div>
                            </div>
                        </div>
                    </div>a
                </div>
            </DisclosurePanel>
        </transition>

        <ConfirmDetachDealModal
            v-if="selectedDeal.id"
            :show="detachingDeal"
            :deal="selectedDeal"
            :model-route="route(`api.v1.${resourceType}.deals.detach`, {[resourceType]: modelId, deal: selectedDeal})"
            @close="detachingDeal = false"
            @update="searchResources" />

        <AttachDealToResource
            :show="attachingExistingDeal"
            :model-route="route(`api.v1.${resourceType}.deals.attach`, modelId)"
            @close="attachingExistingDeal = false"
            @update="searchResources" />

        <ManageDealSlideover
            :show="attachingNewDeal"
            :method-route="route(`api.v1.${resourceType}.deals.store`, modelId)"
            @close="attachingNewDeal = false"
            @update="searchResources"
            v-if="modelId" />
    </Disclosure>

</template>
