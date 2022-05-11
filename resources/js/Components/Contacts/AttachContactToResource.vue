<script setup>

import {DialogTitle} from "@headlessui/vue";
import { XIcon } from '@heroicons/vue/outline'
import SlideoverWithTitle from "../../Components/Slideovers/SlideoverWithTitle";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import {useForm} from "@inertiajs/inertia-vue3";
import TeamContactsComboBox from "../../Components/TeamContactsComboBox";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    modelRoute: {
        type: String,
        default: null,
    },
});

const form = useForm({
    processing: false,
    contact: null
});

const emit = defineEmits(['close', 'update']);

const closeSlideover = (shouldRefreshParent = false) => {
    form.reset();

    if (shouldRefreshParent) {
        emit('update');
    }

    emit('close');
};

const saveForm = () => {
    form.processing = true;

    form.post(props.modelRoute + '/' + form.contact.id, {
            errorBag: 'attachContact',
            preserveScroll: true,
            onSuccess: () => closeSlideover(true),
        })
}

</script>

<template>
    <SlideoverWithTitle :show="show">
        <template #header>
            <DialogTitle class="text-lg font-bold text-white">
                Associate Contact
            </DialogTitle>

            <div class="ml-3 flex h-7 items-center">
                <button type="button" class="rounded-md bg-gray-900 text-gray-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="closeSlideover">
                    <span class="sr-only">Close panel</span>
                    <XIcon class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>
        </template>

        <template #content>
            <div class="pt-6 pb-5">
                <div>
                    Use the tool below to associate this company with an existing contact.
                </div>
            </div>

            <div class="mt-5">
                <TeamContactsComboBox v-model="form.contact" />
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
