<script setup>

import {ChevronDownIcon} from "@heroicons/vue/solid";
import Dropdown from "../../Jetstream/Dropdown";
import ConfirmDeleteNoteModal from "./ConfirmDeleteNoteModal";
import {ref} from "vue";
import ManageNoteSlideover from "./ManageNoteSlideover";

const props = defineProps({
    note: {
        type: Object,
        required: true
    },
})

const emit = defineEmits(['update'])

const deletingNote = ref(false)

const handleUpdateEvent = () => {
    emit('update');
}

let managingNote = ref(false);
let loading = ref(false)
const modelRoute = route('api.v1.notes.update', props.note.id)

</script>

<template>
    <div class="bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between gap-4 text-sm">
            <div>
                <span class="font-semibold">Note by</span> {{ note.created_by.name }} on
                <span class="text-gray-500">
                    {{ new Date(note.created_at).toLocaleDateString() }}
                </span>
            </div>

            <div>
                <Dropdown>
                    <template #trigger>
                        <div class="flex items-center font-medium hover:text-orange-500 cursor-pointer">
                            <span class="mr-1">
                                Actions
                            </span>

                            <ChevronDownIcon class="h-3 w-3" />
                        </div>
                    </template>

                    <template #content>
                        <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="managingNote = true">
                            Edit
                        </div>

                        <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="deletingNote = true">
                            Delete
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>

        <div class="mt-4">
            {{ note.note}}
        </div>

        <ConfirmDeleteNoteModal :note="note" :show="deletingNote" @close="deletingNote = false" @update="handleUpdateEvent" />
        <ManageNoteSlideover
            v-if="!loading"
            :current-note="note.note"
            :show="managingNote"
            @close="managingNote = false"
            @update="handleUpdateEvent"
            :methodRoute="modelRoute" />
    </div>
</template>
