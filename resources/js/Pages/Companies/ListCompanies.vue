<script>
import Button from "../../Jetstream/Button";
import FullWidthAppLayout from "../../Layouts/FullWidthAppLayout";
import FixedFooterPagination from "../../Components/FixedFooterPagination";
import Input from "../../Jetstream/Input";
import {SearchIcon} from '@heroicons/vue/solid'
import ManageCompanySlideover from "../../Components/Companies/ManageCompanySlideover";
export default {
    props: {
        companies: {},
    },

    components: {ManageCompanySlideover, Input, FixedFooterPagination, FullWidthAppLayout, Button, SearchIcon},

    data() {
        return {
            filteredCompanies: this.companies,
            creatingCompany: false,
            search: '',
            loading: false
        }
    },

    methods: {
        searchCompanies: _.debounce((function (e) {
            this.loading = true;
            const params = {
                search: this.search
            };

            this.filteredCompanies = axios.get(route('api.v1.companies.index'), {params})
                .then((r) => {
                    this.filteredCompanies = r.data;
                    this.loading = false;
                })
        }), 500),
    }
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

        <div class="py-5">
            <div class="sm:px-6 lg:px-5">
                <div v-if="!loading">
                    <div class="flex items-center justify-start gap-5">
                        <div class="relative rounded-md shadow-sm w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <SearchIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <Input type="text" class="w-full pl-10" placeholder="Search by companies" v-model.lazy="search" @input="searchCompanies" />
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" v-if="filteredCompanies.data && filteredCompanies.data.length >= 1">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr class="divide-x divide-gray-200">
                                            <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Assigned To</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Created By</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">City</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">State</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Industry</th>
                                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Create Date</th>
                                            <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-6">Last Update</th>
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

        <FixedFooterPagination :meta="filteredCompanies.meta" v-if="filteredCompanies.meta" />

        <ManageCompanySlideover
            :show="creatingCompany"
            :model-route="route('api.v1.companies.store')"
            @close="creatingCompany = false"
            @update="searchCompanies"
        />
    </FullWidthAppLayout>
</template>
