<script setup>
import {ref} from "vue";
import ConfirmationModal from "../../Jetstream/ConfirmationModal";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import DangerButton from "../../Jetstream/DangerButton";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "../../Jetstream/Input";

const props = defineProps({
    deal: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['update', 'close'])

const show = ref(false)
const confirmingDeletion = ref(false)
const verificationPhrase = ref('DELETE')
const form = useForm({
    _method: 'delete',
    processing: false,
    verificationInput: '',
})

function deleteResource() {
    if (verification()) {
        form.post(route('api.v1.deals.destroy', props.deal), {
            onSuccess: () => closeModal(true),
        })
    }
}

function verification() {
    return verificationPhrase.value === form.verificationInput;
}

const closeModal = (shouldRefreshParent = false) => {
    if (shouldRefreshParent) {
        emit('update');
    }

    emit('close');
};
</script>

<template>
    <ConfirmationModal :show="confirmingDeletion" @close="confirmingDeletion = false">
        <template #title>
            Delete Deal
        </template>

        <template #content>
            <div class="mb-5">
                Are you sure you want to delete {{deal.name}}? Once a deal is deleted, all of their resources and data
                will be permanently deleted. Please type DELETE to confirm you would like to permanently delete this deal.

                <div class="mt-5">
                    <Input type="text" v-model="form.verificationInput" class="w-3/4" />
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click.native="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton class="ml-2" @click.native="deleteResource" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || form.verificationInput !== 'DELETE'">
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
