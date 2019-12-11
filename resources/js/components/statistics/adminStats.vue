<template>
    <div>
        <a @click.prevent="getUsersLogins('1')" class="btn btn-info"></a>
        <line-chart v-if="this.show===true" :chartdata="linedata" :options="options" ></line-chart>
    </div>
</template>

<script>
    import lineChart from "./lineChart.vue";
    export default {
        components:{
            lineChart
        },
        name: "statistics",
        data() {
            return {
                show: false,
                linedata:{
                    labels:[/*'Monday', 'Tuesday', 'Wednesday','Thursday', 'Friday'*/],
                    datasets:[/*{
                        fill:false,
                        label:'John Doe',
                        borderColor: '#f87979',
                        data: [12,24,23,34,31]
                    }*/]
                },
                options:{
                    responsive: true,
                    maintainAspectRation: false,
                }
            }
        },
        methods: {
            getUsersLogins(month){
//just for testing
                axios.get('api/oauth_access_tokens')
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
            }
        }

    }
</script>

<style scoped>

</style>
