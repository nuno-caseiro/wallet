<template>
    <div>
        <b-button v-b-toggle.getTotalMovsBetweenDates>Total movements between dates</b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersByYear>Total money moved by users per year </b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersByMonthYear>Total money moved by users between years </b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersAllDaysOfMonth>Total money moved by users on one month </b-button>


        <b-collapse id="getTotalMovsBetweenDates">
                <label>Date (yyyy-mm-dd,yyyy-mm-dd)</label>
                <input class="form-control" type="text" v-model="data.dates" >
                <button @click.prevent="getTotalMovsBetweenDates(data.dates)" class="btn btn-info">Get</button>
            </b-collapse>


        <b-collapse id="getTotalMoneyMovedByUsersByYear">
            <label>Year (yyyy)</label>
            <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
            <button @click.prevent="totalMoneyMovedByUsersByYear()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalMoneyMovedByUsersByMonthYear">
            <label>Year (yyyy)</label>
            <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
            <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
            <button @click.prevent="totalMoneyMovedByUsersByMonthYear()" class="btn btn-info">Get</button>
        </b-collapse>



        <b-collapse id="getTotalMoneyMovedByUsersAllDaysOfMonth">
            <label>Year (yyyy)</label>
            <input id="date" type="date" v-model="date">
            <button @click.prevent="totalMoneyMovedByUsersAllDaysOfMonth()" class="btn btn-info">Get</button>
        </b-collapse>

        <div id="chart">
        <line-chart v-if="this.show===true" :chartdata="linedata" :options="options" ></line-chart>
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
                year:"",
                stopYear:"",
                date:"",

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
            axios.get('/api/movements/totalMovements/' + dates).then(response => {
                console.log(response);
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

                this.show=true;

                });
            },

            totalMoneyMovedByUsersByYear(){

                if(this.show==true){
                    this.show=false;
                }
                axios.get('/api/movements/all/totalMoneyMovedByUsersByMonthOfYear?year='+this.year).then(response => {
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
                        label: 'Total money',
                        data:data
                    });

                    this.show=true;
                });
            },

            totalMoneyMovedByUsersByMonthYear(){

                if(this.show==true){
                    this.show=false;
                }
                axios.get('/api/movements/all/totalMoneyMovedByUsersByMonth?startYear=' + this.year+'&stopYear='+this.stopYear).then(response => {
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
                        label: 'Total money',
                        data:data
                    });

                    this.show=true;
                });
            },

        totalMoneyMovedByUsersAllDaysOfMonth() {
            if (this.show == true) {
                this.show = false;
            }
            axios.get('/api/movements/all/totalMoneyMovedByUsersAllDaysOfMonth?date=' +this.date ).then(response => {
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
        },



    }
</script>

<style scoped>
#chart {
    max-width: 1000px;
    max-height: 1000px;



}
</style>
