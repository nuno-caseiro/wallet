<template>
    <div>

        <b-button  @click="showInputYears=!showInputYears,toggleExpensesAllDaysMonth=!toggleExpensesAllDaysMonth">Total money moved by users between years </b-button>
        <b-button  @click="showInputYears=!showInputYears,toggleExpensesBetweenYears=!toggleExpensesBetweenYears">Total money moved by users between years </b-button>


        <div v-if="showInputDate" >
            <label>Date:</label>
            <input type="date" v-model="date">
        </div>

        <div v-if="showInputYears">
            <label>Years: </label>
            <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
            <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
        </div>

        <line-chart id="chart" v-if="this.show===true" :chartdata="linedata" :options="options" ></line-chart>

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
                toggleExpensesAllDaysMonth:false,
                toggleExpensesBetweenYears:false,

                showInputDate:false,
                showInputYears:false,
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
                year:"",
                stopYear:"",
                date:"",

            }
        },
        methods: {

            totalMoneyExpensesAllDaysOfMonth() {
                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalMoneyExpensesAllDaysOfMonth?date=' +this.date ).then(response => {
                    console.log(response);
                    this.linedata.labels = [];
                    this.linedata.datasets = [];
                    let data = [];
                    let dates = [];

                    for (let i = 0; i < response.data.length; i++) {
                        data.push(response.data[i].total_money);
                    }

                    for (let i = 0; i < response.data.length; i++) {
                        dates.push(response.data[i].day_month);
                    }

                    this.linedata.labels = dates;
                    this.linedata.datasets.push({
                        label: 'Total money',
                        data: data
                    });

                    this.show = true;

                });
            },
            totalMoneyExpensesByUserBetweenYears(){

                if(this.show==true){
                    this.show=false;
                }
                axios.get('/api/movements/all/totalMoneyMovedByUsersBetweenYears?startYear=' + this.year+'&stopYear='+this.stopYear).then(response => {
                    console.log(response);
                    this.linedata.labels=[];
                    this.linedata.datasets=[];
                    let data=[];
                    let dates=[];

                    for(let i=0;i<response.data.length;i++){
                        data.push(response.data[i].total_money);
                    }

                    for(let i=0;i<response.data.length;i++){
                        dates.push(response.data[i].year_month);
                    }

                    this.linedata.labels=dates;
                    this.linedata.datasets.push({
                        label: 'Total money moved by users between year '+this.year+' and '+this.stopYear,
                        data:data
                    });

                    this.show=true;
                });
            },


        }
    }
</script>

<style scoped>
    #chart {
        max-width: 2000px;
        max-height: 2000px;
    }
</style>
