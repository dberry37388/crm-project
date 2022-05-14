<script>
import Button from "../../Jetstream/Button";
import FullWidthAppLayout from "../../Layouts/FullWidthAppLayout";
import FixedFooterPagination from "../../Components/FixedFooterPagination";
import Input from "../../Jetstream/Input";
import {SearchIcon, ChevronDownIcon} from '@heroicons/vue/solid'
import ManageCompanySlideover from "../../Components/Companies/ManageCompanySlideover";
import Company from "../../Models/Company";
import TableHeader from "../../Components/Table/TableHeader";
import {Switch, SwitchGroup, SwitchLabel} from "@headlessui/vue";
import TeamUserComboBoxMulti from "../../Components/TeamUserComboBoxMulti";

export default {
    props: {
        companies: {},
    },

    components: {
        TeamUserComboBoxMulti,
        SwitchLabel,
        Switch,
        SwitchGroup,
        TableHeader,
        ManageCompanySlideover, Input, FixedFooterPagination, FullWidthAppLayout, Button, SearchIcon, ChevronDownIcon},

    data() {
        return {
            activeHeader: 'name',
            filteredCompanies: this.searchCompanies(),
            creatingCompany: false,
            search: '',
            loading: false,
            currentOrderBy: 'name',
            currentOrderByDirection: '',
            searchCreatedBy: false,
            searchAssignedTo: false,

        }
    },

    watch: {
        searchCreatedBy(value) {
            this.searchCompanies()
        },

        searchAssignedTo(value) {
            this.searchCompanies()
        }
    },

    methods: {
        searchCompanies: _.debounce((async function (e) {
            this.loading = true;

            await Company
                .orderBy(this.currentOrderByDirection + this.currentOrderBy)
                .where(['name', 'city'], this.search)
                .where('assigned_to_id', this.searchAssignedTo ? this.searchAssignedTo.id : '')
                .where('created_by_id', this.searchCreatedBy ? this.searchCreatedBy.id : '')
                .get()
                .then((r) => {
                    console.log(r.meta);
                    this.filteredCompanies = r;
                    this.loading = false;
                })
        }), 500),

        sort(s) {
            //if s == current sort, reverse
            if(s === this.currentOrderBy) {
                this.currentOrderByDirection = this.currentOrderByDirection === '' ? '-' : '';
            }

            this.currentOrderBy = s;
            this.searchCompanies();
        }
    },

}
</script>

<template>
    <FullWidthAppLayout>
        <template #header>
            <div class="flex items-center justify-between">
               <div>
                   <h2 class="font-bold text-xl text-gray-800 leading-tight">
                       Companies
                   </h2>
               </div>

                <div>
                    <Button type="button" @click="creatingCompany = true">Create Company</Button>
                </div>
            </div>
        </template>

        <div class="pt-5 pb-32">
            <div class="sm:px-6 lg:px-5">
                <div v-if="!loading">
                    <div class="flex items-center justify-start gap-5">
                        <div>
                            <div class="text-sm font-semibold">Wildcard Search</div>
                            <div class="relative rounded-md shadow-sm w-full">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <SearchIcon class="h-6 w-6 text-gray-400" aria-hidden="true" />
                                </div>
                                <Input type="text" class="w-full pl-10 text-sm" placeholder="Search by companies" v-model.lazy="search" @input="searchCompanies" />
                            </div>
                        </div>

                        <div>
                            <div class="relative rounded-md shadow-sm w-full">
                                <TeamUserComboBoxMulti label="Assigned To" v-model="searchAssignedTo" />
                            </div>
                        </div>

                        <div>
                            <div class="relative rounded-md shadow-sm w-full">
                                <TeamUserComboBoxMulti label="Created By" v-model="searchCreatedBy" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" v-if="filteredCompanies && filteredCompanies.data.length >= 1">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr class="divide-x divide-gray-200">
                                            <TableHeader name="Name" :selected="currentOrderBy === 'Name'" :order="currentOrderByDirection" class="py-3.5 pl-4 pr-4 sm:pl-6" @update="sort('name')" />
                                            <TableHeader name="Assigned To" :selected="currentOrderBy === 'Assigned To'" @update="sort('assignedTo.name')" class="px-4 py-3.5" />
                                            <TableHeader name="Created By" :selected="currentOrderBy === 'Created By'" @update="sort('createdBy.name')" class="px-4 py-3.5" />
                                            <TableHeader name="City" :selected="currentOrderBy === 'City'" @update="sort('city')" class="px-4 py-3.5" />
                                            <TableHeader name="State" :selected="currentOrderBy === 'State'" @update="sort('state')" class="px-4 py-3.5" />
                                            <TableHeader name="Industry" :selected="currentOrderBy === 'Industry'" @update="sort('industry.name')" class="px-4 py-3.5" />
                                            <TableHeader name="Date Created" :selected="currentOrderBy === 'Date Created'" @update="sort('created_at')" class="px-4 py-3.5" />
                                            <TableHeader name="Last Update" :selected="currentOrderBy === 'Last Update'" @update="sort('updated_at')" class="px-4 py-3.5" />
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="company in filteredCompanies.data" :key="company.id" class="divide-x divide-gray-200">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-semibold link sm:pl-6">
                                                <a :href="route('companies.show', company.id)">
                                                    {{ company.name }}
                                                </a>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                                                <div class="flex">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" :src="company.assigned_to.profile_photo_url" alt="{{ company.assigned_to.name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ company.assigned_to.name }}</div>
                                                        <div class="text-gray-500">{{ company.assigned_to.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                                                <div class="flex">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" :src="company.created_by.profile_photo_url" alt="{{ company.created_by.name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ company.created_by.name }}</div>
                                                        <div class="text-gray-500">{{ company.created_by.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ company.city }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ company.state }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ company.industry ? company.industry.name : '' }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ new Date(company.created_at).toDateString() }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">{{ new Date(company.updated_at).toDateString() }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="max-w-3xl mx-auto" v-else>
                                    <div class="text-lg font-semibold mb-2">
                                        No companies match the current filters.
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

        <FixedFooterPagination :meta="filteredCompanies.meta" v-if="filteredCompanies" />

        <ManageCompanySlideover
            :show="creatingCompany"
            :model-route="route('api.v1.companies.store')"
            @close="creatingCompany = false"
            @update="searchCompanies"
        />
    </FullWidthAppLayout>
</template>
