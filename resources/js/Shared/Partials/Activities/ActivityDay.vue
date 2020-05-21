<template>
    <!-- day -->
    <div class="timeline relative px-5 w-full">
        <h2 class="text-center font-bold text-lg pb-5">
            {{ activitiesInDay.day }}
        </h2>
        <div
            :class="{ 'timeline-left': isRight }"
            class="timeline-container relative sm:w-1/2 space-y-5"
        >
            <div
                v-for="activity in activitiesInDay.activities"
                :key="activity.id"
                class="timeline-card flex justify-between"
            >
                <activity-item
                    :activity="activity"
                    :class="{
                        'sm:order-1': isLeft,
                        'sm:order-2': isRight
                    }"
                />
                <p
                    :class="{
                        'sm:order-1': isRight,
                        'sm:order-2': isLeft,
                        'sm:mr-2 sm:ml-8': isLeft,
                        'sm:ml-2 sm:mr-8': isRight
                    }"
                    class="sm:text-xs text-sm"
                >
                    {{ activity.time }}
                </p>
            </div>
        </div>
    </div>
    <!-- /day -->
</template>

<script>
export default {
    components: {
        activityItem: () => import("@/Shared/Partials/Activities/ActivityItem")
    },
    props: {
        direction: {
            type: String,
            default: "left"
        },
        activitiesInDay: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            isRight: this.direction === "right",
            isLeft: this.direction === "left"
        };
    }
};
</script>

<style></style>
