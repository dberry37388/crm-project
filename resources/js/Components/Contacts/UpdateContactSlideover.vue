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
import { maska } from 'maska'

const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    contact: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['close', 'update']);

const form = useForm({
    _method: 'PUT',
    processing: false,
    first_name: props.contact.first_name,
    last_name: props.contact.last_name,
    email: props.contact.email,
    job_title: props.contact.job_title,
    phone_number: props.contact.phone_number,
    mobile_number: props.contact.mobile_number,
    description: props.contact.description,
    assigned_to: props.contact.assigned_to,
})

const saveForm = () => {
    form.processing = true;

    form.post(route('api.v1.contacts.update', props.contact.id), {
            errorBag: 'createContact',
            preserveScroll: true,
            onSuccess: () => closeSlideover(true),
        })
}

const closeSlideover = (shouldRefreshParent = false) => {
    form.reset();

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
                Update {{ contact.first_name }} {{ contact.last_name }}
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
                    <div>
                        Use the form below to update the contact information for {{ contact.first_name }} {{ contact.last_name }}.
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <Label class="font-medium" for="form.name">First Name</Label>
                        <Input v-model="form.first_name" type="text" class="mt-1 block w-full" placeholder="First Name"/>
                        <InputError :message="form.errors.first_name" class="mt-2" />
                    </div>

                    <div>
                        <Label class="font-medium" for="form.name">Last Name</Label>
                        <Input v-model="form.last_name" type="text" class="mt-1 block w-full" placeholder="Last Name"/>
                        <InputError :message="form.errors.last_name" class="mt-2" />
                    </div>

                    <div class="w-3/4">
                        <TeamUserComboBox label="Assigned User" v-model="form.assigned_to" :selected="form.assigned_to" />
                    </div>

                    <div>
                        <Label class="font-medium" for="form.city">Email</Label>
                        <Input v-model="form.email" type="text" class="mt-1 block w-full" placeholder="Email"/>
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <div>
                        <Label class="font-medium" for="form.state">Job Title</Label>
                        <Input v-model="form.job_title" type="text" class="mt-1 block w-full" placeholder="Job Title"/>
                        <InputError :message="form.errors.job_title" class="mt-2" />
                    </div>

                    <div>
                        <Label class="font-medium" for="form.postal_code">Phone Number</Label>
                        <Input v-model="form.phone_number" type="text" class="mt-1 block w-full" placeholder="Phone Number" v-maska="'+1 (###) ###-####'" />
                        <InputError :message="form.errors.phone_number" class="mt-2" />
                    </div>

                    <div>
                        <Label class="font-medium" for="form.timezone">Mobile Number</Label>
                        <Input v-model="form.mobile_number" type="text" class="mt-1 block w-full" placeholder="Mobile Number" v-maska="'+1 (###) ###-####'" />
                        <InputError :message="form.errors.mobile_number" class="mt-2" />
                    </div>

                    <div>
                        <Label class="font-medium" for="form.number_of_employees">Description</Label>
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
