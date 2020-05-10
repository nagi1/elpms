<template>
    <img
        class="rounded-full flex-shrink-0 object-cover cursor-pointer"
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
            switch (this.size) {
                case "xs":
                    return {
                        src: this.user.avatar64,
                        class: "w-6 h-6"
                    };
                case "sm":
                    return {
                        src: this.user.avatar64,
                        class: "w-8 h-8"
                    };
                case "md":
                    return {
                        src: this.user.avatar,
                        class: "w-10 h-10"
                    };
                case "lg":
                    return {
                        src: this.user.avatar150,
                        class: "w-16 h-16"
                    };
                default:
                case "base":
                    return {
                        src: this.user.avatar,
                        class: "w-12 h-12"
                    };
            }
        }
    }
};
</script>

<style></style>
