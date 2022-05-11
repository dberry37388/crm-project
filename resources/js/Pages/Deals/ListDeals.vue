<script setup>
import {ref} from "vue";
import {SearchIcon} from "@heroicons/vue/solid";
import FullWidthAppLayout from "../../Layouts/FullWidthAppLayout";
import Button from "../../Jetstream/Button";
import Input from "../../Jetstream/Input";
import FixedFooterPagination from "../../Components/FixedFooterPagination";
import ManageDealSlideover from "./Slideovers/ManageDealSlideover";

const props = defineProps({
    deals: {
        type: Object,
        required: false
    }
})

const filteredDeals = ref(props.deals)
const creatingDeal = ref(false)
const search = ref('')
const loading = ref(false)

const searchDeals = _.debounce((function (e) {
    loading.value = true;

    const params = {
        search: this.search
    };

    axios.get(route('api.v1.deals.index'), {params})
        .then((r) => {
            filteredDeals.value = r.data;
            loading.value = false;
        })
}), 500)

</script>

<template>

    <FullWidthAppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        Deals
                    </h2>
                </div>

                <div>
                    <Button type="button" @click="creatingDeal = true">Create Deal</Button>
                </div>
            </div>
        </template>

        <div class="py-5">
            <div class="sm:px-6 lg:px-5">
                <div v-if="!loading">
                    <div class="flex items-center justify-start gap-5">
                        <div class="relative rounded-md shadow-sm w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <SearchIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <Input type="text" class="w-full pl-10" placeholder="Search by companies" v-model.lazy="search" @input="searchDeals" />
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" v-if="filteredDeals.data && filteredDeals.data.length >= 1">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr class="divide-x divide-gray-200">
                                            <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Assigned To</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Created By</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Stage</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Priority</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Create Date</th>
                                            <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-6">Last Update</th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="deal in filteredDeals.data" :key="deal.id" class="divide-x divide-gray-200">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-semibold link sm:pl-6">
                                                <a :href="route('deals.show', deal.id)">
                                                    {{ deal.name }}
                                                </a>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                                                <div class="flex">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" :src="deal.owned_by.profile_photo_url" alt="{{ deal.owned_by.name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ deal.owned_by.name }}</div>
                                                        <div class="text-gray-500">{{ deal.owned_by.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                                                <div class="flex">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" :src="deal.created_by.profile_photo_url" alt="{{ deal.created_by.name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ deal.created_by.name }}</div>
                                                        <div class="text-gray-500">{{ deal.created_by.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ deal.type }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ deal.stage }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ deal.priority }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ new Date(deal.created_at).toDateString() }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">{{ new Date(deal.updated_at).toDateString() }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="max-w-3xl mx-auto" v-else>
                                    <div class="text-lg font-semibold mb-2">
                                        No deals match the current filters.
                                    </div>

                                    <div>
                                        Expecting to see new companies? Let the system catchup and try again in a few seconds.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="mt-10">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-800 animate-spin" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <FixedFooterPagination :meta="filteredDeals.meta" v-if="filteredDeals.meta" />
        <ManageDealSlideover :show="creatingDeal" @close="creatingDeal = false" @update="searchDeals" :method-route="route('api.v1.deals.store')"/>
    </FullWidthAppLayout>

</template>
