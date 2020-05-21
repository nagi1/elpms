<template>
    <div class="bg-orange-100 rounded-lg py-5 w-full relative">
        <div class="flex flex-col">
            <corner-options-menu top="mt-3">
                <a
                    href=""
                    class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-white h-6"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25"
                        />
                    </svg>
                    <span class="font-medium">Notify</span>
                </a>
            </corner-options-menu>

            <div class="flex items-center space-x-3">
                <span class="absolute top-0 text-sm right-0 mt-3 pr-12">{{
                    event.createdAt
                }}</span>

                <avatar-modal :user="event.user" size="base" />

                <div class="pr-3">
                    <component :is="eventType" :event="event" />
                </div>
            </div>

            <div class="mt-5 ml-5">
                <boosts
                    :boosts="event.boosts"
                    model="Event"
                    :modelId="event.id"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CornerOptionsMenu from "@/Shared/Partials/CornerMenu/CornerOptionsMenu";
import Boosts from "@/Shared/Partials/Boosts/Boosts";

export default {
    name: "Event",
    props: ["event", "model"],
    components: {
        CornerOptionsMenu,
        Boosts
    },

    created() {
        this.eventType = () =>
            import(
                `@/Shared/Partials/Events/Types/${this.event.type}EventType.vue`
            );
    },

    data() {
        return {
            eventType: ""
        };
    }
};
</script>

<style></style>
