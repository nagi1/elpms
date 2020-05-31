<template>
    <div class="flex space-x-2 items-center">
        <img
            class="h-6"
            src="@/assets/icons/uncheck.svg"
            :alt="event.createdAt"
        />
        <span class="font-semibold">{{ event.content }}</span>
    </div>
</template>

<script>
export default {
    props: ["event"]
};
</script>

<style></style>
