<template>
    <bucket-card :link="link" name="Message Board">
        <div
            v-if="empty"
            class="flex flex-col justify-center items-center mt-1 h-full"
        >
            <div class="flex flex-col justify-center items-center h-full">
                <div
                    class="rounded-full sm:h-20 sm:w-20 h-24 w-24 flex items-center justify-center bg-blue-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        class="fill-current text-white sm:h-12 h-16"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M5,5V7H19V5H5M5,9V11H13V9H5M5,13V15H15V13H5Z"
                        />
                    </svg>
                </div>
                <p
                    class="mt-3 hidden sm:block text-center text-sm leading-tight"
                >
                    Post announcements, pitch ideas, progress updates, etc. and
                    keep feedback on-topic.
                </p>
            </div>
        </div>
        <div class="flex flex-col space-y-2 mt-3 h-full overflow-hidden" v-else>
            <div
                class="flex space-x-1 truncate"
                v-for="messageBoard in messageBoards"
                :key="messageBoard.id"
            >
                <img
                    class="h-6"
                    :src="messageBoard.user.avatar64"
                    :alt="messageBoard.user.name"
                />
                <div class="leading-4">
                    <p class="text-xs font-bold">{{ messageBoard.title }}</p>
                    <p class="text-xs">
                        <span v-if="messageBoard.category"
                            >{{ messageBoard.category.fullName }} &minus; </span
                        >{{ messageBoard.cardExcerpt }}
                    </p>
                </div>
            </div>
        </div>
    </bucket-card>
</template>

<script>
import BucketCard from "@/Shared/Components/BucketCard";
export default {
    components: {
        BucketCard
    },
    props: ["messageBoards", "link"],
    computed: {
        empty() {
            return this.messageBoards.length === 0;
        }
    }
};
</script>

<style></style>
