<template>
    <div
        class="flex justify-between items-baseline border-b border-gray-400 pb-4 space-y-3"
    >
        <span class="font-bold">{{ category.fullName }}</span>
        <span class="flex items-center space-x-1">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current h-6"
                version="1.1"
                viewBox="0 0 24 24"
            >
                <path
                    d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"
                />
            </svg>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current h-6"
                version="1.1"
                viewBox="0 0 24 24"
            >
                <path
                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
                />
            </svg>
        </span>
    </div>
</template>

<script>
export default {
    props: ["category"]
};
</script>

<style></style>
