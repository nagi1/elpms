<template>
    <div class="relative">
        <div class="cursor-pointer outline-none">
            <button
                class="focus:outline-none h-6 w-6 focus:shadow-outline rounded-full"
                @click="open = !open"
            >
                <svg
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 fill-current text-gray-400"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"
                    />
                </svg>
            </button>
        </div>

        <scale-transition>
            <div
                class="absolute z-10 border w-56 rounded-lg p-4 rounded bg-white shadow mt-2"
                v-on-clickaway="close"
                v-if="open"
            >
                <div class="flex flex-wrap justify-start space-x-2">
                    <button
                        class="p-1 cursor-pointer rounded hover:bg-gray-300 text-2xl flex items-center justify-center h-6 w-6"
                        v-for="(emoji, index) in emojis"
                        :key="index"
                        @click="select(emoji)"
                    >
                        {{ emoji }}
                    </button>
                </div>
            </div>
        </scale-transition>
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import { ScaleTransition } from "vue2-transitions";
export default {
    components: {
        ScaleTransition
    },
    mixins: [clickaway],
    data() {
        return {
            emojis: ["😀", "😂", "😎"],
            open: false
        };
    },

    methods: {
        select(emoji) {
            this.$emit("input", emoji);
        },
        close() {
            this.open = false;
        }
    }
};
</script>

<style scoped></style>
