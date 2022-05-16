<script setup>

import {DialogTitle} from "@headlessui/vue";
import { XIcon } from '@heroicons/vue/outline'
import SlideoverWithTitle from "../../Components/Slideovers/SlideoverWithTitle";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import Label from "../../Jetstream/Label";
import Input from "../../Jetstream/Input";
import InputError from "../../Jetstream/InputError";
import TeamUserComboBox from "../../Components/TeamUserComboBox";
import {useForm} from "@inertiajs/inertia-vue3";
import TextArea from "../../Components/TextArea";
import IndustriesComboBox from "../IndustriesComboBox";

const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    modelRoute: {
        type: String,
        default: null,
    },
    associatingContact: {
        type: Boolean,
        default: false
    },
    company: {
        type: Object,
        default: null
    }
});

const emit = defineEmits(['close', 'update']);

const form = useForm({
    processing: false,
    _method: props.company ? 'PUT' : 'POST',
    name: props.company ? props.company.name : '',
    city: props.company ? props.company.city : '',
    state: props.company ? props.company.state : '',
    postal_code: props.company ? props.company.postal_code : '',
    timezone: props.company ? props.company.timezone : '',
    number_of_employees: props.company ? props.company.number_of_employees : '',
    assigned_to: props.company ? props.company.assigned_to : '',
    industry: props.company ? props.company.industry : '',
    description: props.company ? props.company.description : '',
})

const saveForm = () => {
    form.processing = true;

    form.post(props.modelRoute, {
        errorBag: 'createContact',
        preserveScroll: true,
        onSuccess: () => closeSlideover(true),
    })
}

const closeSlideover = (shouldRefreshParent = false) => {
    if (!props.company) {
        form.reset();
    }

    if (shouldRefreshParent) {
        emit('update');
    }

    emit('close');
};

</script>

<template>
    <SlideoverWithTitle :show="show">
        <template #header>
            <DialogTitle class="text-lg font-bold text-white">
                <div v-if="company && !company.id">
                    Create Company
                </div>

                <div v-else-if="company && company.id">
                    Update Company
                </div>

                <div v-else>
                    Associate a New Company
                </div>
            </DialogTitle>

            <div class="ml-3 flex h-7 items-center">
                <button type="button" class="rounded-md bg-gray-900 text-gray-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="closeSlideover">
                    <span class="sr-only">Close panel</span>
                    <XIcon class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>
        </template>

        <template #content>
            <div class="space-y-6 pt-6 pb-5">
                <div>
                    <div v-if="!company">
                        Use the form below to create a new contact.
                    </div>

                    <div v-else>
                        Use the form below to create a new contact that will be associated with this resource.
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <Label for="form.name" :required="true" required>Company Name</Label>
                        <Input v-model="form.name" type="text" class="mt-1 block w-full" placeholder="Company Name"/>
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="w-3/4">
                        <TeamUserComboBox label="Assigned User" v-model="form.assigned_to" :selected="form.assigned_to" />
                    </div>

                    <div class="w-3/4">
                        <IndustriesComboBox v-model="form.industry" :selected="form.industry" />
                    </div>

                    <div>
                        <Label for="form.city">City</Label>
                        <Input v-model="form.city" type="text" class="mt-1 block w-full" placeholder="City"/>
                        <InputError :message="form.errors.city" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.state">State</Label>
                        <Input v-model="form.state" type="text" class="mt-1 block w-full" placeholder="State"/>
                        <InputError :message="form.errors.state" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.postal_code">Postal Code</Label>
                        <Input v-model="form.postal_code" type="text" class="mt-1 block w-full" placeholder="Postal Code"/>
                        <InputError :message="form.errors.postal_code" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.timezone">Timezone</Label>
                        <Input v-model="form.timezone" type="text" class="mt-1 block w-full" placeholder="Timezone"/>
                        <InputError :message="form.errors.timezone" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.number_of_employees">Number of Employees</Label>
                        <Input v-model="form.number_of_employees" type="text" class="mt-1 block w-full" placeholder="Number of Employees"/>
                        <InputError :message="form.errors.number_of_employees" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.number_of_employees">Description</Label>
                        <TextArea v-model="form.description" type="text" class="mt-1 block w-full" placeholder="Description"/>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <div class="flex gap-3">
                <SecondaryButton type="button" @click="closeSlideover">Cancel</SecondaryButton>
                <Button type="button" @click="saveForm" :disabled="form.processing">Save</Button>
            </div>
        </template>
    </SlideoverWithTitle>
</template>
