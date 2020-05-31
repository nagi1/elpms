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
        <input type="hidden" name="color" :value="color" />

        <div class="flex items-end space-x-3 pb-3 border-b border-gray-300">
            <color-picker
                shapes="circles"
                class="rounded-full border border-gray-500"
                :swatches="[
                    '#cccccc',
                    '#faf785',
                    '#fff0db',
                    '#ffe5e5',
                    '#ffe4f7',
                    '#f2edff',
                    '#e4f8e2',
                    '#eee2d7',
                    '#f2f2f2'
                ]"
                v-model="color"
                popover-x="right"
            />
            <input
                type="text"
                name="name"
                v-model="name"
                ref="name"
                class="appearance-none placeholder-gray-600 tracking-wide border-none p-1 flex-grow font-medium"
                placeholder="Type the name of the event ..."
            />
            <span
                class="self-center font-semibold transition transition-all duration-200 ease-in-out text-red-600"
            >
                {{ validation.firstError("name") }}
            </span>
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="allDay" class="flex items-center space-x-3">
                <span class="w-16">All day?</span>
                <input
                    v-model="allDay"
                    id="allDay"
                    type="checkbox"
                    class="form-checkbox border-gray-500 text-blue-600 h-6 w-6"
                />
            </label>
            <input type="hidden" :value="allDay" name="allDay" />
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="startsAt" class="flex items-center space-x-3">
                <span class="w-16">Starts at</span>
                <div
                    class="flex flex-col space-y-3 sm:space-x-2 sm:space-y-0 sm:flex-row"
                >
                    <date-picker
                        v-model="startsAtDate"
                        format="ddd, MMM D, YYYY"
                        type="date"
                        id="startsAt"
                        value-type="YYYY-MM-DD"
                        placeholder="Pick a date..."
                    ></date-picker>
                    <date-picker
                        v-if="!allDay"
                        v-model="startsAtTime"
                        format="hh:mm a"
                        type="time"
                        value-type="HH:mm:ss"
                        :use12h="true"
                        placeholder="Pick a time..."
                    ></date-picker>
                </div>
            </label>
            <input type="hidden" :value="startsAtDate" name="startsAtDate" />
            <input type="hidden" :value="startsAtTime" name="startsAtTime" />
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="endsAt" class="flex items-center space-x-3">
                <span class="w-16">Ends at</span>
                <div
                    class="flex flex-col space-y-3 sm:space-x-2 sm:space-y-0 sm:flex-row"
                >
                    <date-picker
                        v-model="endsAtDate"
                        format="ddd, MMM D, YYYY"
                        type="date"
                        id="endsAt"
                        value-type="YYYY-MM-DD"
                        :disabled-date="notBeforeStartDate"
                        placeholder="Pick a date..."
                    ></date-picker>
                    <date-picker
                        v-if="!allDay"
                        v-model="endsAtTime"
                        format="hh:mm a"
                        type="time"
                        value-type="HH:mm:ss"
                        :use12h="true"
                        placeholder="Pick a time..."
                    ></date-picker>
                </div>
            </label>
            <input type="hidden" :value="endsAtDate" name="endsAtDate" />
            <input type="hidden" :value="endsAtTime" name="endsAtTime" />
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="repeat" class="flex items-center space-x-3">
                <span class="w-16">Repeat</span>
                <div class="flex flex-col space-y-2">
                    <select
                        name="repeat"
                        id="repeat"
                        v-model="repeat"
                        class="form-select rounded-full"
                    >
                        <option value="no">Don't repeat</option>
                        <option value="DAILY">Every day</option>
                        <option value="otherDay">Every other day</option>
                        <option value="WEEKLY">Every week</option>
                        <option value="otherWeek">Every other week</option>
                        <option value="weekend">Every weekend</option>
                        <option value="weekday">Every weekday(Mon-Fri)</option>
                        <option value="MONTHLY">Every month</option>
                        <option value="YEARLY">Every year</option>
                    </select>

                    <div
                        v-if="repeat !== 'no'"
                        class="flex flex-col space-y-2 bg-red-100 p-3"
                    >
                        <label
                            for="forever"
                            class="flex items-center space-x-1"
                        >
                            <span>Forever</span>
                            <input
                                value="forever"
                                id="forever"
                                type="radio"
                                v-model="repeatPeriod"
                                name="repeatPeriod"
                            />
                        </label>
                        <label for="until" class="flex items-center space-x-1">
                            <span>Until</span>
                            <input
                                type="radio"
                                id="until"
                                value="until"
                                v-model="repeatPeriod"
                                name="repeatPeriod"
                            />
                            <date-picker
                                v-model="repeatUntil"
                                format="ddd, MMM D, YYYY"
                                :disabled="repeatPeriod === 'forever'"
                                :disabled-date="notBeforeToday"
                                type="date"
                                value-type="YYYY-MM-DD"
                                placeholder="Pick a date..."
                            ></date-picker>
                        </label>
                    </div>
                </div>
            </label>
            <input type="hidden" :value="repeatUntil" name="repeatUntil" />
        </div>

        <div class="mt-5 pb-3 border-b border-gray-300">
            <label for="assignedTo" class="flex items-center space-x-3">
                <span class="w-16">With</span>
                <dropdown
                    multiple
                    :options="projectUsers"
                    placeholder="Type names ..."
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
        </div>

        <div class="mt-5">
            <div class="flex flex-col space-y-5">
                <label for="notes" class="w-16">Notes</label>
                <input
                    type="text"
                    id="notes"
                    placeholder="Add extra details or attach a file..."
                    @click.prevent="showTrix"
                    @focus="showTrix"
                    v-if="!isTrixShown"
                    class="flex-grow px-2 placeholder-gray-700 cursor-pointer"
                />
                <div class="bg-white" v-if="isTrixShown" v-html="trix"></div>
            </div>
        </div>

        <div class="mt-10">
            <div class="flex flex-col space-y-3">
                <label class="flex items-center space-x-2" for="dontNotify">
                    <input
                        type="radio"
                        id="dontNotify"
                        name="notifyUsers"
                        :value="false"
                        v-model="notifyUsers"
                        class="form-radio border-gray-500 text-blue-600 h-5 w-5"
                    />
                    <span>When I post this, don’t notify anyone.</span>
                </label>
                <label class="flex items-center space-x-2" for="notifyUsers">
                    <input
                        @click="openNotifyUsersModal"
                        @focus="openNotifyUsersModal"
                        type="radio"
                        id="notifyUsers"
                        name="notifyUsers"
                        :value="true"
                        v-model="notifyUsers"
                        class="form-radio border-gray-500 text-blue-600 h-5 w-5"
                    />
                    <span>Let me choose who to notify…</span>
                </label>
                <input
                    type="hidden"
                    name="notifiedUsers"
                    :value="notifiedUsers"
                />
            </div>
        </div>

        <div class="flex items-center space-x-2 mt-5">
            <button
                class="rounded-full p-3 bg-green-500 text-gray-100 text-sm"
                type="submit"
            >
                {{ mode === "edit" ? "Save" : "Post" }} this event
            </button>
            <button
                class="rounded-full p-3 text-green-500 bg-white border border-green-500 font-semibold text-sm"
                @click.prevent="close"
            >
                Never mind
            </button>
        </div>

        <select-notified-users-modal
            :users="project.subscribers"
            :open="showNotifyUsersModal"
            @close="closeNotifyUsersModal"
            @input="select"
        />
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
import "vue2-datepicker/index.css";

import "vue-swatches/dist/vue-swatches.css";
import SimpleVueValidator from "simple-vue-validator";
import timeSolver from "timesolver/timeSolver.min.js";
const Validator = SimpleVueValidator.Validator;
export default {
    components: {
        DatePicker: () => import("vue2-datepicker"),
        ColorPicker: () => import("vue-swatches"),
        SelectNotifiedUsersModal: () =>
            import("@/Shared/Components/SelectNotifiedUsersModal"),

        Dropdown
    },
    mixins: [SimpleVueValidator.mixin],
    props: ["trix", "mode", "event", "project", "initialDate"],
    watch: {
        startsAtDate(date) {
            if (timeSolver.after(date, this.endsAtDate)) {
                this.endsAtDate = timeSolver.getString(
                    timeSolver.add(date, 1, "d"),
                    "YYYY-MM-DD"
                );
                this.endsAtTime = timeSolver.getString(
                    timeSolver.add(date, 1, "min"),
                    "HH:mm:ss"
                );
            }
        },

        startsAtTime(time) {
            if (this.validDate()) {
                if (!this.validTime()) {
                    this.endsAtTime = timeSolver.getString(
                        timeSolver.add(
                            new Date(`${this.endsAtDate} ${time}`),
                            1,
                            "min"
                        ),
                        "HH:mm:ss"
                    );
                }
            }
        },

        endsAtDate(date) {
            if (timeSolver.before(date, this.startsAtDate)) {
                this.endsAtDate = timeSolver.getString(
                    timeSolver.add(this.startsAtDate, 1, "d"),
                    "YYYY-MM-DD"
                );
                this.endsAtTime = timeSolver.getString(
                    timeSolver.add(this.startsAtDate, 1, "min"),
                    "HH:mm:ss"
                );
            }
        },

        endsAtTime(time) {
            if (this.validDate()) {
                if (!this.validTime()) {
                    this.endsAtTime = timeSolver.getString(
                        timeSolver.add(
                            new Date(
                                `${this.startsAtDate} ${this.startsAtTime}`
                            ),
                            1,
                            "min"
                        ),
                        "HH:mm:ss"
                    );
                }
            }
        },
        repeatPeriod(value) {
            if (value === "forever") {
                this.repeatUntil = null;
            } else {
                this.repeatUntil = timeSolver.getString(
                    new Date(),
                    "YYYY-MM-DD"
                );
            }
        }
    },
    mounted() {
        if (!this.csrf) {
            this.$inertia.reload();
        }

        if (this.mode === "edit") {
            this.showTrix();
            this.$nextTick(() => {
                const trix = document.querySelector("trix-editor");
                trix.innerHTML = this.event.trixRichText;
                this.name = this.event.name;
                this.assignedTo = this.event.assignedTo.map(user => user.id);
            });
            this.action = route("events.update", {
                account: this.$page.account.id,
                project: this.$page.project.id,
                event: this.event.id
            });
        }

        if (this.initialDate) {
            const date = timeSolver.getString(
                Symbol.for(new Date(this.initialDate)) ===
                    Symbol.for("Invalid Date")
                    ? new Date(
                          `${this.initialDate} ${new Date().getFullYear()}`
                      )
                    : new Date(this.initialDate),
                "YYYY-MM-DD"
            );
            this.startsAtDate = date;
            this.endsAtDate = date;
        }
    },
    data() {
        return {
            showNotifyUsersModal: false,
            color: "#f2edff",
            notifyUsers: false,
            notifiedUsers: [],
            allDay: false,
            repeat: "no",
            startsAtDate: timeSolver.getString(new Date(), "YYYY-MM-DD"),
            startsAtTime: timeSolver.getString(new Date(), "HH:mm:ss"),
            endsAtDate: timeSolver.getString(new Date(), "YYYY-MM-DD"),
            endsAtTime: timeSolver.getString(new Date(), "HH:mm:ss"),
            repeatPeriod: "forever",
            repeatUntil: null,
            assignedTo: [],
            isTrixShown: false,
            csrf: window.csrf,
            name: "",
            action: route("events.store", {
                account: this.$page.account.id,
                project: this.$page.project.id
            })
        };
    },
    computed: {
        projectUsers() {
            return this.project.users.map(user => ({
                key: user.id,
                text: user.name,
                value: user.id,
                image: { avatar: true, src: user.avatar64 }
            }));
        }
    },

    validators: {
        name: function(value) {
            return Validator.value(value).required("Provide name.");
        }
    },
    methods: {
        select(value) {
            this.notifiedUsers = value;
        },
        openNotifyUsersModal() {
            this.showNotifyUsersModal = true;
            this.notifyUsers = true;
        },
        closeNotifyUsersModal() {
            this.showNotifyUsersModal = false;
            if (this.notifiedUsers.length === 0) {
                this.notifyUsers = false;
            }
        },
        validDate() {
            return (
                timeSolver.before(this.startsAtDate, this.endsAtDate) ||
                timeSolver.equal(this.startsAtDate, this.endsAtDate)
            );
        },
        validTime() {
            return timeSolver.before(
                new Date(`${this.startsAtDate} ${this.startsAtTime}`),
                new Date(`${this.endsAtDate} ${this.endsAtTime}`)
            );
        },
        notBeforeToday(date) {
            return date < timeSolver.subtract(new Date(), 1, "d");
        },
        notBeforeStartDate(date) {
            return timeSolver.before(
                date,
                timeSolver.subtract(this.startsAtDate, 1, "d")
            );
        },

        prepareUsers(users) {
            const userIds = this.project.users.map(user => user.id);
            this.assignedTo = userIds.filter(id =>
                this.assignedTo.includes(id)
            );
            // this.notify = userIds.filter(id => this.notify.includes(id));
        },
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
