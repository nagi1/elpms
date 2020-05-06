<template>
    <double-white-layout
        :breadcrumps="[
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
                text: 'Message Board'
            }
        ]"
    >
        <corner-options-menu
            :items="[
                {
                    type: 'a',
                    link: route('messageBoards.edit', routeData),
                    iconPath:
                        'M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z',
                    text: 'Edit'
                },
                {
                    link: route('move.show', {
                        project: project.id,
                        account: account.id,
                        model: 'MessageBoard',
                        id: messageBoard.id
                    }),
                    iconPath:
                        'M3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19M17,12L12,7V10H8V14H12V17L17,12Z',
                    text: 'Move'
                },
                {
                    link: '#',
                    iconPath:
                        'M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z',
                    text: 'Put in the trash'
                },

                {
                    section: 'Share',
                    link: '#',
                    iconPath:
                        'M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M6,10V7H4V10H1V12H4V15H6V12H9V10M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12Z',
                    text: 'Send this to someone'
                },
                {
                    section: 'History',
                    link: '#',
                    iconPath:
                        'M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z',
                    text: 'View changelog'
                },
                {
                    link: '#',
                    modal: 'notifiedUsers',
                    iconPath:
                        'M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z',
                    text: 'Notify 1 persons'
                }
            ]"
        >
            <inertia-link
                href=""
                @click.prevent="archive"
                class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-6"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M3 3H21V7H3V3M4 21V8H20V21H4M14 14V11H10V14H7L12 19L17 14H14Z"
                    />
                </svg>
                <span class="font-medium">{{
                    messageBoard.archived ? "Unarchive" : "Archive"
                }}</span>
            </inertia-link>
        </corner-options-menu>

        <div class="w-full h-full md:py-5 sm:px-20 overflow-hidden">
            <h1 class="text-3xl font-bold border-b pb-3">
                {{ messageBoard.title }}
            </h1>

            <div class="mt-3 flex justify-between  border-b pb-3">
                <div class="flex space-x-2">
                    <img
                        class="rounded-full h-12 w-12"
                        :src="messageBoard.user.avatar"
                        :alt="messageBoard.user.name"
                    />

                    <div class="leading-6">
                        <div class=" text-sm text-yellow-900 opacity-75 ">
                            <span v-if="messageBoard.category"
                                >{{ messageBoard.category.fullName }} by</span
                            >
                            <span>{{ messageBoard.user.name }}</span>
                            <span class="block">{{
                                messageBoard.shortDate
                            }}</span>
                        </div>
                    </div>
                </div>

                <span
                    v-if="messageBoard.commentsCount > 0"
                    class="bg-gray-700  text-white font-bold flex items-center justify-center text-lg p-3 h-8 w-8 rounded-full"
                    >{{ messageBoard.commentsCount }}</span
                >
            </div>

            <div class="mt-5" v-html="messageBoard.trixRichText"></div>

            <div class="mt-5">
                <boosts
                    :boosts="messageBoard.boosts"
                    model="MessageBoard"
                    :modelId="messageBoard.id"
                />
            </div>

            <comment-section
                model="MessageBoard"
                :modelId="messageBoard.id"
                :comments="messageBoard.comments"
                :commentsCount="messageBoard.commentsCount"
                :trix="trix"
            />
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import CornerOptionsMenu from "@/Shared/CornerOptionsMenu";
import LoadingButton from "@/Shared/LoadingButton";
import CommentSection from "@/Shared/Comments/CommentSection";
import Boosts from "@/Shared/Boosts/Boosts";

export default {
    components: {
        DoubleWhiteLayout,
        CornerOptionsMenu,
        LoadingButton,
        CommentSection,
        Boosts
    },

    props: ["account", "project", "messageBoard", "trix"],

    data() {
        return {
            routeData: {
                account: this.account.id,
                project: this.project.id,
                messageBoard: this.messageBoard.id
            }
        };
    },

    methods: {
        archive() {
            this.$inertia.post(
                route("archive.store", {
                    account: this.account.id,
                    project: this.project.id
                }),
                {
                    model: "MessageBoard",
                    modelId: this.messageBoard.id
                }
            );
        }
    }
};
</script>

<style></style>
