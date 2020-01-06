<template>
    <div>

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
                <b-button block href="#" v-b-toggle.getTotalMoneyMovedByUsersBetweenYears variant="info">Total Money Moved By Users Between Years</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyMovedByUsersBetweenYears" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Years: </label>
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                <button @click.prevent="totalMoneyMovedByUsersBetweenYears()" class="btn btn-info">Get</button>
                    <a class="alert-danger">You need to fill both years ex: 2018 2018, 2018 2020 </a>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyMovedByUsersAllDaysOfMonth variant="info">Total Money Moved By Users On One Month</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyMovedByUsersAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Date:</label>
                <input id="date" type="date" v-model="date">
                <button @click.prevent="totalMoneyMovedByUsersAllDaysOfMonth()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>



            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalInternalTransfersBetweenYears variant="info">Total Internal Transfers Between Years</b-button>
            </b-card-header>
            <b-collapse id="getTotalInternalTransfersBetweenYears" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Years: </label>
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                <button @click.prevent="totalInternalTransfersBetweenYears()" class="btn btn-info">Get</button>
                    <a class="alert-danger">You need to fill both years ex: 2018 2018, 2018 2020 </a>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalInternalTransfersAllDaysOfMonth variant="info">Total Internal Transfers All Days Of Month</b-button>
            </b-card-header>
            <b-collapse id="getTotalInternalTransfersAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Date:</label>
                <input id="date" type="date" v-model="date">
                <button @click.prevent="totalInternalTransfersAllDaysOfMonth()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>


            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyExternalBetweenYears variant="info">Total Movements From External Incomes Between Years</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyExternalBetweenYears" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Years: </label>
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                <button @click.prevent="totalMovementsFromExternalIncomesBetweenYears()" class="btn btn-info">Get</button>
                    <a class="alert-danger">You need to fill both years ex: 2018 2018, 2018 2020 </a>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyExternalAllDaysOfMonth variant="info">Total Movements From External Incomes By All Days Of Month</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyExternalAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Date:</label>
                <input id="date" type="date" v-model="date">
                <button @click.prevent="totalMovementsFromExternalIncomesByAllDaysOfMonth()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>


        <a class="alert-danger" v-if="show!=true">Could take a while to get charts </a>
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
        validations:{
            year:'',
            stopYear:'',
            date:'',
        },
        methods: {
            totalMoneyMovedByUsersBetweenYears(){

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
                axios.get('/api/movements/all/totalMovementsFromExternalIncomesBetweenYears?startYear=' + this.year + '&stopYear=' + this.stopYear).then(response => {
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
                        label: 'Total movements from external incomes between year ' + this.year + ' and ' + this.stopYear,
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
                        dates.push(response.data[i].year_month);
                    }

                    this.linedata.labels = dates;
                    this.linedata.datasets.push({
                        label: 'Total movements from external incomes by all days of month '+ this.date ,
                        data: data
                    });

                    this.show = true;

                });
            },
            totalInternalTransfersAllDaysOfMonth() {
                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalInternalTransfersAllDaysOfMonth?date=' + this.date ).then(response => {
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
                        label: 'Total internal transfers of all days of month'+ this.date ,
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
            axios.get('/api/movements/all/totalMoneyMovedByUsersAllDaysOfMonth?date=' + this.date ).then(response => {
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
                    label: 'Total money moved by users of all days of month',
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
