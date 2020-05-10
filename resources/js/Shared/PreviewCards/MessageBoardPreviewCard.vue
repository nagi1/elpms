<template>
    <a
        :href="data.path"
        class="border border-gray-400 shadow-md rounded p-5 w-48 h-64 flex flex-col space-y-2"
    >
        <h3 class="font-semibold pb-3 border-b">{{ data.title }}</h3>
        <div class="flex space-x-2 items-center pb-3 border-b">
            <avatar class="flex-shrink-0" size="md" :user="data.user" />
            <span class="text-sm">{{ data.user.name }}</span>
        </div>
        <div class="text-sm mt-1">
            {{ data.cardExcerpt }}
        </div>
    </a>
</template>

<script>
export default {
    name: "MessageBoardPreviewCard",

    props: ["data", "path"]
};
</script>

<style></style>
