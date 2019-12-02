<template>
<div>


</div>
</template>

<script>
    import Line from 'vue-chartjs'
    export default {
        name: "statistics",
        extends: Line,
        data(){
            return{
            chartdata:{
                columns:[],
                rows:[],
                }
            }
        },
        mounted() {
            this.renderChart(this.chartdata, this.options)

        },

    }

</script>

<style scoped>

</style>
