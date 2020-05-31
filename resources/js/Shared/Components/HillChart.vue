<template>
    <svg :class="targetClass" />
</template>

<script>
import HillChart from "hill-chart";
import "hill-chart/dist/styles.css";

export default {
    model: {
        prop: "data",
        event: "moved"
    },
    props: {
        height: {
            type: Number,
            default: 300
        },
        width: {
            type: Number,
            default: 900
        },
        preview: {
            type: Boolean,
            default: false
        },
        footerText: {
            type: Object,
            default: () => ({
                show: true,
                fontSize: 0.75
            })
        },
        data: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            targetClass: null,
            initData: this.data
        };
    },
    created() {
        this.targetClass = this.generateClassName();
        this.setIdField();
    },
    mounted() {
        const config = {
            target: `.${this.targetClass}`,
            height: this.height,
            width: this.width,
            preview: this.preview,
            footerText: this.footerText
        };
        const hill = new HillChart(this.initData, config);
        hill.render();
        hill.on("moved", data => this.handleMovedEvent(data));
        hill.on("pointClick", pointData => this.$emit("pointClick", pointData));
        hill.on("move", (x, y) => this.$emit("move", x, y));
        hill.on("home", pointData => this.$emit("home", pointData));
        hill.on("end", pointData => this.$emit("end", pointData));
    },
    methods: {
        setIdField() {
            this.initData = this.initData.map(point => {
                if (!point.id) {
                    const id = Math.random()
                        .toString(36)
                        .slice(-6);
                    return { ...point, id };
                }
                return point;
            });
        },
        generateClassName() {
            return `hill-chart-${this.uid}`;
        },
        handleMovedEvent(data) {
            this.initData = this.initData.map(point => {
                return point.id === data.id
                    ? Object.assign({}, point, data)
                    : point;
            });
            this.$emit("moved", this.initData);
        }
    }
};
</script>

<style></style>
