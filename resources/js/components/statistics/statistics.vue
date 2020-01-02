<template>
    <div>
        <div>
            <label for="Date">Date (yyyy-mm-dd,yyyy-mm-dd)</label>
            <input class="form-control" type="text" v-model="data.dates">
        </div>
        <a @click.prevent="getTotalMovsFromGivenMonth(data.dates)" class="btn btn-info"></a>
        <line-chart v-if="this.show===true" :chartdata="linedata" :options="options" ></line-chart>
    </div>
</template>

<script>
    import lineChart from "./lineChart.vue";
    export default {
        components:{
            lineChart,
           
        },
        name: "statistics",
        data() {
            return {
                show: false,
                linedata:{
                    labels:[],
                    datasets:[]
                },
                options:{
                    responsive: true,
                    maintainAspectRation: false,
                },
                data: {
                    dates: ""
                },
            }
        },
        methods: {
            getIncomesByMonth(month){
//just for testing
                axios.get('api/movements/1/filter/?wallet_id='+
                    this.$store.state.user.id+'&date1=1-10-2019&date2=30-10-2019')
                    .then(response => {
                        console.log(response);
                        for (let i=1; i<=31;i++)
                        {
                            this.linedata.labels.push(i);
                        }
                        console.log(response.data.data);

                        let data1=[];
                        for (let i=1; i<=31;i++)
                        {
                           data1.push(i+10);
                        }

                        this.linedata.datasets.push({fill:false,label:'month',data: data1})

                        this.show=true;
                    })
            },
            getTotalMovsFromGivenMonth(dates) {
            axios.get('/api/movements/totalMovements/' + dates)
            .then(response => {
                console.log(response.data);
                this.linedata.labels = ['date', 'Total Movs'];
                this.linedata.datasets = response.data.data;
                this.show=true;

            })
        },
        }

    }
</script>

<style scoped>

</style>
