<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 w-full">
        <div>
            <slot name="logo" />
        </div>

        <div class="px-3 sm:px-0 w-[400px]">
            <div class="w-ful mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>

        <div class="mt-3">
            <slot name="footer" />
        </div>
    </div>
</template>
