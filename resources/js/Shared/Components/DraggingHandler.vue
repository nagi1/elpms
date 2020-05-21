<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        class="fill-gray-500 h-5 cursor-move"
        version="1.1"
        viewBox="0 0 24 24"
        :class="classes + ` ${name}`"
    >
        <path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
    </svg>
</template>

<script>
export default {
    props: {
        classes: {
            type: Array,
            default: () => []
        },
        name: {
            type: String,
            default: "handle"
        }
    }
};
</script>

<style></style>
