<script>
import ConfirmationModal from "../../../Jetstream/ConfirmationModal";
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import DangerButton from "../../../Jetstream/DangerButton";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "../../../Jetstream/Input";
export default {
    props: {
        company: {
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
            companyDeleted: false,
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
                this.form.post(route('api.v1.companies.destroy', this.company.id), {
                    onSuccess: () => this.closeModal(),
                })
            }
        },

        verification() {
            return this.verificationPhrase === this.form.verificationInput;
        },

        closeModal() {
            this.show = false;

            if (this.companyDeleted) {
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
            Delete Account
        </template>

        <template #content>
            <div class="mb-5">
                Are you sure you want to delete {{company.name}}? Once a company is deleted, all of its resources and data
                will be permanently deleted. Please type DELETE to confirm you would like to permanently delete your
                account.

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
                Delete Company
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
