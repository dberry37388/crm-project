<script setup>

import {DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from "@headlessui/vue";
import { XIcon } from '@heroicons/vue/outline'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
import SlideoverWithTitle from "../../Components/Slideovers/SlideoverWithTitle";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import Label from "../../Jetstream/Label";
import InputError from "../../Jetstream/InputError";
import {useForm} from "@inertiajs/inertia-vue3";
import TextArea from "../../Components/TextArea";
import Input from "../../Jetstream/Input";
import TeamUserComboBox from "../TeamUserComboBox";

const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    methodRoute: {
        type: String,
        required: true
    },
    currentTask: {
        type: Object,
        default: null
    }

});

const emit = defineEmits(['close', 'update']);

const form = useForm({
    _method: props.currentTask ? 'PUT' : 'POST',
    processing: false,
    task: props.currentTask ? props.currentTask.task : null,
    notes: props.currentTask ? props.currentTask.notes : null,
    priority: props.currentTask ? props.currentTask.priority : 'Low',
    assigned_to: props.currentTask ? props.currentTask.assigned_to : null,
    due_date: props.currentTask ? props.currentTask.due_date : null,
    completed_at: props.currentTask ? props.currentTask.completed_at : null,
})

const prioritiesList = [
    { name: 'Low', color: '#444444' },
    { name: 'Medium', color: '#f4f4f4' },
    { name: 'High', color: '#fc0000' },
]

const saveForm = () => {
    form.processing = true;

    form.post(props.methodRoute, {
            errorBag: 'manageTask',
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
                <span v-if="currentTask">Edit Task</span>
                <span v-else>Create Task</span>
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
                <div class="flex flex-col gap-6">
                    <div>
                        <Label for="form.notes" class="font-semibold">What needs to be done?</Label>
                        <Input v-model="form.task" type="text" class="mt-1 block w-full" placeholder="e.g. Send a welcome email to Tom."/>
                        <InputError :message="form.errors.task" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.notes" class="font-semibold">Who should do it?</Label>
                        <TeamUserComboBox label="Search for a user." v-model="form.assigned_to" />
                    </div>

                    <div>
                        <Label for="form.notes" class="font-semibold">When should it be done?</Label>
                        <Input type="date" v-model="form.due_date" class="mt-1 block w-full" placeholder=""/>
                        <InputError :message="form.errors.notes" class="mt-2" />
                    </div>

                    <div>
                        <Listbox as="div" v-model="form.priority">
                            <ListboxLabel class="block text-sm font-medium text-gray-700 font-semibold"> How big of a priority is this? </ListboxLabel>
                            <div class="mt-1 relative">
                                <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <span class="flex items-center">
                                        <span class="ml-3 block truncate">{{ form.priority }}</span>
                                    </span>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <ListboxOption as="template" v-for="priority in prioritiesList" :key="priority.id" :value="priority.name" v-slot="{ active, selected }">
                                            <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                                                <div class="flex items-center">
                                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                                                        {{ priority.name }}
                                                    </span>
                                                </div>

                                                <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
                    </div>

                    <div>
                        <Label for="form.notes" class="font-semibold">Anything additional to add?</Label>
                        <TextArea v-model="form.notes" type="text" class="mt-1 block w-full" placeholder="This is the place for you to give a little more detail about the task that needs to be done."/>
                        <InputError :message="form.errors.notes" class="mt-2" />
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
