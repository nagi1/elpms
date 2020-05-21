<template>
    <div>
        <corner-options-button :sizeClass="buttonSize" @opened="openOptions" />
        <slide-x-right-transition>
            <div
                v-if="open"
                v-on-clickaway="closeOptions"
                class="absolute top-0 right-0 bg-silver-100 w-64 z-30"
            >
                <div class="w-full h-full">
                    <button
                        class="absolute right-0 top-0 mt-3 mr-3 text-white rounded-full border border-white p-1 h-8 w-8"
                        style="top:1px;"
                        @click="closeOptions"
                    >
                        &cross;
                    </button>

                    <div :class="top" class=" text-sm font-medium">
                        <div v-for="(item, index) in items" :key="index">
                            <span
                                v-if="item.section"
                                class="px-3 py-2 text-white text-xs font-extrabold inline-block"
                                >{{ item.section }}</span
                            >
                            <corner-option-item :item="item" />
                        </div>
                        <slot />
                    </div>
                </div>
            </div>
        </slide-x-right-transition>
    </div>
</template>

<script>
import { SlideXRightTransition } from "vue2-transitions";
import { mixin as clickaway } from "vue-clickaway";
import CornerOptionsButton from "@/Shared/Components/CornerOptionsButton";
import CornerOptionItem from "@/Shared/Partials/CornerMenu/CornerOptionItem";

export default {
    props: {
        items: {
            type: Array,
            default: () => []
        },
        top: {
            type: String,
            default: "mt-16"
        },
        buttonSize: {
            type: String
        }
    },
    mixins: [clickaway],
    components: {
        SlideXRightTransition,
        CornerOptionsButton,
        CornerOptionItem
    },
    data() {
        return {
            open: false
        };
    },
    methods: {
        openOptions() {
            this.open = true;
        },
        closeOptions() {
            this.open = false;
        }
    }
};
</script>

<style></style>
