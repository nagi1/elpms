<template>
    <div class=" relative border border-gray-400 rounded ">
        <corner-options-menu top="mt-2">
            <corner-option-item
                @click.native="editNotes = true"
                :item="{
                    type: 'a',
                    iconPath:
                        'M17,18L12,15.82L7,18V5H17M17,3H7A2,2 0 0,0 5,5V21L12,18L19,21V5C19,3.89 18.1,3 17,3Z',
                    text: update.notes ? 'Edit notes' : 'Add notes'
                }"
            />
            <corner-option-item
                @click.native="remove"
                :item="{
                    type: 'a',
                    iconPath:
                        'M17,18L12,15.82L7,18V5H17M17,3H7A2,2 0 0,0 5,5V21L12,18L19,21V5C19,3.89 18.1,3 17,3Z',
                    text: 'Delete'
                }"
            />
        </corner-options-menu>
        <div class="flex items-center p-2 space-x-2">
            <avatar-modal size="sm" :user="update.user" />
            <div class="flex flex-col space-y-1">
                <span class="font-semibold">{{ update.user.name }}</span>
                <span class="text-sm">{{ update.createdAt }}</span>
            </div>
        </div>

        <div class="w-full relative">
            <resize-observer @notify="handleResize" />
            <hill-chart
                :width="width"
                :height="height"
                :preview="true"
                :key="index"
                :data="update.data"
            />
        </div>

        <div
            v-if="!editNotes"
            class="border-t border-gray-400 px-3 py-5 bg-red-100 flex flex-col space-y-3"
        >
            <div v-if="update.notes" class="mx-3 mt-3">
                {{ update.notes }}
            </div>
            <div class="flex space-x-3 items-center">
                <inertia-link
                    v-if="!show"
                    :href="
                        route('hillChartsUpdates.show', {
                            account: $page.account.id,
                            project: $page.project.id,
                            hillChartUpdate: update.id
                        })
                    "
                    class="rounded-full text-sm border-green-500 border-2 p-2 text-green-500 bg-white"
                >
                    Discuss
                </inertia-link>
                <boosts
                    :boosts="update.boosts"
                    model="HillChartUpdate"
                    :modelId="update.id"
                />
            </div>
        </div>

        <div class="border-t border-gray-400 px-3 py-5 bg-red-100" v-else>
            <textarea
                v-model="notes"
                class="placeholder-gray-700 w-full border border-gray-400 p-2"
                placeholder="Add extra details about your changes..."
                rows="3"
            ></textarea>
            <div class="flex items-center space-x-2">
                <button
                    @click="submit"
                    class="mt-3 flex text-center justify-center items-center border border-green-500 hover:bg-gray-200 text-green-500 shadow rounded-full bg-white py-2 px-3"
                >
                    Save this note
                </button>
                <button
                    @click="editNotes = false"
                    class="mt-3 flex text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
                >
                    <span class="text-sm">Never mind</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import "vue-resize/dist/vue-resize.css";
import { ResizeObserver } from "vue-resize";

export default {
    props: { update: { required: true }, show: { default: false } },
    components: {
        ResizeObserver,
        hillChart: () => import("@/Shared/Components/HillChart"),
        Boosts: () => import("@/Shared/Partials/Boosts/Boosts"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem"),
        CornerOptionsMenu: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionsMenu")
    },
    watch: {
        width(value) {
            this.index++;
        }
    },
    data() {
        return {
            width: 600,
            height: 250,
            index: 0,
            editNotes: false,
            notes: this.update.notes
        };
    },
    methods: {
        handleResize({ width, height }) {
            this.width = width;
            this.index++;
        },
        remove() {
            if (confirm("Are you sure you want to delete that update?")) {
                this.$inertia.delete(
                    route("hillChartsUpdates.delete", {
                        account: this.$page.account.id,
                        project: this.$page.project.id,
                        hillChartUpdate: this.update.id
                    })
                );
            }
        },
        submit() {
            this.$inertia.put(
                route("hillChartsUpdates.update", {
                    account: this.$page.account.id,
                    project: this.$page.project.id,
                    hillChartUpdate: this.update.id
                }),
                {
                    notes: this.notes
                },
                {
                    preserveState: false,
                    replace: true
                }
            );
        }
    }
};
</script>

<style></style>
