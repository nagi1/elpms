<template>
    <div>
        <div class="mt-20">
            <h2 class="divided space-x-3">
                <span class="font-semibold text-2xl">Actions</span>
                <span class="divider border-black"></span>
            </h2>
        </div>

        <div
            v-if="hasEvents"
            class="mt-10  flex flex-col space-y-3 items-center"
        >
            <change-event
                v-for="event in events"
                :key="event.id"
                :event="event"
                :model="model"
            />
        </div>
        <div class="mt-10 flex justify-center" v-else>
            <h3 class="text-lg">No changes yet</h3>
        </div>
    </div>
</template>

<script>
export default {
    components: {
        ChangeEvent: () => import("@/Shared/Partials/ChangeEvents/ChangeEvent")
    },
    props: {
        model: {
            type: String,
            required: true
        },
        events: {
            type: Array,
            required: true
        }
    },

    computed: {
        hasEvents() {
            return this.events.length > 0;
        }
    }
};
</script>

<style></style>
