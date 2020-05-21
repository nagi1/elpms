<template>
    <div class="flex flex-col">
        <header
            class="flex w-full flex-col items-center sm:flex-row justify-between py-5 px-2 sm:px-8"
        >
            <div class="flex items-center space-x-2">
                <logo class="fill-current h-12" />
                <span class="text-xl font-bold ml-2">ELPMS</span>
            </div>

            <div
                class="flex items-center justify-between mt-3 sm:mt-0 space-x-2 sm:space-x-3"
            >
                <inertia-link href="#">Activity Logs</inertia-link>
                <inertia-link href="#">Edit my profile</inertia-link>
                <inertia-link href="#">Login &amp; Secuirty</inertia-link>
                <inertia-link href="#">Logout</inertia-link>
            </div>
        </header>
        <div
            class="bg-white max-w-xs w-full self-center mt-10 shadow border p-5"
        >
            <header class="border-b-2 text-center text-lg pb-3">
                Choose Account
            </header>

            <inertia-link
                v-for="account in accounts"
                :key="account.id"
                :href="route('index', { account: account.id })"
                class="text-center flex justify-center flex-col mt-5"
            >
                <logo class="fill-current h-16" />
                <div class="text-lg tracking-wide mt-3">{{ account.name }}</div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Logo from "@/Shared/Components/Logo";

export default {
    props: ["accounts"],
    components: {
        Logo
    },
    metaInfo: { title: "Dashboard" }
};
</script>
