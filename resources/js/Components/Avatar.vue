<template>
    <img
        class="rounded-full  cursor-pointer"
        :class="image.class"
        :src="image.src"
        :alt="user.name"
        :title="user.name"
    />
</template>

<script>
export default {
    props: ["user", "size"],
    computed: {
        image() {
            if (this.size == "small") {
                return {
                    src: this.user.avatar64,
                    class: "w-10 h-10"
                };
            } else if (this.size == "normal") {
                return {
                    src: this.user.avatar,
                    class: "w-12 h-12"
                };
            } else if (this.size == "xsmall") {
                return {
                    src: this.user.avatar64,
                    class: "w-8 h-8"
                };
            } else {
                return {
                    src: this.user.avatar150,
                    class: "w-16 h-16"
                };
            }
        }
    }
};
</script>

<style></style>
