<template>
    <main class="min-h-screen">
        <main-header />
        <article
            class="inner-app relative flex flex-col justify-center items-center h-full w-full"
        >
            <slot />

            <fade-transition :delay="300">
                <flash-message
                    v-if="showFlash"
                    class="absolute top-0 mt-3"
                ></flash-message>
            </fade-transition>
        </article>
        <portal-target name="modals"></portal-target>
    </main>
</template>

<script>
import MainHeader from "@/shared/MainHeader";
import FlashMessage from "@/Shared/Components/FlashMessage";
import { FadeTransition } from "vue2-transitions";

export default {
    components: {
        MainHeader,
        FlashMessage,
        FadeTransition
    },

    data() {
        return {
            showFlash: this.$page.flash.success ? true : false
        };
    },

    created() {
        setTimeout(() => {
            this.showFlash = false;
        }, 3000);
    }
};
</script>
