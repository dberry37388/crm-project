<script setup>

import {ref} from "vue";
import ManageNoteSlideover from "./ManageTaskSlideover";
import Button from "../../Jetstream/Button";
import TaskBlock from "./TaskBlock";

const props = defineProps({
    modelRoute: {
        type: String,
        required: true
    }
})

let managingTask = ref(false);
let tasks = ref('')
let loading = ref(false)

function searchTasks() {
    loading.value = true;

    axios.get(props.modelRoute)
        .then((r) => {
            tasks.value = r.data.data
        })

    loading.value = false;
}

searchTasks();
</script>

<template>
    <div>
        <div class="text-right mb-5">
            <Button type="button" @click="managingTask = true">
                Create Task
            </Button>
        </div>

       <div>
           <div class="flex flex-col gap-4" v-if="tasks.length > 0">
               <TaskBlock v-for="task in tasks" :task="task" :key="task.id" @update="searchTasks" />
           </div>

           <div v-else>
               <div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12">
                   <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                       <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                   </svg>
                   <h3 class="mt-2 text-sm font-medium text-gray-900">It's lonely in here</h3>
                   <p class="mt-1 text-sm text-gray-500">There are no tasks associated with this company.</p>
               </div>
           </div>
       </div>

        <ManageNoteSlideover
            v-if="!loading"
            :show="managingTask"
            @close="managingTask = false"
            @update="searchTasks"
            :methodRoute="modelRoute" />
    </div>
</template>
