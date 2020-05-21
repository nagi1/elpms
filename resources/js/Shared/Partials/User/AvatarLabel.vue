<template>
    <label
        class="flex items-center space-x-1 bg-red-100 py-1 px-2 rounded-full"
    >
        <avatar-modal size="xs" :user="user" />
        <span class="text-yellow-900">{{ user.shortName }}</span>
    </label>
</template>

<script>
export default {
    props: ["user"]
};
</script>

<style></style>
