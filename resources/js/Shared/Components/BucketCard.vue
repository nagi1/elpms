<template>
    <!-- card -->
    <inertia-link
        :href="link"
        class="card h-48 sm:h-64 shadow-md border border-gray-400 p-3 sm:p-5 flex flex-col"
    >
        <h2
            class="font-bold text-base sm:text-lg text-center border-b pb-3 border-gray-400"
        >
            {{ name }}
        </h2>

        <slot />
    </inertia-link>
    <!-- /card -->
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        },
        link: {
            type: String,
            default: () => "#"
        }
    }
};
</script>

<style></style>
