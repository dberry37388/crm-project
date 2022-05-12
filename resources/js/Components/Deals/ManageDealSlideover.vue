<script setup>

import {DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from "@headlessui/vue";
import { XIcon } from '@heroicons/vue/outline'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
import SlideoverWithTitle from "../Slideovers/SlideoverWithTitle";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import Label from "../../Jetstream/Label";
import InputError from "../../Jetstream/InputError";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "../../Jetstream/Input";
import TeamUserComboBox from "../TeamUserComboBox"

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
    currentDeal: {
        type: Object,
        default: null
    }

});

const emit = defineEmits(['close', 'update']);

const form = useForm({
    _method: props.currentDeal ? 'PUT' : 'POST',
    processing: false,
    name: props.currentDeal ? props.currentDeal.name : null,
    type: props.currentDeal ? props.currentDeal.type : 'New Business',
    stage: props.currentDeal ? props.currentDeal.stage : 'Appointment scheduled',
    amount: props.currentDeal ? props.currentDeal.amount : '0.00',
    owner: props.currentDeal ? props.currentDeal.owner : null,
    priority: props.currentDeal ? props.currentDeal.priority : 'Low',
    close_date: props.currentDeal ? props.currentDeal.close_date : null,
})

const prioritiesList = [
    { name: 'Low', color: '#444444' },
    { name: 'Medium', color: '#f4f4f4' },
    { name: 'High', color: '#fc0000' },
]

const typesList = [
    { name: 'New Business', color: '#444444' },
    { name: 'Existing Business', color: '#f4f4f4' },
]

const stagesList = [
    { name: 'Appointment scheduled', color: '#444444' },
    { name: 'Qualified to buy', color: '#f4f4f4' },
    { name: 'Presentation scheduled', color: '#fc0000' },
    { name: 'Decision maker brought-in', color: '#fc0000' },
    { name: 'Contract sent', color: '#fc0000' },
    { name: 'Closed won', color: '#fc0000' },
    { name: 'Closed lost', color: '#fc0000' },
]

const saveForm = () => {
    form.processing = true;

    form.post(props.methodRoute, {
            errorBag: 'manageDeal',
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
                <span v-if="currentDeal">Edit Deal</span>
                <span v-else>Create Deal</span>
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
                        <Label for="form.name" class="font-semibold">Deal name</Label>
                        <Input v-model="form.name" type="text" class="mt-1 block w-full" placeholder="e.g. Send a welcome email to Tom."/>
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.owner" class="font-semibold">Who owns this deal?</Label>
                        <TeamUserComboBox v-model="form.owner" />
                    </div>

                    <div>
                        <Label for="form.amount" class="font-semibold">Amount</Label>
                        <Input type="text" v-model="form.amount" class="mt-1 block w-full" placeholder=""/>
                        <InputError :message="form.errors.amount" class="mt-2" />
                    </div>

                    <div>
                        <Label for="form.close_date" class="font-semibold">Close date</Label>
                        <Input type="date" v-model="form.close_date" class="mt-1 block w-full" placeholder=""/>
                        <InputError :message="form.errors.close_date" class="mt-2" />
                    </div>

                    <div>
                        <Listbox as="div" v-model="form.priority">
                            <ListboxLabel class="block text-sm font-medium text-gray-700 font-semibold"> How big of a priority is this? </ListboxLabel>
                            <div class="mt-1 relative">
                                <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <span class="flex items-center">
                                        <span class="block truncate">{{ form.priority }}</span>
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
                                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
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
                        <Listbox as="div" v-model="form.stage">
                            <ListboxLabel class="block text-sm font-medium text-gray-700 font-semibold">
                                What stage is the deal in?
                            </ListboxLabel>

                            <div class="mt-1 relative">
                                <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <span class="flex items-center">
                                        <span class="block truncate">{{ form.stage }}</span>
                                    </span>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <ListboxOption as="template" v-for="stage in stagesList" :key="stage.id" :value="stage.name" v-slot="{ active, selected }">
                                            <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                                                <div class="flex items-center">
                                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                                                        {{ stage.name }}
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
                        <Listbox as="div" v-model="form.type">
                            <ListboxLabel class="block text-sm font-medium text-gray-700 font-semibold">
                                What type is the deal in?
                            </ListboxLabel>

                            <div class="mt-1 relative">
                                <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <span class="flex items-center">
                                        <span class="block truncate">{{ form.type }}</span>
                                    </span>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <ListboxOption as="template" v-for="type in typesList" :key="type.id" :value="type.name" v-slot="{ active, selected }">
                                            <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                                                <div class="flex items-center">
                                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                                                        {{ type.name }}
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
