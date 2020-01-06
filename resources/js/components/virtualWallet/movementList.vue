<template  >
<div>
    <div>
        <filter-view @apply-Filter="applyFilter" v-on:clean-filter="cleanFilter"></filter-view>
    </div>
    <div >
        <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]"
                class="page-item"><a class="page-link" href="#"
                                     @click="getMovements(pagination.prev_page_url,'previous')">Previous</a></li>

            <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

            <li v-bind:class="[{disabled: !pagination.next_page_url}]"
                class="page-item"><a class="page-link" href="#"
                                     @click="getMovements(pagination.next_page_url,'next')">Next</a></li>
        </ul>
        <table class="table table-striped" >
            <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Source Email</th>
                <th>Destination Email</th>
                <th>Payment Type</th>
                <th>Category</th>
                <th>Date</th>
                <th>Start Balance</th>
                <th>End Balance</th>
                <th>Value</th>
                <th>Actions</th>

            </tr>
            </thead>
            <tbody >
            <tr v-for="movement in movements" :key="movement.id" :class="{active: selectedMovement === movement}">
                <td>{{ movement.id }}</td>
                <td v-if="movement.type ==='e'">{{ movement.type ==='e'? 'Expense': '' }}</td>
                <td v-if="movement.type ==='i'">{{ movement.type ==='i'? 'Income': '' }}</td>
                <td>{{  movement.transfer===1 && movement.type=='i'?movement.wallet_email_source : ' - ' }}</td>
                <td>{{  movement.transfer===1 && movement.type=='e'?movement.wallet_email_source : ' - ' }}</td>
                <td v-if="movement.type_payment==='c' && movement.transfer===0">{{movement.type_payment==='c'? 'Cash' : ' - '}}</td>
                <td v-if="movement.type_payment==='mb'&& movement.transfer===0">{{movement.type_payment==='mb'? 'MB payment' : ' - '}}</td>
                <td v-if="movement.type_payment==='bt'&& movement.transfer===0">{{movement.type_payment==='bt'? 'Bank Transfer' : ' - '}}</td>
                <td v-if="movement.type_payment===null">{{movement.type_payment===null? ' - ':''}}</td>
                <td>{{ movement.category_name}}</td>
                <td>{{ movement.date }}</td>
                <td>{{ movement.start_balance}}</td>
                <td>{{ movement.end_balance }}</td>
                <td>{{ movement.value }}</td>

                <td>
                    <b-button-group>
                        <b-button  variant="warning" @click.prevent="editMovement(movement)">Edit</b-button>
                        <b-button  variant="info" @click.prevent="transferInfo(movement)">Info</b-button>
                    </b-button-group>
                </td>

            </tr>
            </tbody>
        </table>
    </div>

</div>
</template>



<script type="text/javascript">
import axios from 'axios';
import MovementFilter from './movementsFilter.vue';

export default {
   // props: ['movements'],
    data() {
        return {
            selectedMovement: null,
            currentMovement:{},
            id:'',
            pagination: {},
            movements: [],
            filters:null,

        }
    },
    sockets:{
        message_from_user(dataFromServer){
            console.log("Update list");
            console.log(dataFromServer);
            axios.get('api/movements/id/' + dataFromServer[2].id)
                .then(response=>{
                    console.log(response);
                    this.movements=response.data.data;
                    this.$emit('refresh-wallet');
                }).catch(function(err){
                console.log(err);
            })

        }
    },
   methods:{
        applyFilter(filters,move){
            this.filters=filters;
            //string builder
            let stringFilter='?';
            if(filters.id !=''){
                stringFilter+='id='+filters.id;
            }
            if(filters.type!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='type='+filters.type;
            }

            if(filters.date1!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='date1='+filters.date1;
            }

            if(filters.date2!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='date2='+filters.date2;
            }

            if(filters.category_id!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='category_id='+filters.category_id;
            }

            if(filters.source_email!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='wallet_id='+this.$store.state.user.id+ '&transfer_wallet_id='+filters.source_email+'&transfer=1'+'&type=i'; //
            }


            if(filters.dest_email!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='wallet_id='+this.$store.state.user.id+ '&transfer_wallet_id='+filters.dest_email+'&transfer=1'+'&type=e'; //
            }

            if(move==="next"){
//                console.log(this.pagination.next_page_url);
                if(this.pagination.next_page_url.includes("page") ){
                    let substring =this.pagination.next_page_url.split("?");
                    console.log(substring);
                    stringFilter+='&'+substring[1];
                    console.log(stringFilter);
                }
            }
            if(move==="previous"){
              //  console.log(this.pagination.prev_page_url);
                if(this.pagination.prev_page_url.includes("page") ){
                    let substring =this.pagination.prev_page_url.split("?");
                    console.log(substring[1]);
                    stringFilter+='&'+substring[1];
                    console.log(stringFilter);
                }
            }




            console.log(stringFilter);
            axios.get('api/movements/1/filter/'+stringFilter +'&wallet_id='+ this.$store.state.user.id)
                .then(response => {
                    console.log(response);
                    this.movements = response.data.data;
                    this.makePagination(response.data.meta, response.data.links);

                })

        },
		editMovement(movement){

            this.$emit('edit-movement', movement);
        },
        transferInfo(movement){

            this.$emit('transfer-info', movement);
        },

         getMovements(url,move) {
            //if move e tal apply filter
             if(move==="next"){
                 console.log(this.pagination.next_page_url);
                 if(this.pagination.next_page_url.includes("filter")){
                    this.applyFilter(this.filters,'next');
                 }

             }else if(move==="previous"){
                 console.log(this.pagination.prev_page_url);
                 if(this.pagination.prev_page_url.includes("filter")){
                     this.applyFilter(this.filters,'previous');
                 }

             }

             if(this.filters===null){

                var id=this.$store.state.user.id;
                let page_url = url || '/api/movements/id/' + id;
               axios.get(page_url)
                .then(response => {
                    console.log(response);
                    this.movements = response.data.data;
                    this.makePagination(response.data.meta, response.data.links);
                })
             }
             console.log(this.movements);
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            };
            this.pagination = pagination
        },
         cleanFilter(){
            this.filters=null;
            this.getMovements();

        }
   },

   computed:{
            isUser(){
                return this.$store.getters.isUser;
            },
    },

    mounted() {
        this.getMovements();
    },
    components:{
        'filter-view' :MovementFilter
    }

}
</script>
<style  scoped >

</style>
