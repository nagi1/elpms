<template>
    <form
        :action="action"
        method="post"
        ref="formElement"
        enctype="multipart/form-data"
        @submit.prevent="submit"
        class="flex flex-col flex-grow border rounded border-gray-300 px-5 py-3"
    >
        <input type="hidden" name="_method" v-if="mode == 'edit'" value="PUT" />
        <input type="hidden" name="_token" :value="csrf" />

        <div class="flex items-end space-x-3 pb-3 border-b border-gray-300">
            <input
                type="checkbox"
                disabled
                class="form-checkbox h-6 w-6 border-gray-500"
            />
            <input
                type="text"
                name="description"
                v-model="description"
                ref="description"
                class="appearance-none placeholder-gray-600 font-semibold text-sm border-none p-1"
                placeholder="Describe this to-do..."
            />
            <span
                class="self-center font-semibold transition transition-all duration-200 ease-in-out text-red-600"
            >
                {{ validation.firstError("description") }}
            </span>
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="assignedTo" class="flex items-center  space-x-3">
                <span class=" w-40 text-left  sm:text-right">Assigned to</span>
                <dropdown
                    multiple
                    :options="projectUsers"
                    placeholder="Type names to assign..."
                    search
                    selection
                    noResultsMessage="No more Users"
                    v-model="assignedTo"
                    style="border: none;"
                    class="flex-grow border-none border-0"
                    id="assignedTo"
                />
            </label>
            <input type="hidden" :value="assignedTo" name="assignedTo" />
            <label
                v-if="assignedTo.length"
                class="block mt-2 text-center space-x-1"
                for="notifyAssignedUsers"
            >
                <input
                    type="checkbox"
                    id="notifyAssignedUsers"
                    v-model="notifyAssignedUsers"
                    :value="notifyAssignedUsers"
                    name="notifyAssignedUsers"
                    class="form-checkbox  align-center h-5 w-5 text-green-500 border-gray-600"
                />
                <span>Notify them about this assignment</span>
            </label>
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="notify" class="flex items-center  space-x-3">
                <span class=" w-40 text-left  sm:text-right "
                    >When done, notify</span
                >
                <dropdown
                    multiple
                    :options="projectUsers"
                    placeholder="Type names to notify..."
                    search
                    selection
                    noResultsMessage="No more Users"
                    v-model="notify"
                    class="flex-grow border-none"
                    id="notify"
                    style="border: none;"
                />
            </label>
            <input type="hidden" :value="notify" name="notify" />
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <div for="dueOn" class="flex items-start space-x-3">
                <span class="w-40 text-left sm:text-right">Due on</span>
                <select-due-on :dates="dueOn" @input="setDueOn" />
            </div>
            <input type="hidden" :value="dueOn" name="dueOn" />
        </div>

        <div class="mt-5">
            <div class="flex items-start space-x-3">
                <span class="w-40 text-left sm:text-right ">Notes</span>
                <input
                    type="text"
                    placeholder="Add extra details or attach a file..."
                    @click="showTrix"
                    v-if="!isTrixShown"
                    class="flex-grow px-2 placeholder-gray-700 cursor-pointer"
                />
                <div class="bg-white" v-if="isTrixShown" v-html="trix"></div>
            </div>
        </div>

        <div class="flex items-center space-x-2 mt-5">
            <button
                class="rounded-full p-3 bg-green-500 text-gray-100 text-sm"
                type="submit"
            >
                {{ mode === "edit" ? "Save" : "Add" }} this to-do
            </button>
            <button
                class="rounded-full p-3 text-green-500 bg-white border border-green-500 font-semibold text-sm"
                @click.prevent="close"
            >
                Never mind
            </button>
        </div>
    </form>
</template>

<script>
import { Dropdown } from "semantic-ui-vue";

import "semantic-ui-css/components/dropdown.min.css";
import "semantic-ui-css/components/icon.min.css";
import "semantic-ui-css/components/image.min.css";
import "semantic-ui-css/components/list.min.css";
import "semantic-ui-css/components/input.min.css";
import "semantic-ui-css/components/label.min.css";
import "semantic-ui-css/components/transition.min.css";

import SimpleVueValidator from "simple-vue-validator";
const Validator = SimpleVueValidator.Validator;
export default {
    components: {
        Dropdown,
        SelectDueOn: () => import("@/Shared/Components/SelectDueOn")
    },
    mixins: [SimpleVueValidator.mixin],
    props: ["trix", "mode", "todoItem", "todoList", "users"],

    mounted() {
        if (!this.csrf) {
            this.$inertia.reload();
        }

        if (this.mode === "edit") {
            this.showTrix();
            this.$nextTick(() => {
                const trix = document.querySelector("trix-editor");
                trix.innerHTML = this.todoItem.trixRichText;
                this.description = this.todoItem.description;
                this.assignedTo = this.todoItem.assignedTo.map(user => user.id);
                this.notify = this.todoItem.whenDoneNotify.map(user => user.id);
                this.dueOn = [
                    this.todoItem.startsAtDate,
                    this.todoItem.endsAtDate
                ];
            });
            this.action = route("todoItems.update", {
                account: this.$page.account.id,
                project: this.$page.project.id,
                todoList: this.todoList.id,
                todoItem: this.todoItem.id
            });
        }
    },
    data() {
        return {
            assignedTo: [],
            notify: [],
            dueOn: null,
            notifyAssignedUsers: false,
            isTrixShown: false,
            csrf: window.csrf,
            description: "",
            action: route("todoItems.store", {
                account: this.$page.account.id,
                project: this.$page.project.id,
                todoList: this.todoList.id
            })
        };
    },
    computed: {
        projectUsers() {
            return this.users.map(user => ({
                key: user.id,
                text: user.name,
                value: user.id,
                image: { avatar: true, src: user.avatar64 }
            }));
        }
    },

    validators: {
        description: function(value) {
            return Validator.value(value).required(
                "Provide short description."
            );
        }
    },
    methods: {
        prepareUsers(users) {
            const userIds = this.users.map(user => user.id);
            this.assignedTo = userIds.filter(id =>
                this.assignedTo.includes(id)
            );
            this.notify = userIds.filter(id => this.notify.includes(id));
        },
        showTrix() {
            this.isTrixShown = true;

            return this.$nextTick(() => {
                const trix = document.getElementById("container-trix-input");
                trix.classList.add("overflow-hidden");
                return trix;
            });
        },

        setDueOn(date) {
            this.dueOn = date;
        },

        close() {
            this.isTrixShown = false;
            this.$emit("closed");
        },

        submit() {
            this.prepareUsers();
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
