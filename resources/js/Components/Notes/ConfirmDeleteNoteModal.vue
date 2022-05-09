<script setup>
import ConfirmationModal from "../../Jetstream/ConfirmationModal";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import DangerButton from "../../Jetstream/DangerButton";
import Input from "../../Jetstream/Input";
import {ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    note: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['update', 'close']);

const show = ref(false)
const processing = ref(false)

const closeModal = (shouldRefreshParent = false) => {
    if (shouldRefreshParent) {
        emit('update');
    }

    emit('close');
};

const form = useForm({
    _method: 'DELETE',
})

function deleteResource() {
    process.value = true;

    form.post(route('api.v1.notes.destroy', props.note.id), {
        onSuccess: () => { closeModal(true) }
    })
}
</script>

<template>
    <ConfirmationModal :show="show" @close="show = false">
        <template #title>
            Delete Note
        </template>

        <template #content>
            <div class="mb-5">
                Are you sure you want to delete this note?.
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click.native="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton class="ml-2" @click.native="deleteResource" :class="{ 'opacity-25': processing }" :disabled="processing">
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
