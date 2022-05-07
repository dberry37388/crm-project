<script>
import ThreeColumnLayout from "../../Layouts/ThreeColumnLayout";
import {ChevronLeftIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/solid"
import { Link } from '@inertiajs/inertia-vue3';
import SidebarAttribute from "../../Components/SidebarAttribute";
import UpdateCompanyModal from "./Modals/UpdateCompanyModal";
import TeamUserComboBox from "../../Components/TeamUserComboBox";
import ConfirmDeleteCompanyModal from "./Modals/ConfirmDeleteCompanyModal";
import {Inertia} from "@inertiajs/inertia";

export default {
    props: {
        company: {
            type: Object,
            required: true
        }
    },

    components: {
        ConfirmDeleteCompanyModal,
        TeamUserComboBox,
        UpdateCompanyModal, SidebarAttribute, ChevronLeftIcon, Link, PencilAltIcon, ThreeColumnLayout, TrashIcon},

    data() {
        return {
            currentCompany: this.company.data,
            updatingCompany: false,
            deletingCompany: false
        }
    },

    methods: {
        refreshCompany() {
            axios.get(route('api.v1.companies.show', this.company.data.id))
                .then((r) => {
                    this.currentCompany = r.data.data;
                })
        },

        companyDeleted() {
            window.location.href = route('companies.list');
        }
    }
}
</script>

<template>
    <ThreeColumnLayout>
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
                    <SidebarAttribute label="Assigned To" :content="currentCompany.assigned_to.name" />
                    <SidebarAttribute label="Created By" :content="currentCompany.created_by.name" />
                    <SidebarAttribute label="Industry" :content="currentCompany.industry.name" />
                    <SidebarAttribute label="City" :content="currentCompany.city" />
                    <SidebarAttribute label="State" :content="currentCompany.state" />
                    <SidebarAttribute label="Postal Code" :content="currentCompany.postal_code" />
                    <SidebarAttribute label="Timezone" :content="currentCompany.timezone" />
                    <SidebarAttribute label="Number of Employees" :content="currentCompany.number_of_employees" />
                    <SidebarAttribute label="Description" :content="currentCompany.description" class="max-w-" />
                </div>
            </div>

            <UpdateCompanyModal v-if="updatingCompany" :show="updatingCompany" @close="updatingCompany = false" :company="currentCompany" @updated="refreshCompany" />
            <ConfirmDeleteCompanyModal v-if="deletingCompany" :show="deletingCompany" @close="deletingCompany = false" :company="currentCompany" @updated="companyDeleted" />
        </template>
    </ThreeColumnLayout>
</template>
