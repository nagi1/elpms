<template>
    <div class="">
        <avatar @click.native="open = true" :user="user" :size="size" />
        <modal @close="close" :open="open">
            <div
                style="max-height:35rem;"
                class="relative max-w-sm w-full flex flex-col items-center mx-auto bg-silver-200 rounded-lg shadow-2xl px-6 py-6"
            >
                <span
                    @click="close"
                    class="absolute top-0 right-0 mt-3 cursor-pointer mr-3 text-white text-2xl"
                    >&cross;</span
                >
                <img
                    class="rounded-full h-32 w-32 object-cover border-2 border-silver-200"
                    :src="user.avatar150"
                    :alt="user.name"
                />
                <span
                    class="-m-5 bg-red-600 rounded-full p-2 w-24 text-white text-center text-lg"
                    >Badge</span
                >

                <div
                    class="mt-8 text-center flex flex-col items-center space-y-3"
                >
                    <span class="text-xl font-bold  text-gray-200">{{
                        user.name
                    }}</span>
                    <span class="text-gray-200">Title at company</span>
                    <span class="text-gray-500 text-sm">8:50 pm EEST</span>
                </div>

                <div class="mt-10 flex-col items-center p-2 w-full space-y-2">
                    <inertia-link
                        href="#"
                        class="block rounded-lg bg-silver-400 text-center py-3 text-white font-semibold"
                    >
                        option 1
                    </inertia-link>
                    <inertia-link
                        href="#"
                        class="block rounded-lg hover:bg-silver-400 bg-silver-300 text-center py-3 text-white font-semibold"
                    >
                        option 1
                    </inertia-link>
                    <inertia-link
                        href="#"
                        class="block rounded-lg hover:bg-silver-400 bg-silver-300 text-center py-3 text-white font-semibold"
                    >
                        option 1
                    </inertia-link>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import Modal from "@/Shared/Components/Modal";

export default {
    components: {
        Modal,
        avatar: () => import("@/Components/Avatar")
    },
    props: {
        user: {
            type: Object,
            required: true
        },
        size: {
            type: String,
            default: "normal"
        }
    },

    data() {
        return {
            open: false
        };
    },

    methods: {
        close() {
            this.open = false;
        }
    }
};
</script>

<style></style>
