<template>
    <div class="space-y-5">
        <!-- day -->
        <activity-day
            :key="activitiesInDay.day"
            v-for="activitiesInDay in activitiesGroupedByDays"
            :direction="activitiesInDay.direction"
            :activitiesInDay="activitiesInDay"
        />
        <!-- /day -->
    </div>
</template>

<script>
import { groupBy, chain, sortBy } from "lodash";
export default {
    props: ["activities"],
    components: {
        ActivityDay: () => import("@/Shared/Activities/ActivityDay")
    },
    // created() {
    //     console.log(this.direction);
    //     console.log(this.activitiesGroupedByDays);
    //     console.log(this.direction);
    // },
    data() {
        return {
            direction: "right"
        };
    },
    computed: {
        activitiesGroupedByDays() {
            return chain(this.activities)
                .groupBy("day")
                .map((value, key) => {
                    this.changeDirection();
                    return {
                        day: key,
                        activities: value,
                        direction: this.direction
                    };
                })
                .value();
        }
    },

    methods: {
        changeDirection() {
            if (this.direction === "left") {
                this.direction = "right";
            } else {
                this.direction = "left";
            }
        }
    }
};
</script>

<style></style>
