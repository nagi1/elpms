<template>
    <div class="mt-5 flex flex-col flex-grow">
        <div
            style="height:30rem;"
            class="chat-wrapper flex flex-col space-y-3 flex-grow"
        >
            <div
                class="chat-messages flex flex-col space-y-5 flex-grow h-full overflow-x-hidden overflow-y-scroll"
            >
                <chat-day
                    v-for="day in messagesGroupedByDay"
                    :key="day.day"
                    :day="day"
                />
            </div>

            <div
                class="chat-new-message flex-grow border border-blue-400 overflow-y-visible  p-2  rounded flex flex items-center space-x-2"
            >
                <textarea-autosize
                    placeholder="Type something here..."
                    ref="chatBox"
                    @keydown.native.enter.exact.prevent="submit"
                    class="appearance-none flex-grow"
                    :class="{ 'text-3xl': onlyEmojis }"
                    v-model="message"
                    :min-height="20"
                    :max-height="250"
                />

                <emoji-adder @input="addEmoji" />
                <button>v</button>
            </div>
        </div>
    </div>
</template>

<script>
import Pusher from "pusher-js";
import timeSolver from "timesolver/timeSolver.min.js";
import { groupBy, chain } from "lodash";

Pusher.logToConsole = true;

const pusher = new Pusher("de239f4fef556f830c2d", {
    cluster: "eu"
});

const channel = pusher.subscribe("chat");
channel.bind("messageSent", function(data) {
    app.messages.push(JSON.stringify(data));
});
export default {
    props: ["messages"],
    components: {
        ChatDay: () => import("@/Shared/Partials/Chat/ChatDay"),
        EmojiAdder: () => import("@/Shared/Components/EmojiAdder")
    },
    data() {
        return {
            message: "",
            onlyEmojis: false
        };
    },
    created() {
        this.$nextTick(() => {
            this.$refs.chatBox.$el.focus();
        });
    },
    watch: {
        message(value) {
            if (value == "") {
                this.onlyEmojis = false;
                return;
            }
            this.onlyEmojis = this.containsOnlyEmojis(value);
        }
    },
    methods: {
        addEmoji(emoji) {
            this.message += emoji;
        },
        submit() {
            console.log(this.message);
        }
    },
    computed: {
        messagesGroupedByDay() {
            let fiveMinuteSession = { userId: 0, time: 0 };
            return chain(this.messages)
                .groupBy("day")
                .map((messages, day) => ({
                    day,
                    messages: messages.map(message => {
                        if (
                            message.user.id === fiveMinuteSession.userId &&
                            Math.abs(
                                new Date(message.createdAt) -
                                    new Date(fiveMinuteSession.time)
                            ) <= 300000 // 5 min
                        ) {
                            message.sameSession = true;
                        }
                        fiveMinuteSession = {
                            userId: message.user.id,
                            time: message.createdAt
                        };
                        return message;
                    })
                }))
                .value();
        }
    }
};
</script>

<style></style>
