<template>
    <div class="relative">
        <button
            @click="openForm"
            class="flex items-center rounded-full shadow border bg-white px-3"
        >
            <span class="text-green-500 text-xl">+</span>
            <span class="ml-1 text-sm">New</span>
        </button>

        <scale-transition>
            <div
                v-if="open"
                v-on-clickaway="close"
                class="absolute bg-white shadow border-2 top-0 mt-5 px-3 pt-5 h-35 w-64 z-20"
            >
                <small-form
                    :placeholder="placeholder"
                    :post="{
                        route: {
                            name: 'projects.store',
                            params: { account: this.$page.account.id }
                        },
                        data: {
                            type: this.for
                        }
                    }"
                    @closed="close"
                />
            </div>
        </scale-transition>
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import SmallForm from "@/Shared/Components/SmallForm";
import { ScaleTransition } from "vue2-transitions";

export default {
    mixins: [clickaway],
    components: {
        SmallForm,
        ScaleTransition
    },
    props: {
        for: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            open: false
        };
    },
    computed: {
        placeholder() {
            return `Name this ${this.for}`;
        }
    },
    methods: {
        openForm() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        }
    }
};
</script>

<style></style>
