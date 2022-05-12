<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <svg
                    id="svg"
                    viewBox="0, 0, 400,108.06754221388368"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-16 w-auto text-orange-500 sm:h-20"
                    fill="inherit"
                    stroke="currentColor"
                >
                    <g id="svgg">
                        <path id="path0" d="M82.146 17.906 C 65.344 25.854,64.883 47.524,81.333 56.112 C 84.976 58.014,85.896 58.141,98.841 58.532 C 115.714 59.042,119.881 61.296,117.160 68.441 C 115.494 72.817,113.988 73.147,94.407 73.418 L 76.548 73.665 76.548 80.735 L 76.548 87.805 96.032 87.805 C 113.871 87.805,115.865 87.674,119.650 86.258 C 138.083 79.362,138.083 52.721,119.650 45.824 C 116.187 44.529,113.784 44.278,104.845 44.278 C 90.096 44.278,85.553 42.599,85.553 37.148 C 85.553 31.297,89.826 30.019,109.376 30.019 L 124.578 30.019 124.578 22.889 L 124.578 15.760 105.629 15.760 L 86.679 15.761 82.146 17.906 M207.129 36.773 L 207.129 57.786 215.385 57.786 L 223.640 57.786 223.640 36.773 L 223.640 15.760 215.385 15.760 L 207.129 15.760 207.129 36.773 M18.756 45.591 C 13.663 61.585,8.576 77.627,7.451 81.238 L 5.405 87.805 13.930 87.805 L 22.456 87.805 23.614 83.865 C 28.852 66.046,36.405 42.870,36.823 43.333 C 37.106 43.646,40.332 53.780,43.992 65.854 L 50.646 87.805 59.157 87.805 C 65.640 87.805,67.589 87.581,67.340 86.867 C 67.160 86.351,62.150 70.314,56.208 51.230 L 45.403 16.531 36.709 16.521 L 28.015 16.510 18.756 45.591 M143.340 25.141 L 143.340 33.771 151.595 33.771 L 159.850 33.771 159.850 25.141 L 159.850 16.510 151.595 16.510 L 143.340 16.510 143.340 25.141 M182.364 32.270 L 182.364 48.030 162.852 48.030 L 143.340 48.030 143.340 67.917 L 143.340 87.805 151.595 87.805 L 159.850 87.805 159.850 75.047 L 159.850 62.289 178.987 62.289 L 198.124 62.289 198.124 39.400 L 198.124 16.510 190.244 16.510 L 182.364 16.510 182.364 32.270 M279.169 45.591 C 274.076 61.585,268.989 77.627,267.863 81.238 L 265.818 87.805 274.343 87.805 L 282.869 87.805 284.027 83.865 C 289.265 66.046,296.818 42.870,297.236 43.333 C 297.519 43.646,300.744 53.780,304.404 65.854 L 311.059 87.805 319.570 87.805 C 326.052 87.805,328.002 87.581,327.752 86.867 C 327.572 86.351,322.563 70.314,316.621 51.230 L 305.816 16.531 297.122 16.521 L 288.428 16.510 279.169 45.591 M337.711 23.640 L 337.711 30.769 352.158 30.802 C 374.076 30.852,378.612 32.682,378.612 41.476 C 378.612 50.662,375.444 52.093,354.409 52.408 L 337.711 52.658 337.711 70.231 L 337.711 87.805 345.966 87.805 L 354.221 87.805 354.221 77.263 L 354.221 66.720 358.877 66.944 L 363.533 67.167 369.476 77.486 L 375.418 87.805 384.751 87.805 C 389.885 87.805,393.942 87.552,393.768 87.242 C 393.594 86.932,390.703 81.926,387.345 76.117 C 380.460 64.209,380.528 64.424,383.194 62.997 C 396.987 55.615,398.888 34.381,386.748 23.286 C 379.900 17.028,377.557 16.510,356.069 16.510 L 337.711 16.510 337.711 23.640 M207.129 80.300 L 207.129 87.805 231.895 87.805 L 256.660 87.805 256.660 80.300 L 256.660 72.795 231.895 72.795 L 207.129 72.795 207.129 80.300 M182.364 81.801 L 182.364 87.805 190.244 87.805 L 198.124 87.805 198.124 81.801 L 198.124 75.797 190.244 75.797 L 182.364 75.797 182.364 81.801 " stroke="none" ></path>
                    </g>
                </svg>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-gray-500"
                            ><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <a href="https://laravel.com/docs" class="underline text-gray-900 dark:text-white">Companies</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-gray-500"
                            ><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <a href="https://laracasts.com" class="underline text-gray-900 dark:text-white">Laracasts</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-gray-500"
                            ><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <a href="https://laravel-news.com/" class="underline text-gray-900 dark:text-white">Laravel News</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-gray-500"
                            ><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                                Vibrant Ecosystem
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="underline">Forge</a>, <a href="https://vapor.laravel.com" class="underline">Vapor</a>, <a href="https://nova.laravel.com" class="underline">Nova</a>, and <a href="https://envoyer.io" class="underline">Envoyer</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing" class="underline">Cashier</a>, <a href="https://laravel.com/docs/dusk" class="underline">Dusk</a>, <a href="https://laravel.com/docs/broadcasting" class="underline">Echo</a>, <a href="https://laravel.com/docs/horizon" class="underline">Horizon</a>, <a href="https://laravel.com/docs/sanctum" class="underline">Sanctum</a>, <a href="https://laravel.com/docs/telescope" class="underline">Telescope</a>, and more.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                        <svg
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="-mt-px w-5 h-5 text-gray-400"
                        >
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        <a href="https://laravel.bigcartel.com" class="ml-1 underline">
                            Shop
                        </a>

                        <svg
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            class="ml-4 -mt-px w-5 h-5 text-gray-400"
                        >
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>

                        <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                            Sponsor
                        </a>
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>
