<template>
    <div>
        <div>
            <label>Date (yyyy-mm-dd,yyyy-mm-dd)</label>
            <input class="form-control" type="text" v-model="data.dates" >
        </div>
        <a @click.prevent="getTotalMovsBetweenDates(data.dates)" class="btn btn-info"/>
        <div id="chart">

        <line-chart ref="canvas"  v-if="this.show===true" :chartdata="linedata" :options="options" ></line-chart>
        </div>
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
                    maintainAspectRatio:false,

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
            getTotalMovsBetweenDates(dates) {
                if(this.show==true){
                    this.show=false;
                }
            axios.get('/api/movements/totalMovements/' + dates)
            .then(response => {
<<<<<<< HEAD
                this.linedata.labels=[];
                this.linedata.datasets=[];
                let data=[];
                let dates=[];

                for(let i=0;i<response.data.length;i++){
                    data.push(response.data[i].total_movements);
                }

                for(let i=0;i<response.data.length;i++){
                    dates.push(response.data[i].date);
                }

               this.linedata.labels=dates;
                this.linedata.datasets.push({
                    label: 'Total movements',
                    data:data
                });

                console.log(this.linedata);
=======
                console.log(response.data);
                this.linedata.labels = ['date', 'Total Movs'];
                this.linedata.datasets = response.data.data;
>>>>>>> 65b33bfffe6215bb9f7d95cd5bbe7eae0038bdc0
                this.show=true;

            })
        },
        },



    }
</script>

<style scoped>
#chart {
    max-width: 1000px;
    max-height: 1000px;



}
</style>
