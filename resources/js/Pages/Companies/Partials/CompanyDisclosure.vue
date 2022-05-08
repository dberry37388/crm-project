<script>
import Input from "../../../Jetstream/Input";
import Button from "../../../Jetstream/Button";
import { CogIcon, ChevronDownIcon, SearchIcon, UserAddIcon, PencilAltIcon } from '@heroicons/vue/solid'
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {Link} from "@inertiajs/inertia-vue3";
import Dropdown from "../../../Jetstream/Dropdown";
import DropdownLink from "../../../Jetstream/DropdownLink";
import ConfirmDetachCompanyModal from "../../Contacts/Modals/ConfirmDetachCompanyModal";
import AttachCompanyToContact from "../../Contacts/Slideovers/AttachCompanyToContact";
import CreateNewCompanySlideover from "../Slideovers/CreateNewCompanySlideover";

export default {
    components: {
        CreateNewCompanySlideover,
        AttachCompanyToContact,
        ConfirmDetachCompanyModal,
        DropdownLink,
        Dropdown,
        DisclosurePanel,
        DisclosureButton,
        Disclosure,
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
        contactId: {
            type: Number,
            required: true
        },

        defaultOpen: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            search: '',
            companies: {},
            addingCompany: false,
            detachingCompany: false,
            attachingExistingCompany: false,
            attachingNewCompany: false,
            selectedCompany: {},
            showingContactDetailsPanel: false,
        }
    },

    created() {
        this.searchCompanies();
    },

    methods: {
        searchCompanies: _.debounce((async function (e) {
            await axios.get(route('api.v1.contact.list-companies', {contact: this.contactId}))
                .then((r) => {
                    this.companies = r.data.data
                })
        }), 300),

        selectCompanyToDetach(company) {
            this.selectedCompany = company;
            this.detachingCompany = true;
        }
    },
}
</script>

<template>
    <Disclosure v-slot="{ open }" :default-open="defaultOpen">
        <div class="flex flex-row items-center justify-between">
            <DisclosureButton as="div" class="flex items-center justify-between">
                <div class="flex justify-between gap-4">
                    <div class="flex gap-4">
                    <span class="ml-6 flex items-center">
                        <ChevronDownIcon :class="[open ? '-rotate-180' : 'rotate-0', 'h-5 w-5 transform']" aria-hidden="true" />
                    </span>

                        <span class="font-semibold text-gray-900">
                        Companies
                    </span>
                    </div>
                </div>
            </DisclosureButton>

            <div class="mr-6">
                <Dropdown>
                    <template #trigger>
                        <CogIcon class="h-5 w-7 text-gray-800" />
                    </template>

                    <template #content class="flex flex-col gap-3">
                        <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="attachingNewCompany = true">
                            Associate New Company
                        </div>

                        <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="attachingExistingCompany = true">
                            Associate Existing Company
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>

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
                            <div class="flex flex-col gap-3">
                                <div class="border border-gray-200 p-3" v-for="company in companies" :key="company.id" v-if="companies.length > 0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-medium mb-1 link">
                                                <Link :href="route('companies.show', company.id)">
                                                    {{ company.name }}
                                                </Link>
                                            </div>

                                            <div class="text-sm mb-1">
                                                {{ company.industry.name }}
                                            </div>
                                        </div>

                                        <div>
                                            <dropdown>
                                                <template #trigger>
                                                    <CogIcon class="h-5 w-7 text-gray-800" />
                                                </template>

                                                <template #content>
                                                    <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="selectCompanyToDetach(company)">
                                                        Remove from Company
                                                    </div>
                                                </template>
                                            </dropdown>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12" v-else>
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">It's lonely in here</h3>
                                    <p class="mt-1 text-sm text-gray-500">This contact is not associated with any companies. Let's change that!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </DisclosurePanel>
        </transition>

        <ConfirmDetachCompanyModal :show="detachingCompany" :contact="contactId" :company="selectedCompany" @close="detachingCompany = false" @updated="searchCompanies" />
        <CreateNewCompanySlideover :show="attachingNewCompany" :contact-id="contactId"  @close="attachingNewCompany = false" @update="searchCompanies" v-if="contactId"/>
        <AttachCompanyToContact :contact-id="contactId" :show="attachingExistingCompany" @close="attachingExistingCompany = false" @update="searchCompanies" :closeable="false" />
    </Disclosure>
</template>
