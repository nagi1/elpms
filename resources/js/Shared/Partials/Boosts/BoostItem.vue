<template>
    <div
        @click="showDelete = !showDelete"
        class="flex cursor-pointer items-center space-x-1 bg-white rounded-full py-1 px-2"
    >
        <avatar-modal :user="boost.user" size="xs" />
        <span class="text-base">{{ boost.content }}</span>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            v-if="showDelete"
            @click="remove(boost.id)"
            class="fill-red-500 h-5 cursor-pointer"
            version="1.1"
            viewBox="0 0 24 24"
        >
            <path
                d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
            />
        </svg>
    </div>
</template>

<script>
export default {
    props: ["boost"],
    data() {
        return {
            showDelete: false
        };
    },
    methods: {
        remove(id) {
            this.$inertia.delete(
                route("boosts.delete", {
                    account: this.$page.account.id,
                    project: this.$page.project.id,
                    boost: id
                })
            );
        }
    }
};
</script>

<style></style>
