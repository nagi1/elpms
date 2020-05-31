<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-center md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <div class="flex flex-col space-y-2">
                    <h1 class="text-3xl font-bold">Trash</h1>
                </div>
            </div>

            <div
                v-for="(groupedBuckets, index) in bucketsGroupedByUser"
                :key="index"
                class="mt-10 flex flex-col flex-grow"
            >
                <div class="flex flex-col items-center space-y-3">
                    <h2 class="font-bold text-2xl">
                        {{
                            groupedBuckets.createdByAuthUser
                                ? "Items you created"
                                : "Items created by other people"
                        }}
                    </h2>
                    <div
                        v-if="groupedBuckets.createdByAuthUser"
                        class="flex flex-col space-y-5 max-w-2xl text-center items-center rounded-lg bg-opacity-75 bg-red-200 py-5 px-3"
                    >
                        <button class="normal-link">
                            Empty these from the trash
                        </button>
                        <p
                            class="text-gray-700 text-sm leading-5 tracking-wide"
                        >
                            The items below will be deleted in 25 days, or when
                            you empty the trash, whichever comes first. Their
                            data will remain on the internal system and backups
                            for up to 30 days before they are completely
                            destroyed.
                        </p>
                    </div>
                    <div
                        v-if="!groupedBuckets.createdByAuthUser"
                        class="flex flex-col space-y-5 max-w-2xl text-center items-center rounded-lg bg-opacity-75 bg-orange-200 py-5 px-3"
                    >
                        <p
                            class="text-gray-700 text-sm leading-5 tracking-wide"
                        >
                            You can restore these items but you can't empty them
                            from the trash.
                            <inertia-link href="#" class="normal-link"
                                >Contact an administrator</inertia-link
                            >
                            to do that.
                        </p>
                    </div>
                </div>

                <div class="flex justify-center">
                    <div
                        class="grid grid-flow-row grid-cols-2 sm:grid-cols-3 gap-4 mt-8 sm:px-10"
                    >
                        <template v-for="bucket in groupedBuckets.buckets">
                            <component
                                :key="`${bucket.modelName}.${bucket.id}`"
                                :data="bucket"
                                :is="
                                    Object.values(
                                        previewCardsComponents.find(
                                            comp =>
                                                Object.keys(comp)[0] ===
                                                `${bucket.modelName}.${bucket.id}`
                                        )
                                    )[0]
                                "
                            />
                        </template>
                    </div>
                </div>
            </div>

            <div class="mt-10 md:px-10 flex flex-col space-y-4"></div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import { groupBy, chain } from "lodash";

export default {
    components: {
        DoubleWhiteLayout
    },
    props: ["account", "project", "buckets"],
    created() {
        this.previewCardsComponents = this.$props.buckets.map(bucket => {
            return {
                [`${bucket.modelName}.${bucket.id}`]: () =>
                    import(
                        `@/Shared/Partials/PreviewCards/${bucket.modelName}PreviewCard.vue`
                    )
            };
        });

        console.log(this.bucketsGroupedByUser);
    },
    computed: {
        bucketsGroupedByUser() {
            return chain(this.buckets)
                .groupBy(bucket => bucket.user.id === this.$page.auth.user.id)
                .map((value, key) => ({
                    createdByAuthUser: key,
                    buckets: value
                }))
                .value();
        }
    },
    data() {
        return {
            previewCardsComponents: []
        };
    }
};
</script>

<style></style>
