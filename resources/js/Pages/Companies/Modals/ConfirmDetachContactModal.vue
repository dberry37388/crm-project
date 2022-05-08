<script>
import ConfirmationModal from "../../../Jetstream/ConfirmationModal";
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import DangerButton from "../../../Jetstream/DangerButton";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "../../../Jetstream/Input";
export default {
    props: {
        company: {
            type: Number,
            required: true
        },
        contact: {
            type: Object,
            require: true
        }
    },

    components: {Input, DangerButton, SecondaryButton, ConfirmationModal},

    emits: ['updated', 'close'],

    data() {
        return {
            show: false,
            confirmingDeletion: false,
            success: false,
            form: useForm({
                _method: 'delete',
                processing: false,
                verificationInput: '',
            })
        }
    },

    methods: {
        detachConfirmed() {
            this.form.post(route('api.v1.company.detach-contact', {contact: this.contact.id, company: this.company}), {
                onSuccess: () => this.closeModal(true),
            })
        },

        closeModal(success = false) {
            this.show = false;

            if (success) {
                this.$emit('updated');
            }

            this.$emit('close');
        }
    },
}
</script>

<template>
    <ConfirmationModal :show="confirmingDeletion" @close="confirmingDeletion = false">
        <template #title>
            Remove Contact From Company
        </template>

        <template #content>
            <div class="mb-5">
                {{ contact.first_name }} {{ contact.last_name }} will no longer be associated with this company.
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click.native="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton class="ml-2" @click.native="detachConfirmed" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Detach Contact
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
