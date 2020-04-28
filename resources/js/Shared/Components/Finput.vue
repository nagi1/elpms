<template>
    <label class="has-float-label border rounded">
        <input
            type="text"
            class="p-1 focus:shadow-outline placeholder-gray-800"
            placeholder=""
        />
        <span>{{ placeholder }}</span>
    </label>
</template>

<script>
export default {
    props: ["placeholder"]
};
</script>

<style scoped>
.label-floating input:not(:placeholder-shown) {
    padding-top: 1.4rem;
}
.label-floating input:not(:placeholder-shown) ~ label {
    font-size: 0.6rem;
    transition: all 0.2s ease-in-out;
}
</style>
