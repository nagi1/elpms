<template>
    <bucket-card :link="link" name="Message Board">
        <div class="flex flex-col justify-center items-center mt-1 h-full">
            <div
                v-if="emptyBucket"
                class="flex flex-col justify-center items-center h-full"
            >
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

            <div v-else>
                Bitch!
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
    props: ["bucket", "link"],
    computed: {
        emptyBucket() {
            return this.bucket.length === 0;
        }
    }
};
</script>

<style></style>
