<template>
    <div
        :key="message.id"
        class="flex w-full  items-start mb-5"
        :class="{
            'message-right': sentByAuth,
            'message-left': !sentByAuth,
            'self-start': sentByAuth,
            'self-end': !sentByAuth,
            'justify-end': !sentByAuth,
            '-mt-2': message.sameSession
        }"
    >
        <avatar-modal
            :user="message.user"
            size="md"
            class="flex-shrink-0 "
            :class="{
                invisible: message.sameSession,
                'order-2': !sentByAuth,
                'order-1': sentByAuth,
                'ml-2': !sentByAuth,
                'mr-2': sentByAuth
            }"
        />
        <div
            class="message-body flex flex-col space-y-1 order-1 bg-opacity-25 rounded-lg p-3"
            :class="{ 'bg-gray-400': !sentByAuth, 'bg-blue-300': sentByAuth }"
        >
            <div
                class="info flex space-x-1 items-baseline"
                :class="{ 'justify-end': !sentByAuth }"
            >
                <span class="font-semibold text-xs">Me</span>
                <span class="text-xs">12:05pm</span>
                <span v-if="sentByAuth" class="text-gray-600 tracking-wider"
                    >&bull;&bull;&bull;</span
                >
            </div>
            <div>
                <component
                    :is="messageTypeComponent"
                    :message="message.message"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["message", "sentByAuth"],
    data() {
        return {
            messageTypeComponent: "",
            type: this.message.type
        };
    },
    created() {
        if (this.type == "") {
            this.type = "Text";
        }
        this.messageTypeComponent = () =>
            import(
                `@/Shared/Partials/Chat/MessageTypes/${this.type}MessageType.vue`
            );
    }
};
</script>

<style></style>
