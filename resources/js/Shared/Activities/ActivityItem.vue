<template>
    <div class="flex justify-start space-x-2">
        <avatar-modal class="flex-shrink-0" :user="activity.user" size="base" />
        <component :is="activityCard" :activityData="activity" />
    </div>
</template>

<script>
export default {
    props: ["activity"],
    data() {
        return {
            activityCard: ""
        };
    },
    created() {
        this.activityCard = () =>
            import(
                `@/Shared/Activities/Cards/${this.activity.action}ActivityCard.vue`
            );
    }
};
</script>

<style></style>
