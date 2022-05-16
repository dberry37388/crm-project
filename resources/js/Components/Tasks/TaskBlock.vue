<script setup>

import {ref, computed} from "vue";
import {ChevronDownIcon} from "@heroicons/vue/solid";
import ConfirmDeleteNoteModal from "./ConfirmDeleteTaskModal";
import Dropdown from "../../Jetstream/Dropdown";
import ManageNoteSlideover from "./ManageTaskSlideover";
import ConfirmDeleteTaskModal from "./ConfirmDeleteTaskModal";
import ManageTaskSlideover from "./ManageTaskSlideover";
import dayjs from "dayjs";
import timezone from "dayjs/plugin/timezone"
import utc from "dayjs/plugin/utc"

dayjs.extend(utc)
dayjs.extend(timezone)

const props = defineProps({
    task: {
        type: Object,
        required: true
    },

    listType: {
        type: String,
        default: 'All'
    }
})

const emit = defineEmits(['update'])

let deletingTask = ref(false)

const handleUpdateEvent = () => {
    emit('update');
}

const isDoneBlockClass = computed(() => {
    return props.task.is_done
        ? 'opacity-50 hover:opacity-100'
        : 'opacity-100';
});

const isDoneTitleClass = computed(() => {
    return props.task.is_done ? 'line-through' : '';
});

let managingTask = ref(false);
let loading = ref(false)
const modelRoute = route('api.v1.tasks.update', props.task.id)

function formatDateTime(value) {
    return dayjs(value).tz(dayjs.tz.guess()).format('MMMM DD, YYYY h:mm a');
}

function shouldShow(task) {
    if (props.listType === 'All') {
        return true;
    }

    if (props.listType === 'Pending' && !task.is_done) {
        return true;
    }

    if (props.listType === 'Completed' && task.is_done) {
        return true;
    }

    return false;
}

</script>

<template>
    <div class="bg-white p-5 shadow-sm" :class="isDoneBlockClass" v-if="shouldShow(task)">
        <div class="flex items-center justify-between gap-4 text-sm">
            <div>
                <span class="font-semibold">Assigned to: </span> {{ task.assigned_to.name }}. Last updated {{ formatDateTime(task.updated_at) }}
            </div>

            <div class="flex items-center justify-end gap-3">
                <Dropdown>
                    <template #trigger>
                        <div class="flex items-center cursor-pointer">
                            <span class="mr-1 link">
                                Actions
                            </span>

                            <ChevronDownIcon class="h-3 w-3" />
                        </div>
                    </template>

                    <template #content>
                        <div class="cursor-pointer px-3 py-2 text-sm action-link" @click="managingTask = true">
                            Edit
                        </div>

                        <div class="cursor-pointer px-3 py-2 text-sm action-link" @click="deletingTask = true">
                            Delete
                        </div>
                    </template>
                </Dropdown>

                <div class="font-light text-sm text-gray-500">
                    Due: {{ formatDateTime(task.due_date) }}
                </div>
            </div>
        </div>

        <div class="mt-4 font-semibold text-sm" :class="isDoneTitleClass">
            {{ task.task}}
        </div>

        <div class="mt-2 text-sm" :class="isDoneTitleClass">
            {{ task.notes }}
        </div>

        <div class="mt-4 flex items-center gap-3">
            <div>
                <div class="bg-red-200 font-bold text-xs px-3 py-2 rounded-lg" v-if="task.priority === 'High'">
                    High Priority
                </div>

                <div class="bg-yellow-200  font-bold text-xs px-3 py-2 rounded-lg" v-if="task.priority === 'Medium'">
                    Medium Priority
                </div>

                <div class="bg-green-200 font-bold text-xs px-2 py-1 rounded-lg" v-if="task.priority === 'Low'">
                    Low Priority
                </div>
            </div>

            <div v-if="task.is_done" class="text-sm italic">
                Completed on {{ formatDateTime(task.completed_at)}}
            </div>
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
