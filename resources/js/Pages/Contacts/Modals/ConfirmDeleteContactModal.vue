<script>
import ConfirmationModal from "../../../Jetstream/ConfirmationModal";
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import DangerButton from "../../../Jetstream/DangerButton";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "../../../Jetstream/Input";
export default {
    props: {
        contact: {
            type: Object,
            required: true
        }
    },

    components: {Input, DangerButton, SecondaryButton, ConfirmationModal},

    emits: ['updated', 'close'],

    data() {
        return {
            show: false,
            confirmingDeletion: false,
            verificationPhrase: 'DELETE',
            contactDeleted: false,
            form: useForm({
                _method: 'delete',
                processing: false,
                verificationInput: '',
            })
        }
    },

    methods: {
        deleteConfirmed() {
            if (this.verification()) {
                this.form.post(route('api.v1.contacts.destroy', this.contact), {
                    onSuccess: () => this.closeModal(),
                })
            }
        },

        verification() {
            return this.verificationPhrase === this.form.verificationInput;
        },

        closeModal() {
            this.show = false;

            if (this.contactDeleted) {
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
            Delete Contact
        </template>

        <template #content>
            <div class="mb-5">
                Are you sure you want to delete {{contact.first_name}} {{contact.last_name}}? Once a contact is deleted, all of their resources and data
                will be permanently deleted. Please type DELETE to confirm you would like to permanently delete this contact.

                <div class="mt-5">
                    <Input type="text" v-model="form.verificationInput" class="w-3/4" />
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click.native="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton class="ml-2" @click.native="deleteConfirmed" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || form.verificationInput !== 'DELETE'">
                Delete Contact
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
