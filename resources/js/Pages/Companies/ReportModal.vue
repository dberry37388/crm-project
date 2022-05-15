<script setup>

import DialogModal from "../../Jetstream/DialogModal";
import dayjs from "dayjs"
import SecondaryButton from "../../Jetstream/SecondaryButton";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },

    companies: {
        type: Object,
        required: true
    },

    wildcardSearch: {
        type: String,
        default: null
    },

    assignedTo: {
        default: null
    },

    createdBy: {
        default: null
    }
})

const emit = defineEmits(['close'])

function formatDate(date) {
    return dayjs(date).format("MMMM DD, YYYY - hh:mm A");
}

</script>

<template>
    <DialogModal :show="props.show" max-width="3xl">
        <template #title>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold">
                    Company Report
                </h2>

                <div class="text-sm">
                    Generated on {{ formatDate(Date.now()) }}
                </div>
            </div>
        </template>

        <template #content>
            <div class="flex flex-wrap items-center justify-start gap-4">
                <div class="bg-gray-200 text-sm rounded-lg px-3 py-2" v-if="createdBy">
                    <span class="font-semibold">Created By:</span> {{ createdBy.name }}
                </div>

                <div class="bg-gray-200 text-sm rounded-lg px-3 py-2" v-if="assignedTo">
                    <span class="font-semibold">Assigned To:</span> {{ assignedTo.name }}
                </div>
            </div>

            <div class="mt-10 overflow-y-auto max-h-[500px]">
                <div class="flex flex-col gap-3">
                    <div v-for="company in companies.data" :key="company.id">
                        <div class="border border-gray-300 p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="font-bold">
                                        {{ company.name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        <div v-if="company.industry">
                                            {{ company.industry.name}} &nbsp;
                                        </div>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-500">
                                    <div>
                                        <span v-if="company.city">{{ company.city }}, </span> <span v-if="company.city">{{ company.state }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 text-sm text-gray-500 flex items-center gap-4">
                                <div>
                                    <span class="font-semibold">Created by: </span>
                                    {{ company.assigned_to.name}}
                                </div>
                                <div>
                                    <span class="font-semibold">Assigned to: </span>
                                    {{ company.created_by.name}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click.native="emit('close')">
                Cancel
            </SecondaryButton>
        </template>
    </DialogModal>
</template>
