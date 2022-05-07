<script>
import DefaultLayout from "../../Layouts/DefaultLayout";
import Button from "../../Jetstream/Button";
import FullWidthAppLayout from "../../Layouts/FullWidthAppLayout";
import CreateCompanyModal from "./Modals/CreateCompanyModal";
export default {
    props: {
        companies: {},
    },

    components: {CreateCompanyModal, FullWidthAppLayout, Button},

    data() {
        return {
            creatingCompany: false
        }
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
            <div class="p-5 sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
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
                                    <tr v-for="company in companies.data" :key="company.id" class="divide-x divide-gray-200">
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
                                        <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ company.industry.name }}</td>
                                        <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ new Date(company.created_at).toDateString() }}</td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">{{ new Date(company.updated_at).toDateString() }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <CreateCompanyModal v-if="creatingCompany" :show="creatingCompany" @close="creatingCompany = false" />
    </FullWidthAppLayout>
</template>
