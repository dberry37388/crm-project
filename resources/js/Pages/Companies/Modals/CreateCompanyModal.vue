<script>
import {nextTick} from "vue";

import DialogModal from "../../../Jetstream/DialogModal";
import InputError from "../../../Jetstream/InputError";
import SecondaryButton from "../../../Jetstream/SecondaryButton";
import Button from "../../../Jetstream/Button";
import Input from "../../../Jetstream/Input";
import {useForm} from "@inertiajs/inertia-vue3";
import Label from "../../../Jetstream/Label";
import TeamUserComboBox from "../../../Components/TeamUserComboBox";
import IndustriesComboBox from "../../../Components/IndustriesComboBox";

export  default {
    components: {IndustriesComboBox, TeamUserComboBox, Label, Input, Button, SecondaryButton, InputError, DialogModal},
    props: {
        company: {
            type: Object,
            required: true,
        }
    },

    emits: ['updated', 'close'],

    data() {
        return {
            show: false,
            form: useForm({
                name: '',
                city: '',
                state: '',
                postal_code: '',
                timezone: '',
                number_of_employees: '',
                assigned_to: '',
                industry: '',
            }),
        }
    },

    methods: {
        async saveForm() {
            this.form.transform((data) => ({
                ...data,
                assigned_to_id: data.assigned_to.id,
                industry_id: data.industry.id,
            }))
                .post(`/api/v1/companies`, {
                    errorBag: 'createCompany',
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
                Update Company
            </h2>
        </template>

        <template #content>
            <div class="flex flex-col gap-4">
                <div>
                    <Label for="form.name">Company Name</Label>
                    <Input v-model="form.name" type="text" class="mt-1 block w-3/4" placeholder="Company Name"/>
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="w-3/4">
                    <TeamUserComboBox label="Assigned User" v-model="form.assigned_to" :selected="form.assigned_to" />
                </div>

                <div class="w-3/4">
                    <IndustriesComboBox v-model="form.industry" :selected="form.industry" />
                </div>

                <div>
                    <Label for="form.city">City</Label>
                    <Input v-model="form.city" type="text" class="mt-1 block w-3/4" placeholder="City"/>
                    <InputError :message="form.errors.city" class="mt-2" />
                </div>

                <div>
                    <Label for="form.state">State</Label>
                    <Input v-model="form.state" type="text" class="mt-1 block w-3/4" placeholder="State"/>
                    <InputError :message="form.errors.state" class="mt-2" />
                </div>

                <div>
                    <Label for="form.postal_code">Postal Code</Label>
                    <Input v-model="form.postal_code" type="text" class="mt-1 block w-3/4" placeholder="Postal Code"/>
                    <InputError :message="form.errors.postal_code" class="mt-2" />
                </div>

                <div>
                    <Label for="form.timezone">Timezone</Label>
                    <Input v-model="form.timezone" type="text" class="mt-1 block w-3/4" placeholder="Timezone"/>
                    <InputError :message="form.errors.timezone" class="mt-2" />
                </div>

                <div>
                    <Label for="form.number_of_employees">Number of Employees</Label>
                    <Input v-model="form.number_of_employees" type="text" class="mt-1 block w-3/4" placeholder="Number of Employees"/>
                    <InputError :message="form.errors.number_of_employees" class="mt-2" />
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
