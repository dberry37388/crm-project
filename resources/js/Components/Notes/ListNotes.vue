<script setup>

import {ref} from "vue";
import NoteBlock from "./NoteBlock";
import ManageNoteSlideover from "./ManageNoteSlideover";
import Button from "../../Jetstream/Button";

const props = defineProps({
    modelRoute: {
        type: String,
        required: true
    },
    noteListRoute: {
        type: String,
        required: true
    }
})

let managingNote = ref(false);
let notes = ref('')
let loading = ref(false)

function searchNotes() {
    loading.value = true;

    axios.get(props.modelRoute)
        .then((r) => {
            notes.value = r.data.data
        })

    loading.value = false;
}

searchNotes();
</script>

<template>
    <div>
        <div class="text-right mb-5">
            <Button type="button" @click="managingNote = true">
                Create Note
            </Button>
        </div>

        <div class="flex flex-col gap-4" v-if="notes">
            <NoteBlock v-for="note in notes" :note="note" :key="note.id" />

            <ManageNoteSlideover
                v-if="!loading"
                :show="managingNote"
                @close="managingNote = false"
                @update="searchNotes"
                :methodRoute="modelRoute" />
        </div>
    </div>
</template>
