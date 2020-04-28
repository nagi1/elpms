<template>
    <div
        v-if="load"
        ref="megaMenu"
        class="absolute top-0 mt-10 w-full flex justify-center"
    >
        <div
            v-on-clickaway="close"
            class="bg-white w-full md:w-3/5 shadow-lg rounded border p-8"
        >
            <component :is="load" />
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";

export default {
    mixins: [clickaway],
    components: {
        TalksMegaMenu: () => import("@/shared/MegaMenus/TalksMegaMenu"),
        HeyMegaMenu: () => import("@/shared/MegaMenus/HeyMegaMenu")
    },
    props: ["load"],

    methods: {
        close() {
            this.$emit("closed");
        }
    }
};
</script>

<style></style>
