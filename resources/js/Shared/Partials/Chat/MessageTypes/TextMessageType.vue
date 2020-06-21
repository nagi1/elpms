<template>
    <span :class="{ 'text-3xl': containsOnlyEmojis(message) }">
        {{ message }}
    </span>
</template>

<script>
export default {
    name: "TextMessageType",
    props: ["message"]
};
</script>

<style></style>
