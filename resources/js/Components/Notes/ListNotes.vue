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

       <div>
           <div class="flex flex-col gap-4" v-if="notes.length > 0">
               <NoteBlock v-for="note in notes" :note="note" :key="note.id" @update="searchNotes" />
           </div>

           <div v-else>
               <div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12">
                   <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                       <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                   </svg>
                   <h3 class="mt-2 text-sm font-medium text-gray-900">It's lonely in here</h3>
                   <p class="mt-1 text-sm text-gray-500">There are no notes associated with this company.</p>
               </div>
           </div>
       </div>

        <ManageNoteSlideover
            v-if="!loading"
            :show="managingNote"
            @close="managingNote = false"
            @update="searchNotes"
            :methodRoute="modelRoute" />
    </div>
</template>
