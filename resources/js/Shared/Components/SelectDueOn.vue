<template>
    <div>
        <input
            type="text"
            placeholder="Select a date..."
            @click="showForm = true"
            v-if="!showForm"
            class="flex-grow placeholder-gray-800 px-2 cursor-pointer"
        />
        <div v-if="showForm" class="flex flex-col space-y-4">
            <label class="flex items-center space-x-2" for="noDueDate">
                <input
                    value="noDueDate"
                    name="dueOnOption"
                    v-model="dueOnOption"
                    type="radio"
                    class="form-radio text-gray-700 h-5 w-5"
                    id="noDueDate"
                    @change="updateDateField"
                />
                <span>No due date</span>
            </label>
            <label class="flex items-center space-x-2" for="specificDay">
                <input
                    value="specificDay"
                    name="dueOnOption"
                    v-model="dueOnOption"
                    type="radio"
                    class="form-radio text-gray-700 h-5 w-5"
                    id="specificDay"
                    @change="updateDateField"
                />
                <span v-if="!showDate">A specific day</span>
                <date-picker
                    v-if="showDate"
                    v-model="dueOn"
                    format="ddd, MMM D, YYYY"
                    value-type="YYYY-MM-DD"
                    placeholder="Pick a date..."
                ></date-picker>
            </label>
            <label class="flex items-center space-x-2" for="range">
                <input
                    value="range"
                    name="dueOnOption"
                    v-model="dueOnOption"
                    type="radio"
                    class="form-radio text-gray-700 h-5 w-5"
                    id="range"
                    @change="updateDateField"
                />
                <span v-if="!showRange">Runs for multiple days</span>
                <date-picker
                    placeholder="Start date to End date"
                    v-if="showRange"
                    v-model="dueOn"
                    value-type="YYYY-MM-DD"
                    range-separator=" / "
                    format="ddd, MMM D, YYYY"
                    range
                ></date-picker>
            </label>
        </div>
    </div>
</template>

<script>
import "vue2-datepicker/index.css";

export default {
    props: ["dates"],
    components: {
        DatePicker: () => import("vue2-datepicker")
    },
    data() {
        return {
            dueOnOption: "",
            showRange: false,
            showDate: false,
            dueOn: null,
            showForm: false
        };
    },
    watch: {
        dueOn(value) {
            this.$emit("input", value);
        },
        dueOnOption(value) {
            if (value == "noDueDate") {
                this.$emit("input", null);
            }
        }
    },
    created() {
        if (this.dates) {
            if (this.dates.every(date => date == null)) {
                this.dueOnOption = "noDueDate";
                this.dueOn = null;
                this.showForm = false;
            } else if (this.dates[0] == null) {
                this.dueOnOption = "specificDay";
                this.showDate = true;
                this.dueOn = this.dates[1];
                this.showForm = true;
            } else {
                this.dueOnOption = "range";
                this.showRange = true;
                this.dueOn = this.dates;
                this.showForm = true;
            }
        }
    },
    methods: {
        updateDateField() {
            switch (this.dueOnOption) {
                case "specificDay":
                    this.showRange = false;
                    this.showDate = true;
                    break;
                case "range":
                    this.showDate = false;
                    this.showRange = true;
                    break;
                default:
                    this.showRange = false;
                    this.showDate = false;
                    break;
            }

            this.dueOn = null;
        }
    }
};
</script>

<style></style>
