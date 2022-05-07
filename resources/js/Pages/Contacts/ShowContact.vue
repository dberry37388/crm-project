<script>
    import ThreeColumnLayout from "../../Layouts/ThreeColumnLayout";
    import { Link } from '@inertiajs/inertia-vue3';
    import {ChevronLeftIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/solid"
    import SidebarAttribute from "../../Components/SidebarAttribute";
    import ConfirmDeleteContactModal from "./Modals/ConfirmDeleteContactModal";
    import UpdateContactModal from "./Modals/UpdateContactModal";

    export default {
        props: {
            contact: {
                type: Object,
                required: true
            }
        },

        components: {
            UpdateContactModal,
            ConfirmDeleteContactModal,
            SidebarAttribute, ChevronLeftIcon, Link, PencilAltIcon, ThreeColumnLayout, TrashIcon},

        data() {
            return {
                currentContact: this.contact.data,
                updatingContact: false,
                deletingContact: false
            }
        },

        methods: {
            refreshCompany() {
                axios.get(route('api.v1.contacts.show', this.contact.data.id))
                    .then((r) => {
                        this.currentContact = r.data.data;
                    })
            },
        }
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
                    <SidebarAttribute label="Assigned To" :content="currentContact.assigned_to.name" />
                    <SidebarAttribute label="Created By" :content="currentContact.created_by.name" />
                    <SidebarAttribute label="Email" :content="currentContact.email" />
                    <SidebarAttribute label="Job Title" :content="currentContact.job_title" />
                    <SidebarAttribute label="Phone Number" :content="currentContact.phone_number" />
                    <SidebarAttribute label="Mobile Number" :content="currentContact.mobile_number" />
                    <SidebarAttribute label="Description" :content="currentContact.description ?? ''" />
                </div>
            </div>

            <UpdateContactModal v-if="updatingContact" :show="updatingContact" @close="updatingContact = false" :contact="currentContact" @updated="refreshCompany" />
            <ConfirmDeleteContactModal v-if="deletingContact" :show="deletingContact" @close="deletingContact = false" :contact="currentContact" />
        </template>
    </ThreeColumnLayout>
</template>
