<template>
    <div
        style="max-height:35rem;"
        class="max-w-2xl w-full bg-white rounded-lg shadow-2xl px-6 py-6 overflow-y-scroll"
    >
        <h2
            class="font-semibold text-gray-900 text-xl leading-tight border-gray-200"
        >
            Message categories for {{ project.name }}
        </h2>
        <p class="mt-1 text-sm  leading-6 tracking-wide">
            Set up categories for this project below. You can also
            <a href="#">change categories for the whole account</a> in
            Adminland.
        </p>

        <div class="mt-10 w-full">
            <category-row
                v-for="category in project.categories"
                :key="category.id"
                :category="category"
            />

            <new-category-row
                @closed="newRow = false"
                v-if="newRow"
                :modelId="project.id"
                modelType="project"
            />
            <button
                v-if="!newRow"
                class="flex items-center border mt-5 border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
            >
                <span @click="newRow = true" class="text-sm"
                    >Add a category</span
                >
            </button>
        </div>
    </div>
</template>

<script>
import CategoryRow from "@/shared/Components/CategoryRow";
import NewCategoryRow from "@/shared/Components/NewCategoryRow";
import { SlideXRightTransition } from "vue2-transitions";

export default {
    props: ["project", "account"],
    components: {
        CategoryRow,
        NewCategoryRow,
        SlideXRightTransition
    },
    data() {
        return {
            newRow: false
        };
    }
};
</script>

<style></style>
