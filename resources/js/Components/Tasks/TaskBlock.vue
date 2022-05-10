<script setup>

import {ref} from "vue";
import {ChevronDownIcon} from "@heroicons/vue/solid";
import ConfirmDeleteNoteModal from "./ConfirmDeleteTaskModal";
import Dropdown from "../../Jetstream/Dropdown";
import ManageNoteSlideover from "./ManageTaskSlideover";
import ConfirmDeleteTaskModal from "./ConfirmDeleteTaskModal";
import ManageTaskSlideover from "./ManageTaskSlideover";

const props = defineProps({
    task: {
        type: Object,
        required: true
    },
})

const emit = defineEmits(['update'])

const deletingTask = ref(false)

const handleUpdateEvent = () => {
    emit('update');
}

let managingTask = ref(false);
let loading = ref(false)
const modelRoute = route('api.v1.tasks.update', props.task.id)

</script>

<template>
    <div class="bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between gap-4 text-sm">
            <div>
                <span class="font-semibold">Task</span> assigned to {{ task.assigned_to.name }}
                due on {{ new Date(task.due_date).toLocaleDateString() }}
            </div>

            <div>
                <Dropdown>
                    <template #trigger>
                        <div class="flex items-center font-bold text-orange-500 cursor-pointer">
                            <span class="mr-1">
                                Actions
                            </span>

                            <ChevronDownIcon class="h-3 w-3" />
                        </div>
                    </template>

                    <template #content>
                        <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="managingTask = true">
                            Edit
                        </div>

                        <div class="cursor-pointer px-3 py-2 text-sm hover:text-orange-500" @click="deletingTask = true">
                            Delete
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>

        <div class="mt-4">
            {{ task.task}}
        </div>

        <ConfirmDeleteTaskModal :task="task" :show="deletingTask" @close="deletingTask = false" @update="handleUpdateEvent" />
        <ManageTaskSlideover
            v-if="!loading"
            :current-task="task"
            :show="managingTask"
            @close="managingTask = false"
            @update="handleUpdateEvent"
            :methodRoute="modelRoute" />
    </div>
</template>
