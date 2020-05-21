<template>
    <form
        :action="action"
        method="post"
        ref="formElement"
        enctype="multipart/form-data"
        @submit.prevent="submit"
        class="flex flex-col flex-grow border border-gray-400 px-5 py-2"
    >
        <input type="hidden" name="_method" v-if="mode == 'edit'" value="PUT" />
        <input type="hidden" name="_token" :value="csrf" />
        <input
            type="text"
            name="name"
            v-model="name"
            ref="name"
            class="appearance-none placeholder-gray-600 font-bold text-lg border-none p-2"
            placeholder="Name this list..."
        />
        <div
            class="mx-1 mt-1 font-semibold transition transition-all duration-100 ease-in-out text-red-600"
        >
            {{ validation.firstError("name") }}
        </div>
        <input
            type="text"
            readonly
            placeholder="Add extra details or attach a file..."
            @click="showTrix"
            v-if="!isTrixShown"
            class="w-full p-3 mt-5 placeholder-gray-700 cursor-pointer"
        />
        <div class="bg-white" v-if="isTrixShown" v-html="trix"></div>

        <div class="flex items-center space-x-2 mt-5">
            <button
                class="rounded-full p-3 bg-green-500 text-gray-100 text-sm"
                type="submit"
            >
                Save this list
            </button>
            <button
                class="rounded-full p-3 text-green-500 bg-white border border-green-500 font-semibold text-sm"
                @click="close"
            >
                Never mind
            </button>
        </div>
    </form>
</template>

<script>
import SimpleVueValidator from "simple-vue-validator";
const Validator = SimpleVueValidator.Validator;
export default {
    mixins: [SimpleVueValidator.mixin],
    props: ["trix", "mode", "todoList"],

    mounted() {
        if (!this.csrf) {
            location.reload();
        }

        if (this.mode === "edit") {
            this.showTrix();
            this.$nextTick(() => {
                const trix = document.querySelector("trix-editor");
                trix.innerHTML = this.todoList.trixRichText;
                this.name = this.todoList.name;
            });
            this.action = route("todoLists.update", {
                account: this.$page.account.id,
                project: this.$page.project.id,
                todoList: this.todoList.id
            });
        }
    },
    data() {
        return {
            isTrixShown: false,
            csrf: window.csrf,
            name: "",
            action: route("todoLists.store", {
                account: this.$page.account.id,
                project: this.$page.project.id
            })
        };
    },
    validators: {
        name: function(value) {
            return Validator.value(value).required("You have to name it.");
        }
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

        close() {
            this.isTrixShown = false;
            this.$emit("closed");
        },

        submit() {
            this.$validate().then(success => {
                if (success) {
                    this.$refs.formElement.submit();
                }
            });
        }
    }
};
</script>

<style></style>
