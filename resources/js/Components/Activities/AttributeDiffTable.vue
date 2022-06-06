<script setup>

const props = defineProps({
    activity: {
        type: Object,
        required: true
    }
})

const eventTranslator = {
    'assignedTo.name': 'Assigned To',
    'createdBy.name': 'Created By',
    'email': 'Email',
    'first_name': 'First Name',
    'industry.name': 'Industry Name',
    'job_title': 'Job Title',
    'last_name': 'Last Name',
    'mobile_number': 'Mobile Number',
    'number_of_employees': 'Number of Employees',
    'ownedBy.name': 'Owned By',
    'phone_number': 'Phone Number',
    'postal_code': 'Postal Code',
}

function getEventName(event) {
    return _.get(eventTranslator, event, event);
}

</script>

<template>
    <table class="min-w-full divide-y divide-gray-300 table-fixed">
        <thead class="bg-gray-100">
        <tr>
            <th scope="col" class="text-left py-3.5 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">Attribute</th>
            <th scope="col" class="text-left px-3 py-3.5 text-sm font-semibold text-gray-900">Old Value</th>
            <th scope="col" class="text-left relative py-3.5 pl-3 pr-4 sm:pr-6 text-sm font-semibold text-gray-900">New Value</th>
        </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="(value, name, index) in activity.properties.attributes" :key="index" class="hover:bg-yellow-50 text-black">
            <td class="whitespace-nowrap w-48 text-wrap py-4 pl-4 pr-3 text-sm sm:pl-6 capitalize">{{ getEventName(name) }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm">{{ activity.properties.old[name] }}</td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-sm sm:pr-6">{{ value }}</td>
        </tr>
        </tbody>
    </table>
</template>
