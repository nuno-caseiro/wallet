<template>
    <div>
<<<<<<< Updated upstream
        <b-button v-b-toggle.getTotalMovsBetweenDates>Total movements between dates</b-button>
=======

        <table class="table table-striped" >
        <thead>
            <tr><th></th>
                <th>User Accesses</th>
                <th>Active Users</th>
                <th>Movements</th>
                <th>Platform Money</th>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td>Total</td>
                <td>{{ totalAccesses }}</td>
                <td>{{ totalActiveUsers }}</td>
                <td>{{ totalMovements }}</td>
                <td>{{ totalMoney}}</td>
            </tr>
        </tbody>
        </table>


        <div role="tablist">
            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMovsBetweenDates variant="info">Total movements between dates</b-button>
            </b-card-header>
            <b-collapse id="getTotalMovsBetweenDates" visible accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Date (yyyy-mm-dd,yyyy-mm-dd)</label>
                <input class="form-control" type="text" v-model="data.dates" >
                <button @click.prevent="getTotalMovsBetweenDates(data.dates)" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyMovedByUsersByMonthYear variant="info">Total money moved by users between years</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyMovedByUsersByMonthYear" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Years: </label>
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                <button @click.prevent="totalMoneyMovedByUsersByMonthYear()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyMovedByUsersAllDaysOfMonth variant="info">Total money moved by users on one month</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyMovedByUsersAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Date:</label>
                <input id="date" type="date" v-model="date">
                <button @click.prevent="totalMoneyMovedByUsersAllDaysOfMonth()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>
  </div>

        <!-- <b-button v-b-toggle.getTotalMovsBetweenDates>Total movements between dates</b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersByMonthYear>Total money moved by users between years </b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersAllDaysOfMonth>Total money moved by users on one month </b-button>
>>>>>>> Stashed changes

        <b-button v-b-toggle.getTotalMoneyMovedByUsersBetweenYears @click="showInputYears=!showInputYears">Total money moved by users between years </b-button>
        <b-button v-b-toggle.getTotalMoneyMovedByUsersAllDaysOfMonth @click="showInputDate=!showInputDate">Total money moved by users on one month </b-button>

<<<<<<< Updated upstream
        <b-button v-b-toggle.getTotalInternalTransfersBetweenYears @click="showInputYears=!showInputYears">Total internal movements between years </b-button>
        <b-button v-b-toggle.getTotalInternalTransfersAllDaysOfMonth @click="showInputDate=!showInputDate">Total internal movements of one month </b-button>
=======

        <b-collapse id="getTotalMovsBetweenDates">
                <label>Date (yyyy-mm-dd,yyyy-mm-dd)</label>
                <input class="form-control" type="text" v-model="data.dates" >
                <button @click.prevent="getTotalMovsBetweenDates(data.dates)" class="btn btn-info">Get</button>
            </b-collapse>
>>>>>>> Stashed changes

        <b-button v-b-toggle.getTotalMoneyExternalAllDaysOfMonth @click="showInputYears=!showInputYears">Total external income one month </b-button>
        <b-button v-b-toggle.getTotalMoneyExternalBetweenYears @click="showInputDate=!showInputDate">Total external income between years </b-button>



        <b-collapse id="getTotalMoneyMovedByUsersBetweenYears">
            <button @click.prevent="totalMoneyMovedByUsersByMonthYear()" class="btn btn-info">Get</button>
        </b-collapse>

        <b-collapse id="getTotalMoneyMovedByUsersAllDaysOfMonth">
            <button @click.prevent="totalMoneyMovedByUsersAllDaysOfMonth()" class="btn btn-info">Get</button>
        </b-collapse> -->

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
                totalActiveUsers:"",
                totalAccesses:"",
                totalMovements:"",
                totalMoney:"",
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

        totalOfActiveUsers() {
            axios.get('/api/movements/all/totalActiveUsers')
            .then(response => {
                console.log(response);
                this.totalActiveUsers = response.data[0].total_users;
            

            });
        },

        totalOfAccesses() {
            axios.get('/api/oauth_access_tokens/all/totalAccesses')
            .then(response => {
                console.log(response);
                this.totalAccesses = response.data[0].total_accesses;
            

            });
        },

        totalOfMovements() {
            axios.get('/api/movements/all/totalMovements')
            .then(response => {
                console.log(response);
                this.totalMovements = response.data[0].total_movs;
            

            });
        },
        
        totalMoneyOfPlatform() {
            axios.get('/api/wallets/all/totalMoneyOnPlatform')
            .then(response => {
                console.log(response);
                this.totalMoney = response.data[0].total_money;
            

            });
        },

        },

        mounted(){
            this.totalOfActiveUsers();
            this.totalOfAccesses();
            this.totalOfMovements();
            this.totalMoneyOfPlatform();
        }


    }
</script>

<style scoped>
#chart {
    max-width: 2000px;
    max-height: 2000px;



}
</style>
