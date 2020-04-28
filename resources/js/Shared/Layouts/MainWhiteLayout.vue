<template>
    <Layout>
        <div
            class="relative panel max-w-4xl border border-gray-400  flex flex-col justify-center bg-white w-full py-10 mt-1 px-3 rounded-lg shadow-xl"
        >
            <slot />
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layouts/Layout";
export default {
    components: {
        Layout
    }
};
</script>
