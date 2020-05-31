<template>
    <label
        class="flex items-center space-x-1 bg-red-100 py-1 px-2 rounded-full"
    >
        <avatar-modal :size="size" :user="user" />
        <span :class="{ 'text-xs': size === 'nano' }" class="text-yellow-900">{{
            user.shortName
        }}</span>
    </label>
</template>

<script>
export default {
    props: { user: { required: true }, size: { default: "xs" } }
};
</script>

<style></style>
