<script>
import Input from "../../../Jetstream/Input";
import Button from "../../../Jetstream/Button";
import { CogIcon, ChevronDownIcon, SearchIcon, UserAddIcon, PencilAltIcon } from '@heroicons/vue/solid'
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import CreateContactModal from "../Modals/CreateContactModal";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        DisclosurePanel,
        DisclosureButton,
        Disclosure,
        CreateContactModal,
        Button,
        ChevronDownIcon,
        CogIcon,
        Input,
        Link,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        PencilAltIcon,
        SearchIcon,
        SecondaryButton,
        UserAddIcon,
    },

    props: {
        companyId: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            search: '',
            contacts: {},
            addingContact: false,
            showingContactDetailsPanel: false,
        }
    },

    created() {
        this.searchContacts();
    },

    methods: {
        searchContacts: _.debounce((async function (e) {
            await axios.get(route('api.v1.company.list-contacts', {company: this.companyId}))
                .then((r) => {
                    console.log(r.data);
                    this.contacts = r.data.data
                })
        }), 300),

        closeAddModal() {
            this.searchContacts();
            this.addingContact = false;
        },

        openContact(contact) {
            alert(contact.data.first_name)
        }
    },
}
</script>

<template>
    <Disclosure v-slot="{ open }">
        <DisclosureButton as="div" class="flex items-center justify-between">
            <div class="flex justify-between gap-4">
                <div class="flex gap-4">
                    <span class="ml-6 flex items-center">
                        <ChevronDownIcon :class="[open ? '-rotate-180' : 'rotate-0', 'h-5 w-5 transform']" aria-hidden="true" />
                    </span>

                    <span class="font-semibold text-gray-900">
                        Contacts
                    </span>
                </div>
            </div>
        </DisclosureButton>

        <!-- Use the built-in <transition> component to add transitions. -->
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-out"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <DisclosurePanel class="h-75 overflow-auto">
                <div class="sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="relative rounded-md shadow-sm w-full">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <SearchIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                    <Input type="text" class="w-full pl-10" placeholder="Search by a contacts first or last name, or by their email address" v-model.lazy="search" @input="searchContacts" />
                                </div>

                                <div class="flex">
                                    <div>
                                        <SecondaryButton type="button" @click="addingContact = true" @cancel="searchContacts">
                                            <div class="flex">
                                                <UserAddIcon class="h-5 w-5 text-primary" />
                                            </div>
                                        </SecondaryButton>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 mt-5">
                                <div class="border border-gray-200 p-3" v-for="contact in contacts" :key="contact.id" v-if="contacts">
                                    <div class="text-sm font-medium mb-1 link">
                                        <Link :href="route('contacts.show', contact.id)">
                                            {{ contact.first_name }} {{ contact.last_name }}
                                        </Link>
                                    </div>

                                    <div class="text-sm mb-1">
                                        {{ contact.email }}
                                    </div>

                                    <div class="text-sm">
                                        {{ contact.phone_number }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </DisclosurePanel>
        </transition>

        <CreateContactModal :show="addingContact" :company-id="companyId"  @close="closeAddModal" v-if="companyId"/>
    </Disclosure>
</template>
