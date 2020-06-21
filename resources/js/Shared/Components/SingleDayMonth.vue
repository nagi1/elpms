<template>
    <div
        class="w-14 h-13 p-1  flex flex-col justify-center items-center space-y-1 rounded-md"
    >
        <div class="text-sm text-white text-center">
            {{ month }}
        </div>
        <div
            class="flex justify-center font-medium flex-grow w-full items-center bg-white text-lg rounded"
        >
            {{ day }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        day: {
            required: true
        },
        month: {
            required: true
        }
    }
};
</script>

<style></style>
