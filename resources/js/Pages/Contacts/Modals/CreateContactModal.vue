<script>
import DialogModal from "../../../Jetstream/DialogModal";
import InputError from "../../../Jetstream/InputError";
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import Button from "../../../Jetstream/Button";
import Input from "../../../Jetstream/Input";
import {useForm} from "@inertiajs/inertia-vue3";
import Label from "../../../Jetstream/Label";
import TeamUserComboBox from "../../../Components/TeamUserComboBox";
import TextArea from "../../../Components/TextArea";

export  default {
    props: {
        companyId: {
            required: false,
            default: null
        }
    },

    components: {
        TextArea,
        TeamUserComboBox,
        Label,
        Input,
        Button,
        SecondaryButton,
        InputError,
        DialogModal
    },

    emits: ['updated', 'close'],

    data() {
        return {
            show: false,
            form: useForm({
                first_name: '',
                last_name: '',
                email: '',
                job_title: '',
                phone_number: '',
                mobile_number: '',
                description: '',
                assigned_to: '',
            }),
        }
    },

    methods: {
        async saveForm() {
            this.form.transform((data) => ({
                ...data,
                assigned_to_id: data.assigned_to.id,
                company_id: this.companyId
            }))
                .post(`/api/v1/contacts`, {
                    errorBag: 'createContact',
                    preserveScroll: true,
                    onSuccess: () => this.closeDialog(true),
            })
        },

        closeDialog(success = false) {
            this.show = false;

            if (success) {
                this.$emit('updated');
            }

            this.$emit('close');
        }
    }
}
</script>

<template>
    <DialogModal :closeable="false" :show="show">
        <template #title>
            <h2 class="font-bold">
                Update Contact
            </h2>
        </template>

        <template #content>
            <div class="flex flex-col gap-4">
                <div>
                    <Label for="form.name">First Name</Label>
                    <Input v-model="form.first_name" type="text" class="mt-1 block w-3/4" placeholder="First Name"/>
                    <InputError :message="form.errors.first_name" class="mt-2" />
                </div>

                <div>
                    <Label for="form.name">Last Name</Label>
                    <Input v-model="form.last_name" type="text" class="mt-1 block w-3/4" placeholder="Last Name"/>
                    <InputError :message="form.errors.last_name" class="mt-2" />
                </div>

                <div class="w-3/4">
                    <TeamUserComboBox label="Assigned User" v-model="form.assigned_to" :selected="form.assigned_to" />
                </div>

                <div>
                    <Label for="form.city">Email</Label>
                    <Input v-model="form.email" type="text" class="mt-1 block w-3/4" placeholder="Email"/>
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div>
                    <Label for="form.state">Job Title</Label>
                    <Input v-model="form.job_title" type="text" class="mt-1 block w-3/4" placeholder="Job Title"/>
                    <InputError :message="form.errors.job_title" class="mt-2" />
                </div>

                <div>
                    <Label for="form.postal_code">Phone Number</Label>
                    <Input v-model="form.phone_number" type="text" class="mt-1 block w-3/4" placeholder="Phone Number"/>
                    <InputError :message="form.errors.phone_number" class="mt-2" />
                </div>

                <div>
                    <Label for="form.timezone">Mobile Number</Label>
                    <Input v-model="form.mobile_number" type="text" class="mt-1 block w-3/4" placeholder="Mobile Number"/>
                    <InputError :message="form.errors.mobile_number" class="mt-2" />
                </div>

                <div>
                    <Label for="form.number_of_employees">Description</Label>
                    <TextArea v-model="form.description" type="text" class="mt-1 block w-3/4" placeholder="Description"/>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeDialog">
                Cancel
            </SecondaryButton>

            <Button
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="saveForm"
            >
                Save
            </Button>
        </template>
    </DialogModal>
</template>
