<script setup>
import {ref, watch} from "vue";
import {SearchIcon} from "@heroicons/vue/solid";
import FullWidthAppLayout from "../../Layouts/FullWidthAppLayout";
import Button from "../../Jetstream/Button";
import Input from "../../Jetstream/Input";
import FixedFooterPagination from "../../Components/FixedFooterPagination";
import ManageDealSlideover from "../../Components/Deals/ManageDealSlideover";
import Deal from "../../Models/Deal";
import TeamUserComboBoxMulti from "../../Components/TeamUserComboBoxMulti";
import TableHeader from "../../Components/Table/TableHeader";
import PrioritiesListbox from "../../Components/Deals/PrioritiesListbox";
import StagesListbox from "../../Components/Deals/StagesListbox";
import TypeListbox from "../../Components/Deals/TypeListbox";

const filteredDeals = ref(null)
const creatingDeal = ref(false)
const search = ref('')
const loading = ref(true)
let currentOrderBy =  ref('name')
let currentOrderByDirection = ref('')
let searchCreatedBy = ref(false)
let searchOwnedBy = ref(false)
let currentPage = ref(parseInt('1'))
let searchPriority = ref('')
let searchStage = ref('')
let searchType = ref('')

const searchDeals =  _.debounce((async function (e) {
    loading.value = true;

    let ownedBy = searchOwnedBy && searchOwnedBy.id ? searchOwnedBy.id : null;
    let createdBy = _.get(searchCreatedBy, 'id', '');
    let page = parseInt(currentPage.value ?? 1)
    let priority = searchPriority.value === 'Any' ? '' : searchPriority.value;
    let stage = searchStage.value === 'Any' ? '' : searchStage.value;
    let type = searchType.value === 'Any' ? '' : searchType.value;

    await Deal
        .orderBy(currentOrderByDirection.value + currentOrderBy.value)
        .where('name', search.value)
        .where('owned_by_id', searchOwnedBy.value ? searchOwnedBy.value.id : '')
        .where('created_by_id', searchCreatedBy.value ? searchCreatedBy.value.id : '')
        .where('priority', priority)
        .where('stage', stage)
        .where('type', type)
        .page(page)
        .get()
        .then((r) => {
            filteredDeals.value = r;
            loading.value = false;
        })
}), 500)

const sort = (s) => {
    if(s === currentOrderBy.value) {
        currentOrderByDirection.value = currentOrderByDirection.value === '' ? '-' : '';
    }

    currentPage.value = 1;
    currentOrderBy.value = s;
    searchDeals();
}

const changePage = (page) => {
    currentPage.value = parseInt(page);
    searchDeals()
}

const setSearchPriority = (value) => {
    searchPriority.value = value;
    searchDeals()
}

const setSearchStage = (value) => {
    searchStage.value = value;
    searchDeals()
}

const setSearchType = (value) => {
    searchType.value = value;
    searchDeals()
}

watch(searchCreatedBy, (currentValue) => {
    if (currentValue === null) {
        searchCreatedBy = false;
    }
    currentPage = 1;
    searchDeals()
});

watch(searchOwnedBy, (currentValue) => {
    if (currentValue === null) {
        searchOwnedBy = false;
    }
    currentPage = 1;
    searchDeals()
});

searchDeals()

</script>

<template>

    <FullWidthAppLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between gap-5">
                <div class="flex flex-wrap sm:flex-row items-start justify-start sm:items-center sm:justify-start gap-5">
                    <div>
                        <div class="text-sm font-semibold">Wildcard Search</div>
                        <div class="relative rounded-md shadow-sm w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <SearchIcon class="h-6 w-6 text-gray-400" aria-hidden="true" />
                            </div>
                            <Input type="text" class="w-full pl-10 text-sm" placeholder="Search contacts" v-model.lazy="search" @input="searchDeals" />
                        </div>
                    </div>

                    <div>
                        <div class="relative rounded-md shadow-sm w-full">
                            <TeamUserComboBoxMulti label="Owned By" v-model="searchOwnedBy" />
                        </div>
                    </div>

                    <div>
                        <div class="relative rounded-md shadow-sm w-full">
                            <TeamUserComboBoxMulti label="Created By" v-model="searchCreatedBy" />
                        </div>
                    </div>

                    <div>
                        <div class="relative rounded-md shadow-sm w-100 -mt-1">
                            <PrioritiesListbox label="Priority" @update="setSearchPriority"  />
                        </div>
                    </div>

                    <div>
                        <div class="relative rounded-md shadow-sm w-100 -mt-1">
                            <StagesListbox label="Stage" @update="setSearchStage"  />
                        </div>
                    </div>

                    <div>
                        <div class="relative rounded-md shadow-sm w-100 -mt-1">
                            <TypeListbox label="Deal Type" @update="setSearchType"  />
                        </div>
                    </div>
                </div>

                <div>
                    <Button type="button" @click="creatingDeal = true">Create Deal</Button>
                </div>
            </div>
        </template>

        <div class="py-5">
            <div class="sm:px-6 lg:px-5">
                <div v-if="!loading">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" v-if="filteredDeals && filteredDeals.data.length >= 1">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr class="divide-x divide-gray-200">
                                            <TableHeader name="Name" :selected="currentOrderBy === 'name'" :order="currentOrderByDirection" @update="sort('name')" class="px-4 py-3.5" />
                                            <TableHeader name="Owned By" :selected="currentOrderBy === 'ownedBy.name'" :order="currentOrderByDirection" @update="sort('ownedBy.name')" class="px-4 py-3.5" />
                                            <TableHeader name="Created By" :selected="currentOrderBy === 'createdBy.name'" :order="currentOrderByDirection" @update="sort('createdBy.name')" class="px-4 py-3.5" />
                                            <TableHeader name="Type" :selected="currentOrderBy === 'type'" :order="currentOrderByDirection" @update="sort('type')" class="px-4 py-3.5" />
                                            <TableHeader name="Stage" :selected="currentOrderBy === 'stage'" :order="currentOrderByDirection" @update="sort('stage')" class="px-4 py-3.5" />
                                            <TableHeader name="Priority" :selected="currentOrderBy === 'priority'" :order="currentOrderByDirection" @update="sort('priority')" class="px-4 py-3.5" />
                                            <TableHeader name="Date Created" :selected="currentOrderBy === 'created_at'" :order="currentOrderByDirection" @update="sort('created_at')" class="px-4 py-3.5" />
                                            <TableHeader name="Last Update" :selected="currentOrderBy === 'updated_at'" :order="currentOrderByDirection" @update="sort('updated_at')" class="px-4 py-3.5" />
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

        <FixedFooterPagination :meta="filteredDeals.meta" v-if="!loading && filteredDeals.meta" />
        <ManageDealSlideover :show="creatingDeal" @close="creatingDeal = false" @update="searchDeals" :method-route="route('api.v1.deals.store')"/>
    </FullWidthAppLayout>

</template>
