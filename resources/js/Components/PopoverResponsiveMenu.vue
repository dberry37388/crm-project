<script>
import {Popover, PopoverButton, PopoverOverlay, PopoverPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import ResponsiveNavLink from "../Jetstream/ResponsiveNavLink";
import { BellIcon, XIcon, } from '@heroicons/vue/outline'
import ApplicationMark from "../Jetstream/ApplicationMark";
import ApplicationLogo from "../Jetstream/ApplicationLogo";
export default {
    props: {
        show: {
            type: Boolean,
            default: false
        }
    },

    components: {
        ApplicationLogo,
        ApplicationMark,
        BellIcon,
        Popover,
        PopoverButton,
        PopoverPanel,
        PopoverOverlay,
        ResponsiveNavLink,
        TransitionChild,
        TransitionRoot,
        XIcon,
    },


    emits: ['close'],

    methods: {
        closeNavigation() {
            this.$emit('close');
        }
    }
}
</script>

<template>
    <Popover>
        <TransitionRoot as="template" :show="show">
            <div class="lg:hidden">
                <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-150 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <PopoverOverlay class="z-20 fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-150 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                    <PopoverPanel focus class="z-30 absolute top-0 inset-x-0 max-w-3xl mx-auto w-full p-2 transition transform origin-top">
                        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y divide-gray-200">
                            <div class="pt-3 pb-2">
                                <div class="flex items-center justify-between px-4">
                                    <div>
                                        <ApplicationLogo class="block h-8 w-auto text-gray-900" />
                                    </div>
                                    <div class="-mr-2">
                                        <PopoverButton
                                            @click="closeNavigation"
                                            class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                                            <span class="sr-only">Close menu</span>
                                            <XIcon class="h-6 w-6" aria-hidden="true" />
                                        </PopoverButton>
                                    </div>
                                </div>
                                <div class="mt-3 px-2 space-y-1">
                                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                        Dashboard
                                    </ResponsiveNavLink>

                                    <ResponsiveNavLink :href="route('companies.list')">
                                        Companies
                                    </ResponsiveNavLink>

                                    <ResponsiveNavLink :href="route('contacts.list')">
                                        Contacts
                                    </ResponsiveNavLink>

                                    <ResponsiveNavLink :href="route('deals.list')">
                                        Deals
                                    </ResponsiveNavLink>
                                </div>
                            </div>
                            <div class="pt-4 pb-2">
                                <div class="flex items-center px-5">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                    </div>
                                    <div class="ml-3 min-w-0 flex-1">
                                        <div class="text-base font-medium text-gray-800 truncate">{{ $page.props.user.name }}</div>
                                        <div class="text-sm font-medium text-gray-500 truncate">{{ $page.props.user.email }}</div>
                                    </div>
                                    <button type="button" class="ml-auto flex-shrink-0 bg-white p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                                        <span class="sr-only">View notifications</span>
                                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>
                                <div class="mt-3 px-2 space-y-1">
                                    <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                        Profile
                                    </ResponsiveNavLink>

                                    <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                        API Tokens
                                    </ResponsiveNavLink>

                                    <!-- Authentication -->
                                    <form method="POST" @submit.prevent="logout">
                                        <ResponsiveNavLink as="button">
                                            Log Out
                                        </ResponsiveNavLink>
                                    </form>

                                    <!-- Team Management -->
                                    <template v-if="$page.props.jetstream.hasTeamFeatures">
                                        <div class="border-t border-gray-200" />

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <ResponsiveNavLink :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                            Team Settings
                                        </ResponsiveNavLink>

                                        <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                            Create New Team
                                        </ResponsiveNavLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Switch Teams
                                        </div>

                                        <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                            <form @submit.prevent="switchToTeam(team)">
                                                <ResponsiveNavLink as="button">
                                                    <div class="flex items-center">
                                                        <svg
                                                            v-if="team.id == $page.props.user.current_team_id"
                                                            class="mr-2 h-5 w-5 text-green-400"
                                                            fill="none"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                        <div>{{ team.name }}</div>
                                                    </div>
                                                </ResponsiveNavLink>
                                            </form>
                                        </template>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </PopoverPanel>
                </TransitionChild>
            </div>
        </TransitionRoot>
    </Popover>
</template>
