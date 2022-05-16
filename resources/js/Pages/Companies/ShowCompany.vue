<script>
import ThreeColumnLayout from "../../Layouts/ThreeColumnLayout";
import {ChevronLeftIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/solid"
import { Link } from '@inertiajs/inertia-vue3';
import SidebarAttribute from "../../Components/SidebarAttribute";
import TeamUserComboBox from "../../Components/TeamUserComboBox";
import ConfirmDeleteCompanyModal from "../../Components/Companies/ConfirmDeleteCompanyModal";
import ContactDisclosure from "../../Components/Contacts/ContactDisclosure";
import NoteBlock from "../../Components/Notes/NoteBlock";
import ManageNoteSlideover from "../../Components/Notes/ManageNoteSlideover";
import Button from "../../Jetstream/Button";
import ListNotes from "../../Components/Notes/ListNotes";
import ActivityTabs from "../../Components/ActivityTabs";
import ManageCompanySlideover from "../../Components/Companies/ManageCompanySlideover";
import DealDisclosure from "../../Components/Deals/DealDisclosure";

export default {
    props: {
        company: {
            type: Object,
            required: true
        }
    },

    components: {
        DealDisclosure,
        ManageCompanySlideover,
        ActivityTabs,
        ListNotes,
        Button,
        ManageNoteSlideover,
        NoteBlock,
        ContactDisclosure,
        ConfirmDeleteCompanyModal,
        TeamUserComboBox,
        SidebarAttribute, ChevronLeftIcon, Link, PencilAltIcon, ThreeColumnLayout, TrashIcon},

    data() {
        return {
            currentCompany: this.company.data,
            updatingCompany: false,
            deletingCompany: false,
            managingNote: false,
            notes: null,
        }
    },

    methods: {
        refreshCompany() {
            axios.get(route('api.v1.companies.show', this.company.data.id))
                .then((r) => {
                    this.currentCompany = r.data.data;
                    this.notes = this.currentCompany.notes;
                })
        },

        companyDeleted() {
            window.location.href = route('companies.list');
        },

        get(theObject, path, defaultValue = '') {
            return _.get(theObject, path, defaultValue);
        },
    }
}
</script>

<template>
    <ThreeColumnLayout>
        <!-- section Left -->
        <template #leftColumn>
            <div v-if="company">
                <div class="border-b border-gray-200 p-5">
                    <div class="mb-6">
                        <Link :href="route('companies.list')">
                            <div class="flex gap-2 justify-start items-center">
                                <ChevronLeftIcon class="h-4 w-4 text-orange-600" />

                                <span class="text-xs font-bold text-orange-600">
                                    Companies
                                </span>
                            </div>
                        </Link>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="font-bold font-semibold">
                            {{ currentCompany.name }}
                        </div>

                        <div class="flex gap-1">
                            <PencilAltIcon class="h-6 w-6 cursor-pointer" @click="updatingCompany = true" />
                            <TrashIcon class="h-6 w-6 cursor-pointer text-red-500" @click="deletingCompany = true" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 p-5">
                    <SidebarAttribute label="Assigned To" :content="get(currentCompany, 'assigned_to.name', '--')" />
                    <SidebarAttribute label="Created By" :content="get(currentCompany, 'created_by.name')" />
                    <SidebarAttribute label="Industry" :content="get(currentCompany, 'industry.name', '--')" />
                    <SidebarAttribute label="City" :content="get(currentCompany, 'city')" />
                    <SidebarAttribute label="State" :content="get(currentCompany,'state')" />
                    <SidebarAttribute label="Postal Code" :content="get(currentCompany, 'postal_code')" />
                    <SidebarAttribute label="Timezone" :content="get(currentCompany, 'timezone')" />
                    <SidebarAttribute label="Number of Employees" :content="get(currentCompany, 'number_of_employees')" />
                    <SidebarAttribute label="Description" :content="get(currentCompany, 'description')" class="max-w-" />
                </div>
            </div>

            <ManageCompanySlideover
                :show="updatingCompany"
                :model-route="route('api.v1.companies.update', currentCompany.id)"
                @close="updatingCompany = false"
                @update="refreshCompany"
                :company="currentCompany"
                v-if="currentCompany" />

            <ConfirmDeleteCompanyModal v-if="deletingCompany" :show="deletingCompany" @close="deletingCompany = false" :company="currentCompany" @update="companyDeleted" />

        </template>

        <!-- section Middle -->
        <template #middleColumn>

            <div class="p-5">
                <ActivityTabs
                    :model-id="currentCompany.id"
                    :note-list-route="route('api.v1.company.list-notes', currentCompany.id)"
                    :note-store-route="route('api.v1.company.store-note', currentCompany.id)"
                    :task-list-route="route('api.v1.company.tasks.list', currentCompany.id)"
                    :task-store-route="route('api.v1.company.tasks.store', currentCompany.id)"
                />
            </div>
        </template>

        <!-- section Right -->
        <template #rightColumn>
            <div class="p-5 border-b border-gray-200" v-if="currentCompany">
                <ContactDisclosure
                    resource-type="company"
                    :model-route="route('api.v1.company.contacts.list', company.data.id)"
                    :default-open="true"
                    :model-id="company.data.id"
                />
            </div>

            <div class="p-5 border-b border-gray-200" v-if=" company">
                <DealDisclosure
                    resource-type="company"
                    :model-route="route('api.v1.company.deals.list',  company.data.id)"
                    :default-open="true"
                    :model-id="company.data.id"
                />
            </div>
        </template>
    </ThreeColumnLayout>
</template>
