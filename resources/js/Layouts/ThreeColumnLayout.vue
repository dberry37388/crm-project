<script>
import FullWidthAppLayout from "./FullWidthAppLayout";

export default {
    components: {FullWidthAppLayout}
}
</script>

<template>
    <FullWidthAppLayout>
        <main class="h-[calc(100vh-65px)] flex overflow-x-scroll">
            <div class="bg-white h-full min-w-[300px] md:min-w-[500px] border-r border-gray-200">
                <slot name="leftColumn" />
            </div>

            <div class="h-full bg-gray-50 min-w-[600px] md:flex-grow overflow-auto">
                <slot name="middleColumn" />
            </div>

            <div class="bg-white h-full min-w-[300px] md:min-w-[500px] border-l border-gray-200">
                <slot name="rightColumn" />
            </div>
        </main>
    </FullWidthAppLayout>
</template>
