<template>
    <div v-show="false"></div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
        },
    },
    emits: ["show", "hide"],
    watch: {
        show(show) {
            if (show) {
                this.$emit("show");
            } else {
                this.$emit("hide");
            }
        },
    },
};
</script>
