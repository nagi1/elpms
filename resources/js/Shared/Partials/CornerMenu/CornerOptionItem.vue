<template>
    <div>
        <a
            v-if="item.type == 'a'"
            :href="item.link"
            class="flex items-center cursor-pointer transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-white h-6"
                version="1.1"
                viewBox="0 0 24 24"
            >
                <path :d="item.iconPath" />
            </svg>
            <span class="font-medium">{{ item.text }}</span>
        </a>

        <inertia-link
            v-if="!item.type || item.type == 'inertia-link'"
            :href="item.link"
            class="flex items-center cursor-pointer transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-white h-6"
                version="1.1"
                viewBox="0 0 24 24"
            >
                <path :d="item.iconPath" />
            </svg>
            <span class="font-medium">{{ item.text }}</span>
        </inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            require: true
        }
    }
};
</script>

<style></style>
