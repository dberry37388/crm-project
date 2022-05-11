<script setup>
import {ref} from "vue";
import {ChevronLeftIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/solid";
import ThreeColumnLayout from "../../Layouts/ThreeColumnLayout";
import {Link} from "@inertiajs/inertia-vue3"
import SidebarAttribute from "../../Components/SidebarAttribute";
import ActivityTabs from "../../Components/ActivityTabs";
import ContactDisclosure from "../../Components/Contacts/ContactDisclosure";

const props = defineProps({
    deal: {
        type: Object,
        required: true
    }
})

const currentDeal = ref(props.deal)
const updatingDeal = ref(false)
const deletingDeal = ref(false)

const refreshDeal = axios.get(route('api.v1.deals.show', props.deal.data.id))
    .then((r) => {
        currentDeal.value = r.data.data;
    })

</script>

<template>
    <ThreeColumnLayout>
        <template #leftColumn>
            <div v-if="currentDeal.id">
                <div class="border-b border-gray-200 p-5">
                    <div class="mb-6">
                        <Link :href="route('deals.list')">
                            <div class="flex gap-2 justify-start items-center">
                                <ChevronLeftIcon class="h-4 w-4 text-orange-600" />

                                <span class="text-xs font-bold text-orange-600">
                                    Deals
                                </span>
                            </div>
                        </Link>
                    </div>

                    <div>
                        <div class="font-bold font-semibold">
                            {{ currentDeal.name }}
                        </div>

                        <div class="mt-4 flex flex-col gap-1 text-sm">
                            <div>
                                <span class="font-medium">Amount: </span> {{currentDeal.amount}}
                            </div>

                            <div>
                                <span class="font-medium">Close Date: </span> {{new Date(currentDeal.close_date).toLocaleDateString()}}
                            </div>

                            <div>
                                <span class="font-medium">Stage: </span> {{currentDeal.stage}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 p-5">
                    <SidebarAttribute label="Assigned To" :content="currentDeal.created_by.name" />
                    <SidebarAttribute label="Created By" :content="currentDeal.owned_by.name"  />
                    <SidebarAttribute label="Type of Deal" :content="currentDeal.type" />
                    <SidebarAttribute label="Priority" :content="currentDeal.priority" />
                </div>
            </div>
        </template>

        <template #middleColumn>

            <div class="p-5">
                <ActivityTabs
                    v-if="deal"
                    :model-id="deal.data.id"
                    :note-list-route="route('api.v1.deal.list-notes', deal.data.id)"
                    :note-store-route="route('api.v1.deal.store-note', deal.data.id)"
                    :task-list-route="route('api.v1.deal.tasks.list', deal.data.id)"
                    :task-store-route="route('api.v1.deal.tasks.store', deal.data.id)"
                />
            </div>
        </template>

        <!-- section Right -->
        <template #rightColumn>
            <div class="p-5 border-b border-gray-200">
                <ContactDisclosure
                    resource-type="deal"
                    :model-route="route('api.v1.deal.contacts.list', deal.data.id)"
                    :default-open="true"
                    :model-id="deal.data.id"
                />
            </div>
        </template>

    </ThreeColumnLayout>

</template>
