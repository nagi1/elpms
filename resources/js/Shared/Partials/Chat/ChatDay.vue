<template>
    <div class="chat-day">
        <divider class="mb-5">
            <span class="text-lg tracking-wider font-semibold px-1">{{
                day.day
            }}</span>
        </divider>

        <div class="messages flex flex-col mx-3">
            <chat-message
                v-for="message in day.messages"
                :key="message.id"
                :message="message"
                :sentByAuth="$page.auth.user.id === message.user.id"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ["day"],
    components: {
        ChatMessage: () => import("@/Shared/Partials/Chat/ChatMessage.vue"),
        Divider: () => import("@/Shared/Components/Divider")
    }
};
</script>

<style></style>
