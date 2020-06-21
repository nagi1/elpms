<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-center  md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <h1 class="text-3xl font-bold ">Chat</h1>
            </div>

            <chat-section :messages="messages" />
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import timeSolver from "timesolver/timeSolver.min.js";

export default {
    components: {
        DoubleWhiteLayout,
        ChatSection: () => import("@/Shared/Partials/Chat/ChatSection")
    },

    props: ["account", "project"],

    created() {},

    data() {
        return {
            messages: [
                {
                    id: 1,

                    user: {
                        id: 1,
                        name: "Lee Conroy",
                        avatar64:
                            "http://localhost:8000/storage/1/conversions/avatar-size-64.png",
                        avatar150:
                            "http://localhost:8000/storage/1/conversions/avatar-size-150.png",
                        avatar: "http://localhost:8000/storage/1/avatar.png",
                        company: "Satterfield, Conn and Greenfelder",
                        title: "Dental Assistant"
                    },
                    type: "Text",
                    message: "😎😎😎",

                    createdAt: "2020-6-2 18:00:00",
                    day: "Today"
                },
                {
                    id: 2,

                    user: {
                        id: 1,
                        name: "Lee Conroy",
                        avatar64:
                            "http://localhost:8000/storage/1/conversions/avatar-size-64.png",
                        avatar150:
                            "http://localhost:8000/storage/1/conversions/avatar-size-150.png",
                        avatar: "http://localhost:8000/storage/1/avatar.png",
                        company: "Satterfield, Conn and Greenfelder",
                        title: "Dental Assistant"
                    },
                    type: "Text",
                    message: "message 2",

                    createdAt: "2020-6-2 18:01:00",
                    day: "Today"
                },
                {
                    id: 3,

                    user: {
                        id: 2,
                        name: "Lee Conroy",
                        avatar64:
                            "http://localhost:8000/storage/1/conversions/avatar-size-64.png",
                        avatar150:
                            "http://localhost:8000/storage/1/conversions/avatar-size-150.png",
                        avatar: "http://localhost:8000/storage/1/avatar.png",
                        company: "Satterfield, Conn and Greenfelder",
                        title: "Dental Assistant"
                    },
                    type: "Text",
                    message: "message 2",

                    createdAt: "2020-6-2 18:10:00",
                    day: "Today"
                }
            ]
        };
    },

    methods: {
        formatDate(date) {
            const isCurrentYear =
                new Date().getFullYear() === date.getFullYear();
            const options = {
                weekday: "short",
                month: "long",
                day: "numeric"
            };
            if (!isCurrentYear) {
                options.year = "numeric";
            }
            return date.toLocaleDateString("en-US", options);
        }
    }
};
</script>

<style></style>
