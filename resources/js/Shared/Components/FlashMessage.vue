<template>
    <div
        class="px-3 py-2 rounded-full h-8 items-center flex max-w-xs bg-gray-700 text-white space-x-1"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 fill-current text-green-500"
            version="1.1"
            viewBox="0 0 24 24"
        >
            <path
                d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"
            />
        </svg>

        <span class="font-semibold">{{ $page.flash.success }}</span>
    </div>
</template>

<script>
export default {};
</script>

<style></style>
