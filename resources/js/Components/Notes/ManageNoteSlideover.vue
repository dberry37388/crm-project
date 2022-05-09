<script setup>

import {DialogTitle} from "@headlessui/vue";
import { XIcon } from '@heroicons/vue/outline'
import SlideoverWithTitle from "../../Components/Slideovers/SlideoverWithTitle";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import Label from "../../Jetstream/Label";
import InputError from "../../Jetstream/InputError";
import {useForm} from "@inertiajs/inertia-vue3";
import TextArea from "../../Components/TextArea";

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
    currentNote: {
        type: String,
        default: null
    }

});

const emit = defineEmits(['close', 'update']);

const form = useForm({
    _method: props.currentNote ? 'PUT' : 'POST',
    processing: false,
    note: props.currentNote,
})

const saveForm = () => {
    form.processing = true;

    form.post(props.methodRoute, {
            errorBag: 'manageNote',
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
                Create Note
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
                <div class="flex flex-col gap-4">
                    <div>
                        <TextArea v-model="form.note" type="text" class="mt-1 block w-full" placeholder="Write something memorable..."/>
                        <InputError :message="form.errors.note" class="mt-2" />
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
