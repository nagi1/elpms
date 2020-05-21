<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            },
            {
                link: route('messageBoards.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'Message boards'
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-center md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <h1 class="text-3xl font-bold">Message Board</h1>
            </div>

            <div class="mt-10 md:px-10 flex flex-col space-y-4">
                <div
                    v-for="messageBoard in messageBoards"
                    :key="messageBoard.id"
                    class="block flex justify-between items-center border-b pb-3 overflow-x-hidden"
                >
                    <div class="flex space-x-2 flex-grow">
                        <avatar-modal size="base" :user="messageBoard.user" />

                        <inertia-link
                            :href="
                                route('messageBoards.show', {
                                    account: account.id,
                                    project: project.id,
                                    messageBoard: messageBoard.id
                                })
                            "
                            class="leading-6 flex-grow "
                        >
                            <h2 class="font-bold text-lg tracking-wide">
                                {{ messageBoard.title }}
                            </h2>
                            <div class=" text-sm text-yellow-900 opacity-75 ">
                                <span v-if="messageBoard.category"
                                    >{{
                                        messageBoard.category.fullName
                                    }}
                                    by</span
                                >
                                <span>{{ messageBoard.user.name }}</span> &bull;
                                <span>{{ messageBoard.shortDate }}</span>
                                &minus;
                                <span
                                    v-if="messageBoard.excerpt"
                                    class="text-black text-base truncate"
                                    >&ldquo;{{
                                        messageBoard.excerpt
                                    }}&rdquo;</span
                                >
                            </div>
                        </inertia-link>
                    </div>
                    <span
                        v-if="messageBoard.commentsCount > 0"
                        class="bg-gray-700  text-white font-bold flex items-center justify-center text-lg p-3 h-8 w-8 rounded-full"
                        >{{ messageBoard.commentsCount }}</span
                    >
                </div>
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";

export default {
    components: {
        DoubleWhiteLayout
    },

    props: ["account", "project", "messageBoards"]
};
</script>

<style></style>
