<template>
    <div>

        <table class="table table-striped" >
        <thead>
            <tr>
                <th></th>
                <th>Expenses</th>
                <th>Incomes</th>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td>Total</td>
                <td>{{expenses}}</td>
                <td>{{incomes}}</td>

            </tr>
        </tbody>
        </table>

        <div role="tablist">

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyExpensesOfUserBetweenYears variant="info">Total Money Of Expenses Between Years</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyExpensesOfUserBetweenYears" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Years: </label>
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                <button @click.prevent="totalMoneyExpensesOfUserBetweenYears()" class="btn btn-info">Get</button>
                    <a class="alert-danger">You need to fill both years ex: 2018 2018, 2018 2020 </a>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyExpensesAllDaysOfMonth variant="info">Total Money of Expenses All Days Of Month</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyExpensesAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                <b-card-body>
               <label>Date:</label>
                <input id="date" type="date" v-model="date">
                <button @click.prevent="totalMoneyExpensesAllDaysOfMonth()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyIncomesOfUserBetweenYears variant="info">Total Money Of Incomes Between Years</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyIncomesOfUserBetweenYears" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                <label>Years: </label>
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                    <button @click.prevent="totalMoneyIncomesOfUserBetweenYears()" class="btn btn-info">Get</button>
                    <a class="alert-danger">You need to fill both years ex: 2018 2018, 2018 2020 </a>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.getTotalMoneyIncomesAllDaysOfMonth variant="info">Total Money of Incomes All Days Of Month</b-button>
            </b-card-header>
            <b-collapse id="getTotalMoneyIncomesAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                <b-card-body>
               <label>Date:</label>
                <input id="date" type="date" v-model="date">
                <button @click.prevent="totalMoneyIncomesAllDaysOfMonth()" class="btn btn-info">Get</button>
                </b-card-body>
            </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block href="#" v-b-toggle.balanceThroughTimeBetweenYears variant="info">Balance Over Years</b-button>
                </b-card-header>
                <b-collapse id="balanceThroughTimeBetweenYears" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <label>Years: </label>
                        <input type="number" min="2014" max="2020" step="1" value="2020" v-model="year" />
                        <input type="number" min="2014" max="2020" step="1" value="2020" v-model="stopYear" />
                        <button @click.prevent="balanceThroughTimeBetweenYears()" class="btn btn-info">Get</button>
                        <a class="alert-danger">You need to fill both years ex: 2018 2018, 2018 2020 </a>

                    </b-card-body>
                </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block href="#" v-b-toggle.balanceThroughTimeAllDaysOfMonth variant="info">Balance Over All Days Of Month</b-button>
                </b-card-header>
                <b-collapse id="balanceThroughTimeAllDaysOfMonth" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <label>Date:</label>
                        <input id="date" type="date" v-model="date">
                        <button @click.prevent="balanceThroughTimeAllDaysOfMonth()" class="btn btn-info">Get</button>
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
                visibleTable:false,
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
                expenses:"",
                incomes:"",

            }
        },
        methods: {

            totalMoneyExpensesAllDaysOfMonth() {
                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalMoneyExpensesAllDaysOfMonth?date=' +this.date +'&wallet_id='+ this.$store.state.user.id ).then(response => {
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
                        label: 'Total money expent by you over all days of month'+ this.date,
                        data: data
                    });

                    this.show = true;

                });
            },
            totalMoneyExpensesOfUserBetweenYears(){

                if(this.show==true){
                    this.show=false;
                }
                axios.get('/api/movements/all/totalMoneyExpensesOfUserBetweenYears?startYear=' + this.year+'&stopYear='+this.stopYear +'&wallet_id='+ this.$store.state.user.id).then(response => {
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
                        label: 'Total money expent by you between year '+this.year+' and '+this.stopYear,
                        data:data
                    });

                    this.show=true;
                });
            },


            totalMoneyIncomesOfUserBetweenYears(){

                if(this.show==true){
                    this.show=false;
                }
                axios.get('/api/movements/all/totalMoneyIncomesOfUserBetweenYears?startYear=' + this.year+'&stopYear='+this.stopYear +'&wallet_id='+ this.$store.state.user.id).then(response => {
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
                        label: 'Total money that you received between year '+ this.year+' and '+this.stopYear,
                        data:data
                    });

                    this.show=true;
                });
            },

            totalMoneyIncomesAllDaysOfMonth(){

                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/totalMoneyIncomesAllDaysOfMonth?date=' + this.date +'&wallet_id='+ this.$store.state.user.id ).then(response => {
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
                        label: 'Total money that you received over all days of month'+ this.date,
                        data: data
                    });

                    this.show = true;

                });
            },

            balanceThroughTimeAllDaysOfMonth(){

                if (this.show == true) {
                    this.show = false;
                }
                axios.get('/api/movements/all/balanceThroughTimeAllDaysOfMonth?date=' + this.date +'&wallet_id='+ this.$store.state.user.id ).then(response => {
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
                        label: 'Balance of your wallet over all days of month' + this.date,
                        data: data
                    });

                    this.show = true;

                });
            },
            balanceThroughTimeBetweenYears(){

                if(this.show==true){
                    this.show=false;
                }
                axios.get('/api/movements/all/balanceThroughTimeBetweenYears?startYear=' + this.year+'&stopYear='+this.stopYear +'&wallet_id='+ this.$store.state.user.id).then(response => {
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
                        label: 'Balance of your wallet between'+ this.year+' and '+ this.stopYear,
                        data:data
                    });

                    this.show=true;
                });
            },

            totalExpenses() {
            axios.get('/api/statistics/all/totalExpensesOfUser/' + this.$store.state.user.id)
            .then(response => {
                console.log(response);
                this.expenses = response.data[0].total_expenses;


            });
            },

            totalIncomes() {
            axios.get('/api/statistics/all/totalIncomesOfUser/' + this.$store.state.user.id)
            .then(response => {
                console.log(response);
                this.incomes = response.data[0].total_incomes;


            });
            },


        },
        mounted(){
            this.totalExpenses();
            this.totalIncomes();
        }



    }
</script>

<style scoped>
    #chart {
        max-width: 2000px;
        max-height: 2000px;
    }
</style>
