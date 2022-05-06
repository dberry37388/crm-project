<script>
import AppLayout from "../Layouts/AppLayout";

export default {
    components: {AppLayout}
}
</script>

<template>
    <AppLayout>
        <!-- Page Heading -->
        <header v-if="$slots.header" class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </AppLayout>
</template>
