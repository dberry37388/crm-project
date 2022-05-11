<script setup>
import {ref} from "vue";
import ConfirmationModal from "../../Jetstream/ConfirmationModal";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import DangerButton from "../../Jetstream/DangerButton";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "../../Jetstream/Input";

const props = defineProps({
    contact: {
        type: Object,
        required: true
    },
    modelRoute: {
        type: String,
        require: true
    },
    confirmMessage: {
        type: String,
        default: 'Are you sure you wish to detach this contact?'
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
    processing: false,
})

function detach() {
    process.value = true;

    form.post(props.modelRoute, {
        onSuccess: () => { closeModal(true) }
    })
}
</script>

<template>
    <ConfirmationModal :show="show" @close="show = false">
        <template #title>
            Remove from Contact
        </template>

        <template #content>
            <div class="mb-5">
                {{confirmMessage}}
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click.native="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton class="ml-2" @click.native="detach" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Detach Resource
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
