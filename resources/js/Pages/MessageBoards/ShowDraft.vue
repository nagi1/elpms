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
                    link: '#',
                    iconPath:
                        'M3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19M17,12L12,7V10H8V14H12V17L17,12Z',
                    text: 'Move'
                },

                {
                    link: '#',
                    iconPath:
                        'M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z',
                    text: 'Delete this draft'
                }
            ]"
        >
        </corner-options-menu>

        <div class="self-center w-full sm:px-20 mt-5">
            <div
                class="bg-pink-100 rounded-lg  text-center  justify-center items-center flex flex-col p-8 space-y-3"
            >
                <div class=" tracking-normal leading-5">
                    <span class="font-semibold">This unpublished draft</span>
                    was edited {{ messageBoard.updated_at }}.
                    <a @click.prevent="sharePublicLink" class="normal-link"
                        >Share a link</a
                    >
                    or…
                </div>
                <div class="flex items-center space-x-2">
                    <a
                        :href="
                            route('messageBoards.edit', {
                                account: account.id,
                                project: project.id,
                                messageBoard: messageBoard.id
                            })
                        "
                        class="rounded-full p-3 bg-gray-700 text-gray-200 text-lg antialiased "
                        type="submit"
                    >
                        Continue editing
                    </a>

                    <button
                        class="rounded-full p-3 bg-white border border-gray-700  text-llg"
                        type="submit"
                        @click="publish"
                    >
                        Post this message
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full mt-10 h-full md:py-5 sm:px-20 overflow-hidden">
            <h1 class="text-3xl font-bold border-b pb-3">
                {{ messageBoard.title }}
            </h1>

            <div class="mt-3 flex items-center space-x-2 border-b pb-3">
                <img
                    class="rounded-full h-12 w-12"
                    :src="messageBoard.user.avatar"
                    :alt="messageBoard.user.name"
                />

                <div class="leading-6 ">
                    <span>{{ messageBoard.user.name }}</span>
                </div>
            </div>

            <div class="mt-5" v-html="messageBoard.trixRichText"></div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import CornerOptionsMenu from "@/Shared/CornerOptionsMenu";
import LoadingButton from "@/Shared/LoadingButton";

export default {
    components: {
        DoubleWhiteLayout,
        CornerOptionsMenu,
        LoadingButton
    },

    props: ["account", "project", "messageBoard"],

    data() {
        return {};
    },
    methods: {
        publish() {
            this.$inertia.put(
                route("messageBoards.draft.publish", {
                    account: this.account.id,
                    project: this.project.id,
                    messageBoard: this.messageBoard.id
                }),
                {}
            );
        }
    }
};
</script>

<style></style>
