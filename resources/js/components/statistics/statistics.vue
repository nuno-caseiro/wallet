<template>
    <div>
        <b-button v-b-toggle.getTotalMovsBetweenDates>Total movements between dates</b-button>

        <b-button v-b-toggle.getTotalMoneyMovedByUsersBetweenYears @click="showInputYears=!showInputYears">Total money moved by users between years </b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersAllDaysOfMonth @click="showInputDate=!showInputDate">Total money moved by users on one month </b-button>

        <b-button v-b-toggle.getTotalInternalTransfersBetweenYears @click="showInputYears=!showInputYears">Total internal movements between years </b-button>
        <b-button v-b-toggle.getTotalInternalTransfersAllDaysOfMonth @click="showInputDate=!showInputDate">Total internal movements of one month </b-button>

        <b-button v-b-toggle.getTotalMoneyExternalAllDaysOfMonth @click="showInputYears=!showInputYears">Total external income one month </b-button>
        <b-button v-b-toggle.getTotalMoneyExternalBetweenYears @click="showInputDate=!showInputDate">Total external income between years </b-button>



        <b-collapse id="getTotalMoneyMovedByUsersBetweenYears">
            <button @click.prevent="totalMoneyMovedByUsersByMonthYear()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalMoneyMovedByUsersAllDaysOfMonth">
            <button @click.prevent="totalMoneyMovedByUsersAllDaysOfMonth()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalMoneyExternalAllDaysOfMonth">
            <button @click.prevent="totalMovementsFromExternalIncomesByAllDaysOfMonth()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalMoneyExternalBetweenYears">
            <button @click.prevent="totalMovementsFromExternalIncomesBetweenYears()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalInternalTransfersAllDaysOfMonth">
            <button @click.prevent="totalInternalTransfersAllDaysOfMonth()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalInternalTransfersBetweenYears">
            <button @click.prevent="totalInternalTransfersBetweenYears()" class="btn btn-info">Get</button>
        </b-collapse>

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
            totalMoneyMovedByUsersByMonthYear(){

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
            totalMovementsFromExternalIncomesBetweenYears() {

                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalMoneyFromExternalIncomesBetweenYears?startYear=' + this.year + '&stopYear=' + this.stopYear).then(response => {
                    console.log(response);
                    this.linedata.labels = [];
                    this.linedata.datasets = [];
                    let data = [];
                    let dates = [];

                    for (let i = 0; i < response.data.length; i++) {
                        data.push(response.data[i].total_movs);
                    }

                    for (let i = 0; i < response.data.length; i++) {
                        dates.push(response.data[i].year_month);
                    }

                    this.linedata.labels = dates;
                    this.linedata.datasets.push({
                        label: 'Total money moved by users between year ' + this.year + ' and ' + this.stopYear,
                        data: data
                    });

                    this.show = true;
                });
            },
            totalMovementsFromExternalIncomesByAllDaysOfMonth() {
                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalMovementsFromExternalIncomesByAllDaysOfMonth?date=' +this.date ).then(response => {
                    console.log(response);
                    this.linedata.labels = [];
                    this.linedata.datasets = [];
                    let data = [];
                    let dates = [];

                    for (let i = 0; i < response.data.length; i++) {
                        data.push(response.data[i].total_movs);
                    }

                    for (let i = 0; i < response.data.length; i++) {
                        dates.push(response.data[i].day_month);
                    }

                    this.linedata.labels = dates;
                    this.linedata.datasets.push({
                        label: 'Total movements of month by day:'+this.date ,
                        data: data
                    });

                    this.show = true;

                });
            },
            totalInternalTransfersAllDaysOfMonth() {
                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalInternalTransfersAllDaysOfMonth?date=' +this.date ).then(response => {
                    console.log(response);
                    this.linedata.labels = [];
                    this.linedata.datasets = [];
                    let data = [];
                    let dates = [];

                    for (let i = 0; i < response.data.length; i++) {
                        data.push(response.data[i].total_movs);
                    }

                    for (let i = 0; i < response.data.length; i++) {
                        dates.push(response.data[i].day_month);
                    }

                    this.linedata.labels = dates;
                    this.linedata.datasets.push({
                        label: 'Total internal transfers of all days of month:'+this.date ,
                        data: data
                    });

                    this.show = true;

                });
            },
            totalInternalTransfersBetweenYears() {

                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalInternalTransfersBetweenYears?startYear=' + this.year + '&stopYear=' + this.stopYear).then(response => {
                    console.log(response);
                    this.linedata.labels = [];
                    this.linedata.datasets = [];
                    let data = [];
                    let dates = [];

                    for (let i = 0; i < response.data.length; i++) {
                        data.push(response.data[i].total_movs);
                    }

                    for (let i = 0; i < response.data.length; i++) {
                        dates.push(response.data[i].year_month);
                    }

                    this.linedata.labels = dates;
                    this.linedata.datasets.push({
                        label: 'Total internal transfers between year ' + this.year + ' and ' + this.stopYear,
                        data: data
                    });

                    this.show = true;
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
    max-width: 2000px;
    max-height: 2000px;



}
</style>
