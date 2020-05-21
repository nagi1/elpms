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
            <event
                v-for="event in events"
                :key="event.id"
                :event="event"
                :model="model"
            />
        </div>
    </div>
</template>

<script>
import Event from "@/Shared/Partials/Events/Event";

export default {
    components: {
        Event
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
