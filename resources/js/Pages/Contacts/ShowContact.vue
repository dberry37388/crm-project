<script>
    import ThreeColumnLayout from "../../Layouts/ThreeColumnLayout";
    import { Link } from '@inertiajs/inertia-vue3';
    import {ChevronLeftIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/solid"
    import SidebarAttribute from "../../Components/SidebarAttribute";
    import CompanyDisclosure from "../../Components/Companies/CompanyDisclosure";
    import Button from "../../Jetstream/Button";
    import Slideover from "../../Components/Slideovers/Slideover";
    import UpdateContactSlideover from "../../Components/Contacts/UpdateContactSlideover";
    import ListNotes from "../../Components/Notes/ListNotes";
    import ActivityTabs from "../../Components/ActivityTabs";
    import ConfirmDeleteContactModal from "../../Components/Contacts/ConfirmDeleteContactModal"
    import DealDisclosure from "../../Components/Deals/DealDisclosure";
    import _ from "lodash";

    export default {
        props: {
            contact: {
                type: Object,
                required: true
            }
        },

        components: {
            DealDisclosure,
            ActivityTabs,
            ListNotes,
            UpdateContactSlideover,
            Slideover,
            Button,
            CompanyDisclosure,
            ConfirmDeleteContactModal,
            SidebarAttribute, ChevronLeftIcon, Link, PencilAltIcon, ThreeColumnLayout, TrashIcon},

        data() {
            return {
                currentContact: this.contact.data,
                updatingContact: false,
                deletingContact: false,
                showingSlideover: false
            }
        },

        methods: {
            refreshContact() {
                axios.get(route('api.v1.contacts.show', this.contact.data.id))
                    .then((r) => {
                        this.currentContact = r.data.data;
                    })
            },

            get(theObject, valuePath, defaultValue = '') {
                return _.get(theObject, valuePath, defaultValue)
            }
        },
    }
</script>

<template>
    <ThreeColumnLayout>
        <template #leftColumn>
            <div v-if="contact">
                <div class="border-b border-gray-200 p-5">
                    <div class="mb-6">
                        <Link :href="route('contacts.list')">
                            <div class="flex gap-2 justify-start items-center">
                                <ChevronLeftIcon class="h-4 w-4 text-orange-600" />

                                <span class="text-xs font-bold text-orange-600">
                                    Contacts
                                </span>
                            </div>
                        </Link>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="font-bold font-semibold">
                            {{ currentContact.first_name }} {{ currentContact.last_name }}
                        </div>

                        <div class="flex gap-1">
                            <PencilAltIcon class="h-6 w-6 cursor-pointer" @click="updatingContact = true" />
                            <TrashIcon class="h-6 w-6 cursor-pointer text-red-500" @click="deletingContact = true" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 p-5">
                    <SidebarAttribute label="Assigned To" :content="get(currentContact, 'assigned_to.name')" />
                    <SidebarAttribute label="Created By" :content="get(currentContact, 'created_by.name')" />
                    <SidebarAttribute label="Email" :content="get(currentContact, 'email')" />
                    <SidebarAttribute label="Job Title" :content="get(currentContact, 'job_title')"/>
                    <SidebarAttribute label="Phone Number" :content="get(currentContact, 'phone_number')" />
                    <SidebarAttribute label="Mobile Number" :content="get(currentContact, 'mobile_number')"/>
                    <SidebarAttribute label="Description" :content="get(currentContact, 'description')" />
                </div>
            </div>


            <UpdateContactSlideover v-if="updatingContact" :show="updatingContact" @close="updatingContact = false" :contact="currentContact" @update="refreshContact" />
            <ConfirmDeleteContactModal v-if="deletingContact" :show="deletingContact" @close="deletingContact = false" :contact="currentContact" />
        </template>

        <!-- section Middle -->
        <template #middleColumn>
            <div class="p-5">
                <ActivityTabs
                    :model-id="currentContact.id"
                    :note-list-route="route('api.v1.contact.list-notes', currentContact.id)"
                    :note-store-route="route('api.v1.contact.store-note', currentContact.id)"
                    :task-list-route="route('api.v1.contact.tasks.list', currentContact.id)"
                    :task-store-route="route('api.v1.contact.tasks.store', currentContact.id)"
                />
            </div>
        </template>

        <template #rightColumn>
            <div class="p-5 border-b border-gray-200" v-if="currentContact">
                <CompanyDisclosure
                    resource-type="contact"
                    :model-route="route('api.v1.contact.companies.list', currentContact.id)"
                    :default-open="true"
                    :model-id="currentContact.id"
                />
            </div>

            <div class="p-5 border-b border-gray-200" v-if="currentContact">
                <DealDisclosure
                    resource-type="contact"
                    :model-route="route('api.v1.contact.deals.list', currentContact.id)"
                    :default-open="true"
                    :model-id="currentContact.id"
                />
            </div>
        </template>
    </ThreeColumnLayout>
</template>
