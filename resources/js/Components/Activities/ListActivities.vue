<script setup>

import {ref} from "vue";
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/solid";
import DisclosureStateEmitter from "../Disclosure/DisclosureStateEmitter";
import AttributeDiffTable from "./AttributeDiffTable";

const props = defineProps({
    activityRoute: {
        type: String,
        required: true
    }
})

let activities = ref('')
let loading = ref(true)

const elements = ref([]);

const hideOther = (id) => {
    const items = elements.value.filter((elm) => {
        return elm.getAttribute("data-id") !== id.toString();
    });
    items.forEach((elm) => elm.click());
};

const doClose = (close) => {
    close();
};


function loadActivities() {
    loading.value = true;

    axios.get(props.activityRoute)
        .then((r) => {
            activities.value = r.data.data
        })

    loading.value = false;
}

loadActivities();
</script>

<template>
    <div>
        <div class="flex flex-col gap-4" v-if="activities.length > 0" >
            <Disclosure
                v-for="(activity, idx) in activities"
                :key="activity.id"
                v-slot="{ open, close }"
            >
                <DisclosureButton
                    as="div"
                    class="w-full py-4 flex items-center justify-between shadow"
                    :class="open ? 'bg-gray-200 text-black' : 'bg-white'"
                >
                    <div class="flex justify-between gap-4">
                        <div class="flex gap-4">
                                <span class="ml-6 flex items-center">
                                    <ChevronDownIcon
                                        :class="[open ? '-rotate-180' : 'rotate-0', 'h-5 w-5 transform']" aria-hidden="true"
                                    />
                                </span>

                            <div class="text-sm">
                                {{activity.event}} by <span class="font-semibold">{{  activity.causer.name }}</span> on {{ new Date(activity.created_at).toLocaleDateString() }}
                            </div>
                        </div>
                    </div>
                </DisclosureButton>

                <DisclosurePanel
                    class="panel bg-white transition-all opacity-0 duration-200 max-h-0 overflow-auto -mt-5"
                    :class="open && 'max-h-72 opacity-100 shadow'"
                    static
                >
                    <div class="px-4 pt-4 pb-4 text-sm text-gray-500">
                        <div class="sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full align-middle md:px-6 lg:px-8">
                                <AttributeDiffTable :activity="activity" />
                            </div>
                        </div>
                    </div>
                </DisclosurePanel>

                <button
                    :ref="(el) => (elements[idx] = el)"
                    :data-id="activity.id"
                    v-show="false"
                    @click="doClose(close)"
                ></button>
                <DisclosureStateEmitter :show="open" @show="hideOther(activity.id)" />
            </Disclosure>
        </div>

        <div v-else>
            <div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">It's lonely in here</h3>

                <div class="mt-5">
                    It looks like there hasn't been any activity.
                </div>
            </div>
        </div>
    </div>
</template>
