<template>
    <div class="bg-orange-100 rounded-lg p-5 flex-grow">
        <form
            :action="action"
            method="post"
            ref="formElement"
            enctype="multipart/form-data"
            @submit.prevent="submit"
        >
            <input
                type="hidden"
                name="_method"
                v-if="mode == 'edit'"
                value="PUT"
            />
            <input type="hidden" name="_token" :value="csrf" />
            <input type="hidden" name="model" :value="model" />
            <input type="hidden" name="modelId" :value="modelId" />

            <input
                type="text"
                placeholder="Add comment or upload files..."
                @click="showTrix"
                v-if="!isTrixShown"
                class="w-full p-3 border border-gray-400 rounded placeholder-gray-700 cursor-pointer"
            />
            <div class="bg-white" v-if="isTrixShown" v-html="trix"></div>

            <div v-if="isTrixShown" class="flex items-center space-x-2 mt-5">
                <button
                    class="rounded-full  p-3 bg-gray-700 text-gray-200 text-sm"
                    type="submit"
                >
                    Save this comment
                </button>
                <button
                    class="rounded-full p-3 bg-white border border-gray-700 font-semibold text-sm"
                    @click="closeEditor"
                >
                    Never mind
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/Components/LoadingButton";
export default {
    props: ["trix", "model", "modelId", "mode", "comment"],
    components: {
        LoadingButton
    },

    mounted() {
        if (!this.csrf) {
            location.reload();
        }

        if (this.mode === "edit") {
            this.showTrix();
            this.$nextTick(() => {
                const trix = document.querySelector("trix-editor");
                trix.innerHTML = this.comment.trixRichText;
            });
            this.action = route("comments.update", {
                account: this.$page.account.id,
                project: this.$page.project.id,
                comment: this.comment.id
            });
        }
    },

    data() {
        return {
            isTrixShown: false,
            csrf: window.csrf,
            action: route("comments.store", {
                account: this.$page.account.id,
                project: this.$page.project.id
            })
        };
    },
    methods: {
        showTrix() {
            this.isTrixShown = true;

            return this.$nextTick(() => {
                const trix = document.getElementById("container-trix-input");
                trix.classList.add("overflow-hidden");
                return trix;
            });
        },

        closeEditor() {
            this.isTrixShown = false;
            this.$emit("editorClosed");
        },

        submit() {
            this.showTrix();

            this.$nextTick(() => {
                const input = document.querySelector("trix-editor");
                if (!input.value) {
                    input.focus();
                } else {
                    this.$refs.formElement.submit();
                }
            });
        }
    }
};
</script>

<style></style>
