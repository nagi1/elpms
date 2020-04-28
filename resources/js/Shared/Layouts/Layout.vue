<template>
    <main class="min-h-screen">
        <main-header />
        <article
            class="inner-app relative flex flex-col justify-center items-center h-screen w-full"
        >
            <slot />
        </article>
        <portal-target name="modals"></portal-target>
    </main>
</template>

<script>
import MainHeader from "@/shared/MainHeader";

export default {
    components: {
        MainHeader
    }
};
</script>
