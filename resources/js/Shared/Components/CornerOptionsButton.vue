<template>
    <!-- options circule-->
    <div class="absolute top-0 right-0 m-2 z-20">
        <button
            @click="open"
            class="rounded-full active:bg-gray-200 hover:bg-gray-100 border border-gray-400 bg-white p-1"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current"
                :class="sizeClass"
                viewBox="0 0 36 36"
            >
                <path
                    d="M9 15c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm18 0c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm-9 0c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"
                />
            </svg>
        </button>
    </div>
    <!-- /options circule-->
</template>

<script>
export default {
    props: {
        sizeClass: {
            type: String,
            default: "h-6"
        }
    },

    methods: {
        open() {
            this.$emit("opened");
        }
    }
};
</script>

<style></style>
