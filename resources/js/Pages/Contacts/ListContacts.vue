<script>
import Button from "../../Jetstream/Button";
import FullWidthAppLayout from "../../Layouts/FullWidthAppLayout";
import Pagination from "../../Components/Pagination";
import FixedFooterPagination from "../../Components/FixedFooterPagination";
import {SearchIcon} from '@heroicons/vue/solid'
import Input from "../../Jetstream/Input";
import CreateNewContactSlideover from "../../Components/Contacts/CreateNewContactSlideover";
import Contact from "../../Models/Contact";
import TableHeader from "../../Components/Table/TableHeader";
import TeamUserComboBoxMulti from "../../Components/TeamUserComboBoxMulti";

export default {
    props: {
        contacts: {},
    },

    components: {
        TeamUserComboBoxMulti,
        TableHeader,
        CreateNewContactSlideover, Input, FixedFooterPagination, Pagination, FullWidthAppLayout, Button, SearchIcon},

    data() {
        return {
            filteredContacts: null,
            creatingContact: false,
            search: '',
            loading: true,
            currentOrderBy: 'first_name',
            currentOrderByDirection: '',
            searchCreatedBy: false,
            searchAssignedTo: false,
            currentPage: 1
        }
    },

    watch: {
        searchCreatedBy(value) {
            this.currentPage = 1;
            this.searchContacts()
        },

        searchAssignedTo(value) {
            this.currentPage = 1;
            this.searchContacts()
        }
    },

    created() {
        this.searchContacts()
    },

    methods: {
        searchContacts: _.debounce((async function (e) {
            this.loading = true;

            await Contact
                .orderBy(this.currentOrderByDirection + this.currentOrderBy)
                .where("search_by_name", this.search)
                .where('assigned_to_id', this.searchAssignedTo ? this.searchAssignedTo.id : '')
                .where('created_by_id', this.searchCreatedBy ? this.searchCreatedBy.id : '')
                .page(this.currentPage)
                .get()
                .then((r) => {
                    this.filteredContacts = r;
                    this.loading = false;
                })
        }), 500),

        changePage(page) {
            this.currentPage = parseInt(page);
            this.searchContacts();
        },

        sort(s) {
            //if s == current sort, reverse
            if(s === this.currentOrderBy) {
                this.currentOrderByDirection = this.currentOrderByDirection === '' ? '-' : '';
            }

            this.currentPage = 1;
            this.currentOrderBy = s;
            this.searchContacts();
        }
    }
}
</script>

<template>
    <FullWidthAppLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="flex items-center justify-start gap-5">
                    <div>
                        <div class="text-sm font-semibold">Wildcard Search</div>
                        <div class="relative rounded-md shadow-sm w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <SearchIcon class="h-6 w-6 text-gray-400" aria-hidden="true" />
                            </div>
                            <Input type="text" class="w-full pl-10 text-sm" placeholder="Search contacts" v-model.lazy="search" @input="searchContacts" />
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

                <div>
                    <Button type="button" @click="creatingContact = true">Create Contact</Button>
                </div>
            </div>
        </template>

        <div class="pt-5 pb-32">
            <div class="sm:px-6 lg:px-8">
                <div v-if="!loading">
                    <div class="mt-5 flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" v-if="filteredContacts.data && filteredContacts.data.length >= 1">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr class="divide-x divide-gray-200">
                                            <TableHeader name="First Name" :selected="currentOrderBy === 'first_name'" :order="currentOrderByDirection" class="py-3.5 pl-4 pr-4 sm:pl-6" @update="sort('first_name')" />
                                            <TableHeader name="Last Name" :selected="currentOrderBy === 'last_name'" :order="currentOrderByDirection" class="px-4 py-3.5" @update="sort('last_name')" />
                                            <TableHeader name="Assigned To" :selected="currentOrderBy === 'assignedTo.name'" @update="sort('assignedTo.name')" class="px-4 py-3.5" />
                                            <TableHeader name="Created By" :selected="currentOrderBy === 'createdBy.name'" @update="sort('createdBy.name')" class="px-4 py-3.5" />
                                            <TableHeader name="Email" :selected="currentOrderBy === 'email'" :order="currentOrderByDirection" class="px-4 py-3.5" @update="sort('email')" />
                                            <TableHeader name="Job Title" :selected="currentOrderBy === 'job_title'" :order="currentOrderByDirection" class="px-4 py-3.5" @update="sort('job_title')" />
                                            <TableHeader name="Phone Number" :selected="currentOrderBy === 'phone_number'" :order="currentOrderByDirection" class="px-4 py-3.5" @update="sort('phone_number')" />
                                            <TableHeader name="Mobile Number" :selected="currentOrderBy === 'mobile_number'" :order="currentOrderByDirection" class="px-4 py-3.5" @update="sort('mobile_number')" />
                                            <TableHeader name="Date Created" :selected="currentOrderBy === 'created_at'" @update="sort('created_at')" class="px-4 py-3.5" />
                                            <TableHeader name="Last Update" :selected="currentOrderBy === 'updated_at'" @update="sort('updated_at')" class="px-4 py-3.5" />
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="contact in filteredContacts.data" :key="contact.id" class="divide-x divide-gray-200">
                                            <!-- Name -->
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-semibold link sm:pl-6">
                                                <a :href="route('contacts.show', contact.id)">
                                                    {{ contact.first_name }}
                                                </a>
                                            </td>

                                            <!-- Last Name -->
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-semibold link sm:pl-6">
                                                <a :href="route('contacts.show', contact.id)">
                                                    {{ contact.last_name }}
                                                </a>
                                            </td>

                                            <!-- Assigned To -->
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                                                <div class="flex" v-if="contact.assigned_to.name">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" :src="contact.assigned_to.profile_photo_url" alt="{{ contact.assigned_to.name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ contact.assigned_to.name }}</div>
                                                        <div class="text-gray-500">{{ contact.assigned_to.email }}</div>
                                                    </div>
                                                </div>

                                                <div v-else>
                                                    Unassigned
                                                </div>
                                            </td>

                                            <!-- Created By -->
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                                                <div class="flex">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" :src="contact.created_by.profile_photo_url" alt="{{ contact.created_by.name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ contact.created_by.name }}</div>
                                                        <div class="text-gray-500">{{ contact.created_by.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ contact.email }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ contact.job_title }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ contact.phone_number }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ contact.mobile_number }}</td>
                                            <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ new Date(contact.created_at).toDateString() }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">{{ new Date(contact.updated_at).toDateString() }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="max-w-3xl mx-auto" v-else>
                                    <div class="text-lg font-semibold mb-2">
                                        No contacts match the current filters.
                                    </div>

                                    <div>
                                        Expecting to see new contacts? Let the system catchup and try again in a few seconds.
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

        <FixedFooterPagination
            v-if="!loading && filteredContacts.meta"
            :meta="filteredContacts.meta"
            @update="changePage"
        />

        <CreateNewContactSlideover
            v-if="creatingContact"
            :show="creatingContact"
            :model-route="route('api.v1.contacts.store')"
            @close="creatingContact = false"
            @update="searchContacts" />
    </FullWidthAppLayout>
</template>
